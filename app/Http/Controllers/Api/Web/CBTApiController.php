<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CBTApiController extends Controller
{

    public function pullCandidate(Request $request){
        try {
            $headers = [
                'Authorization' => 'Bearer your-token-here',
                'Accept' => 'application/json',
                'Custom-Header' => 'custom-value'
            ];
            
            $response = Http::withHeaders($headers)->get('https://app.chprbn.gov.ng/push-candidate');
            
            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch candidates from external API'], 500);
            }
            
            $candidates = $response->json();
            
            if (empty($candidates)) {
                return response()->json(['message' => 'No candidates found'], 200);
            }
            
            $updatedCount = 0;
            foreach(array_chunk($candidates, 1000) as $key => $candidateBatch){
                if(Candidate::upsert($candidateBatch, ['indexing'])) {
                    $updatedCount += count($candidateBatch);
                } else {
                    reset_auto_increment('candidates');
                }
            }
            
            return response()->json([
                'message' => 'Candidates updated successfully', 
                'count' => $updatedCount
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error pulling candidates: ' . $e->getMessage()], 500);
        }
    }

    public function summary_reports(Request $request){
        $graduands = Graduand::selectRaw("
            candidates.indexing, 
            candidates.cadre_id as programme_id,
            candidates.firstname,
            candidates.surname,
            candidates.othernames as other_names,
            candidates.gender,
            candidates.dob,
            candidates.lga_id,
            156 as country_id,
            graduands.year as exam_year,
            candidates.surname as password,
            '' as nin,
            '' as remember_token,
            '' as api_token,
            1 as enabled,
            candidates.id as registration_id,
            IF(graduands.remark = 'resit', 2, 1) as attempt
        ")
        ->where(['graduands.status'=>'submitted', 'pushed'=>'0'])
        ->join('candidates','candidates.id', 'graduands.candidate_id')
        // ->limit(500)
        ->get();

        // return $graduands;
        $headers = [
            'Authorization' => 'Bearer your-token-here',
            'Accept' => 'application/json',
            'Custom-Header' => 'custom-value'
        ];
        return $response = Http::withHeaders($headers)->post('https://zxcvbnm.chprbn.gov.ng/pull-candidate',['graduands'=>$graduands]);
        if ($response->successful()) {
            return $response;
        }
    }


    public function generateCandidatePicture(Request $request)
    {
        try {
            set_time_limit(300); // 5 minutes timeout
            
            // Get year from request or use current year
            $year = $request->input('year', date('Y'));
            
            // Get candidates without passport photos
            $candidate_pictures = Candidate::candidateWithoutPassport($year);
            $candidate_ids = $candidate_pictures['candidate_ids'];
            
            if (empty($candidate_ids)) {
                return response()->json([
                    'success' => true,
                    'message' => 'No candidates without images found',
                    'processed' => 0,
                    'remaining' => 0,
                    'total' => Candidate::where('exam_year', $year)->count()
                ]);
            }
            
            // Process in batches to avoid timeouts and memory issues
            $batchSize = $request->input('batch_size', 20);
            $candidate_ids = array_slice($candidate_ids, 0, $batchSize);
            
            $headers = [
                'Authorization' => 'Bearer your-token-here',
                'Accept' => 'application/json',
                'Custom-Header' => 'custom-value'
            ];
            
            // Make API request with timeout
            $response = Http::timeout(120)->withHeaders($headers)
                ->post('https://app.chprbn.gov.ng/generate-candidate-passport', [
                    'indexings' => $candidate_ids
                ]);
            
            if (!$response->successful()) {
                Log::error('Generate candidate pictures API failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate images from external API'
                ], 500);
            }
            
            $candidatesData = $response->json();
            $processed = 0;
            $errors = [];
            
            // Ensure passport directory exists
            $passportDir = public_path(candidate_passport_path());
            if (!File::exists($passportDir)) {
                File::makeDirectory($passportDir, 0755, true);
            }
            
            foreach ($candidatesData as $candidate) {
                try {
                    // Validate required data
                    if (!isset($candidate['photo']) || !isset($candidate['indexing'])) {
                        $errors[] = 'Missing photo or indexing data for candidate';
                        continue;
                    }
                    
                    $indexing = $candidate['indexing'];
                    $photoData = $candidate['photo'];
                    
                    // Prepare file path
                    $fileName = str_replace('/', '_', $indexing) . '.jpg';
                    $location = $passportDir . '/' . $fileName;
                    
                    // Decode and validate image data
                    $imageData = base64_decode($photoData);
                    if ($imageData === false) {
                        $errors[] = "Invalid base64 image data for candidate {$indexing}";
                        continue;
                    }
                    
                    // Create image from string
                    $source = imagecreatefromstring($imageData);
                    if ($source === false) {
                        $errors[] = "Could not create image from data for candidate {$indexing}";
                        continue;
                    }
                    
                    // Save image with better quality (80% instead of 40%)
                    if (imagejpeg($source, $location, 80)) {
                        $processed++;
                        Log::info("Generated image for candidate: {$indexing}");
                    } else {
                        $errors[] = "Failed to save image for candidate {$indexing}";
                    }
                    
                    // Free memory
                    imagedestroy($source);
                } catch (\Exception $e) {
                    $candidateId = $candidate['indexing'] ?? 'unknown';
                    $errorMsg = "Error processing image for candidate {$candidateId}: " . $e->getMessage();
                    $errors[] = $errorMsg;
                    Log::error($errorMsg, ['exception' => $e]);
                }
            }
            
            // Get updated statistics
            $remaining_stats = Candidate::candidateWithoutPassport($year);
            $total_candidates = Candidate::where('exam_year', $year)->count();
            
            $response = [
                'success' => true,
                'message' => "Generated {$processed} candidate images" . 
                    (count($errors) > 0 ? " with " . count($errors) . " errors" : ""),
                'processed' => $processed,
                'remaining' => $remaining_stats['total'],
                'total_candidates' => $total_candidates,
                'errors' => $errors
            ];
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            Log::error('Generate candidate pictures failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error generating candidate images: ' . $e->getMessage()
            ], 500);
        }
    }


    //for centre server pulling
    public function pullCandidatePictures(Request $request)
    {
        try {
            set_time_limit(300); // 5 minutes timeout
            
            // Get year from request or use current year
            $year = $request->input('year', date('Y'));
            
            // Get candidates without passport photos
            $candidate_pictures = Candidate::candidateWithoutPassport($year);
            $candidate_ids = $candidate_pictures['candidate_ids'];
            $total_without_images = $candidate_pictures['total'];
            
            if (empty($candidate_ids)) {
                $total_candidates = Candidate::where('exam_year', $year)->count();
                return response()->json([
                    'success' => true,
                    'message' => 'No candidates without images found',
                    'downloaded' => $total_candidates,
                    'total' => $total_candidates,
                    'data' => $total_candidates . '/' . $total_candidates
                ]);
            }
            
            // Process in batches to avoid timeouts and memory issues
            $batchSize = $request->input('batch_size', 50);
            $candidate_ids = array_slice($candidate_ids, 0, $batchSize);
            
            $headers = [
                'Authorization' => 'Bearer your-token-here',
                'Accept' => 'application/json',
                'Custom-Header' => 'custom-value'
            ];
            
            // Make API request with timeout
            $response = Http::timeout(120)->withHeaders($headers)
                ->post('https://zxcvbnm.chprbn.gov.ng/pull-picture', [
                    'indexings' => $candidate_ids
                ]);
            
            if (!$response->successful()) {
                Log::error('Pull candidate pictures API failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to pull images from external server'
                ], 500);
            }
            
            $candidatesData = $response->json();
            $processed = 0;
            $errors = [];
            
            // Ensure passport directory exists
            $passportDir = public_path(candidate_passport_path());
            if (!File::exists($passportDir)) {
                File::makeDirectory($passportDir, 0775, true);
            }
            
            foreach ($candidatesData as $candidate) {
                try {
                    // Handle both array and object formats
                    $candidateData = is_array($candidate) ? $candidate : (array) $candidate;
                    
                    // Validate required data
                    if (!isset($candidateData['photo']) || !isset($candidateData['indexing'])) {
                        $errors[] = 'Missing photo or indexing data for candidate';
                        continue;
                    }
                    
                    $indexing = $candidateData['indexing'];
                    $photoData = $candidateData['photo'];
                    
                    // Prepare file path
                    $fileName = str_replace('/', '_', $indexing) . '.jpg';
                    $location = $passportDir . '/' . $fileName;
                    
                    // Decode and validate image data
                    $imageData = base64_decode($photoData);
                    if ($imageData === false) {
                        $errors[] = "Invalid base64 image data for candidate {$indexing}";
                        continue;
                    }
                    
                    // Create image from string
                    $source = imagecreatefromstring($imageData);
                    if ($source === false) {
                        $errors[] = "Could not create image from data for candidate {$indexing}";
                        continue;
                    }
                    
                    // Save image with good quality
                    if (imagejpeg($source, $location, 80)) {
                        $processed++;
                        Log::info("Pulled image for candidate: {$indexing}");
                    } else {
                        $errors[] = "Failed to save image for candidate {$indexing}";
                    }
                    
                    // Free memory
                    imagedestroy($source);
                } catch (\Exception $e) {
                    $candidateData = is_array($candidate) ? $candidate : (array) $candidate;
                    $candidateId = $candidateData['indexing'] ?? 'unknown';
                    $errorMsg = "Error processing pulled image for candidate {$candidateId}: " . $e->getMessage();
                    $errors[] = $errorMsg;
                    Log::error($errorMsg, ['exception' => $e]);
                }
            }
            
            // Calculate final statistics
            $total_candidates = Candidate::where('exam_year', $year)->count();
            $final_pictures = Candidate::candidateWithoutPassport($year);
            $final_downloaded = $total_candidates - $final_pictures['total'];
            
            $message = "Successfully pulled {$processed} images. Total images: {$final_downloaded}/{$total_candidates}";
            if (count($errors) > 0) {
                $message .= " with " . count($errors) . " errors";
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'downloaded' => $final_downloaded,
                'total' => $total_candidates,
                'processed_this_batch' => $processed,
                'remaining' => $final_pictures['total'],
                'data' => $final_downloaded . '/' . $total_candidates,
                'errors' => $errors
            ]);
            
        } catch (\Exception $e) {
            Log::error('Pull candidate pictures failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error pulling candidate images: ' . $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        // Get unique exam years for filter
        $examYears = Candidate::select('exam_year')->distinct()->orderBy('exam_year', 'desc')->pluck('exam_year');
        
        // Get test codes for filter dropdown
        $testCodes = \App\Models\TestCode::orderBy('name')->get();
        
        return view('pages.admin.candidate.manage', compact('examYears', 'testCodes'));
    }

    public function getData(Request $request)
    {
        $query = Candidate::with('testCode');
        
        // Apply filters
        if ($request->filled('exam_year')) {
            $query->where('exam_year', $request->exam_year);
        }

        if ($request->filled('programme_id')) {
            $query->where('programme_id', $request->programme_id);
        }

        // Handle DataTables search
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function($q) use ($search) {
                $q->where('indexing', 'like', "%{$search}%")
                  ->orWhere('firstname', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%")
                  ->orWhere('other_names', 'like', "%{$search}%");
            });
        }

        // Get total records count
        $totalRecords = $query->count();

        // Handle ordering
        if ($request->filled('order')) {
            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');
            
            $columns = ['id', 'passport', 'actions', 'indexing', 'firstname', 'gender', 'dob', 'programme_id', 'exam_year', 'attempt', 'enabled', 'registration_id'];
            
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDirection);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Handle pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 50);
        
        $candidates = $query->skip($start)->take($length)->get();

        // Prepare data for DataTables
        $data = [];
        foreach ($candidates as $index => $candidate) {
            // Action buttons matching active.blade.php style
            $actionButtons = '
                <div class="btn-group dropend" role="group">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-popper-placement="right-start" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item view-candidate" data-id="'.$candidate->id.'" data-indexing="'.$candidate->indexing.'">
                            <i class="las la-eye"></i> View
                        </button>
                        <button class="dropdown-item edit-candidate" data-id="'.$candidate->id.'" data-indexing="'.$candidate->indexing.'">
                            <i class="las la-edit"></i> Edit
                        </button>
                        <button class="dropdown-item delete-candidate" data-id="'.$candidate->id.'" data-indexing="'.$candidate->indexing.'">
                            <i class="las la-trash"></i> Delete
                        </button>
                    </div>
                </div>';
            
            // Passport image
            $passportImage = '<img class="img-fluid table-avtar" src="' . $candidate->passport() . '" alt="Passport" style="border-radius: 50%; object-fit: cover;">';
            
            $data[] = [
                'DT_RowIndex' => "",
                'passport' => $passportImage,
                'actions' => $actionButtons,
                'indexing' => '<strong>' . $candidate->indexing . '</strong>',
                'fullname' => $candidate->fullname(),
                'gender' => $candidate->gender,
                'dob' => $candidate->dob,
                'test_code' => $candidate->testCode->name ?? 'N/A',
                'exam_year' => $candidate->exam_year,
                'attempt' => $candidate->attempt,
                'status' => $candidate->enabled 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-danger">Inactive</span>',
                'registration_id' => $candidate->registration_id
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }

    public function pullCandidates(Request $request)
    {
        try {
            // Increase time limit and memory for large datasets
            set_time_limit(600); // 10 minutes timeout
            ini_set('memory_limit', '512M'); // Increase memory limit
            
            $headers = [
                'Authorization' => 'Bearer your-token-here',
                'Accept' => 'application/json',
                'Custom-Header' => 'custom-value'
            ];
            
            // Try to fetch candidates with extended timeout and retry logic
            $response = null;
            $maxRetries = 3;
            $attempt = 1;
            
            while ($attempt <= $maxRetries && !$response) {
                try {
                    Log::info("Attempting to fetch candidates from external API (attempt {$attempt}/{$maxRetries})");
                    
                    // Increase timeout progressively: 180s, 240s, 300s
                    $timeout = 120 + ($attempt * 60);
                    
                    $response = Http::timeout($timeout)
                        ->connectTimeout(30)
                        ->withHeaders($headers)
                        ->retry(2, 1000) // Retry 2 times with 1 second delay
                        ->get('https://app.chprbn.gov.ng/push-candidate');
                    
                    if ($response && $response->successful()) {
                        Log::info("Successfully fetched candidates on attempt {$attempt}");
                        break;
                    } else {
                        $response = null;
                    }
                } catch (\Exception $e) {
                    Log::warning("API fetch attempt {$attempt} failed: " . $e->getMessage());
                    $response = null;
                }
                
                $attempt++;
                if ($attempt <= $maxRetries) {
                    Log::info("Waiting 5 seconds before retry...");
                    sleep(5); // Wait 5 seconds between attempts
                }
            }
            
            if (!$response || !$response->successful()) {
                $errorMsg = $response ? 
                    'Failed to fetch candidates from external API: ' . $response->status() :
                    'Failed to connect to external API after ' . $maxRetries . ' attempts';
                
                Log::error('All API fetch attempts failed', [
                    'attempts' => $maxRetries,
                    'final_response' => $response ? $response->status() : 'null'
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => $errorMsg . '. The external server may be experiencing issues or the dataset is too large. Please try again later.'
                ], 500);
            }
            
            try {
                $allCandidates = $response->json();
            } catch (\Exception $e) {
                Log::error('Failed to parse JSON response from external API', [
                    'error' => $e->getMessage(),
                    'response_size' => strlen($response->body())
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'The external API returned invalid data. The dataset may be too large or corrupted.'
                ], 500);
            }
            
            if (empty($allCandidates)) {
                return response()->json([
                    'success' => true,
                    'message' => 'No candidates found to pull from external source'
                ]);
            }
            
            Log::info('Successfully fetched candidates', ['count' => count($allCandidates)]);
            
            // Process all candidates at once
            DB::beginTransaction();
            $processedCount = 0;
            $errors = [];
            $totalCandidates = count($allCandidates);
            
            try {
                // Process in chunks of 100 for better performance
                foreach(array_chunk($allCandidates, 100) as $chunkIndex => $candidateChunk) {
                    try {
                        if(Candidate::upsert($candidateChunk, ['indexing'])) {
                            $processedCount += count($candidateChunk);
                        } else {
                            $errors[] = "Error processing chunk " . ($chunkIndex + 1);
                        }
                    } catch (\Exception $e) {
                        $errors[] = "Error in chunk " . ($chunkIndex + 1) . ": " . $e->getMessage();
                        Log::error('Candidate pull processing error', [
                            'chunk_index' => $chunkIndex,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }
                
                if (empty($errors)) {
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => "Successfully pulled and processed {$processedCount} candidates from external source"
                    ]);
                } else {
                    DB::rollback();
                    Log::error('Candidate pull had errors', ['errors' => $errors]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Some errors occurred while processing candidates: ' . implode(', ', array_slice($errors, 0, 3)) . (count($errors) > 3 ? '...' : '')
                    ], 500);
                }
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Candidate pull failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Error processing candidates: ' . $e->getMessage()
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Candidate pull operation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error pulling candidates: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $candidate = Candidate::with('testCode')->find($id);
            
            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Candidate not found'
                ], 404);
            }

            // Get scheduling information using direct database query to avoid relationship issues
            $schedules = DB::table('candidates')
                ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', '=', 'candidates.id')
                ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', '=', 'scheduled_candidates.id')
                ->join('schedulings', 'schedulings.id', '=', 'candidate_subjects.schedule_id')
                ->leftJoin('venues', 'venues.id', '=', 'schedulings.venue_id')
                ->leftJoin('centres', 'centres.id', '=', 'venues.centre_id')
                ->leftJoin('test_configs', 'test_configs.id', '=', 'schedulings.test_config_id')
                ->leftJoin('subjects', 'subjects.id', '=', 'candidate_subjects.subject_id')
                ->where('candidates.id', $id)
                ->select([
                    'centres.name as centre_name',
                    'venues.name as venue_name', 
                    'test_configs.session as test_session',
                    'subjects.name as subject_name',
                    'subjects.subject_code as subject_code',
                    'schedulings.date as schedule_date'
                ])
                ->get()
                ->map(function ($scheduling) {
                    return [
                        'centre' => $scheduling->centre_name ?? 'N/A',
                        'venue' => $scheduling->venue_name ?? 'N/A',
                        'test_config' => $scheduling->test_session ?? 'N/A',
                        'subject' => ($scheduling->subject_code ?? '') . ' - ' . ($scheduling->subject_name ?? 'N/A'),
                        'date' => $scheduling->schedule_date ?? 'N/A'
                    ];
                })
                ->toArray();

            $candidateData = [
                'id' => $candidate->id,
                'indexing' => $candidate->indexing,
                'firstname' => $candidate->firstname,
                'surname' => $candidate->surname,
                'other_names' => $candidate->other_names,
                'gender' => $candidate->gender,
                'dob' => $candidate->dob,
                'programme_id' => $candidate->programme_id,
                'test_code' => $candidate->testCode->name ?? 'N/A',
                'exam_year' => $candidate->exam_year,
                'attempt' => $candidate->attempt,
                'enabled' => $candidate->enabled,
                'registration_id' => $candidate->registration_id,
                'schedules' => $schedules,
                'nin' => $candidate->nin ?? '',
                'created_at' => $candidate->created_at ? $candidate->created_at->format('Y-m-d H:i:s') : 'N/A',
                'updated_at' => $candidate->updated_at ? $candidate->updated_at->format('Y-m-d H:i:s') : 'N/A'
            ];

            return response()->json([
                'success' => true,
                'candidate' => $candidateData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching candidate details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'indexing' => 'required|string|max:255|unique:candidates,indexing,' . $id,
                'firstname' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'other_names' => 'nullable|string|max:255',
                'gender' => 'required|in:Male,Female',
                'dob' => 'required|date',
                'programme_id' => 'required|exists:test_codes,id',
                'exam_year' => 'required|integer|min:2020|max:2030',
                'attempt' => 'required|integer|min:1|max:3',
                'enabled' => 'required|boolean',
                'registration_id' => 'nullable|integer'
            ]);

            $candidate = Candidate::find($id);
            
            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Candidate not found'
                ], 404);
            }

            $candidate->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Candidate updated successfully',
                'candidate' => $candidate
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating candidate: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $candidate = Candidate::find($id);
            
            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Candidate not found'
                ], 404);
            }

            $candidate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Candidate deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting candidate: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file. Please upload a valid Excel file (.xls or .xlsx).',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('file');
            $sheets = Excel::toArray(\App\Models\CandidatesImport::class, $file);
            
            $candidates = [];
            $errors = [];
            
            foreach($sheets as $rows) {
                if(empty($rows[0])) // if the sheet doesn't start at row 1 it means the sheet is empty
                    continue;
                    
                $title = $rows[0];
                
                // Find column indexes by searching for header names
                $indexing = $this->searchIndex($title, 'index');
                $surname = $this->searchIndex($title, 'sur') ?? $this->searchIndex($title, 'last');
                $firstname = $this->searchIndex($title, 'first') ?? $this->searchIndex($title, 'fore');
                $othernames = $this->searchIndex($title, 'other') ?? $this->searchIndex($title, 'middle');
                $gender = $this->searchIndex($title, 'gender') ?? $this->searchIndex($title, 'sex');
                $dob = $this->searchIndex($title, 'dob');
                $programme_id = $this->searchIndex($title, 'programme_id');
                $exam_year = $this->searchIndex($title, 'year');
                $password = $this->searchIndex($title, 'password');
                
                // Validate that required columns exist
                if ($indexing === null || $surname === null || $firstname === null) {
                    $errors[] = 'Required columns (indexing, surname, firstname) not found in Excel file';
                    continue;
                }

                foreach ($rows as $key => $value) {
                    if ($key < 1) // skip first row which is considered a title row for the uploaded Excel file.
                        continue;
                        
                    if(empty($value[$indexing]))
                        continue;
                        
                    $candidates[] = [
                        'indexing' => trim($value[$indexing]),
                        'programme_id' => isset($value[$programme_id]) ? trim($value[$programme_id]) : 1, // default to 1 if not provided
                        'surname' => trim($value[$surname]),
                        'firstname' => trim($value[$firstname]),
                        'other_names' => isset($value[$othernames]) ? trim($value[$othernames]) : null,
                        'gender' => isset($value[$gender]) ? trim($value[$gender]) : null,
                        'dob' => isset($value[$dob]) ? trim($value[$dob]) : null,
                        'exam_year' => isset($value[$exam_year]) ? trim($value[$exam_year]) : date('Y'),
                        'password' => isset($value[$password]) ? bcrypt(trim($value[$password])) : bcrypt('password123'),
                        'enabled' => 1,
                        'attempt' => 1,
                    ];
                }
            }

            if (empty($candidates)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid candidate data found in the uploaded file.'
                ], 400);
            }

            DB::beginTransaction();
            
            $uploadErrors = [];
            $successCount = 0;
            
            foreach(array_chunk($candidates, 1000) as $key => $candidateChunk) {
                try {
                    if(Candidate::upsert($candidateChunk, ['indexing'])) {
                        $successCount += count($candidateChunk);
                    } else {
                        $uploadErrors[] = 'Something went wrong with candidate chunk upload ' . $key;
                    }
                } catch (\Exception $e) {
                    $uploadErrors[] = 'Error processing chunk ' . $key . ': ' . $e->getMessage();
                }
            }

            if(empty($uploadErrors)){
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => "Successfully uploaded {$successCount} candidate(s) from Excel file.",
                    'count' => $successCount
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'There were errors processing the file: ' . implode(', ', $uploadErrors)
                ], 500);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error processing Excel file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper function to search for column index by header name
     */
    private function searchIndex($array, $searchTerm)
    {
        foreach($array as $index => $value) {
            if(stripos(strtolower($value), strtolower($searchTerm)) !== false) {
                return $index;
            }
        }
        return null;
    }

    // ===========================================
    // IMAGE MANAGEMENT METHODS
    // ===========================================

    /**
     * Get image statistics for candidates
     */
    public function getImageStats(Request $request)
    {
        try {
            $year = $request->input('year', date('Y')); // Use provided year or current year as default
            
            // Get total candidates for the specified year
            $totalCandidates = Candidate::where('exam_year', $year)->count();
            
            // Use the existing candidateWithoutPassport method from Candidate model
            $candidate_pictures = Candidate::candidateWithoutPassport($year);
            $candidatesWithoutImages = $candidate_pictures['total'];
            
            return response()->json([
                'success' => true,
                'year' => $year,
                'total_candidates' => $totalCandidates,
                'without_images' => $candidatesWithoutImages,
                'with_images' => $totalCandidates - $candidatesWithoutImages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting image statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate images for candidates without passport photos
     * Uses the CBTApiController for consistent behavior
     */
    public function generateImages(Request $request)
    {
        try {
            // Use the existing CBTApiController for consistency
            $cbtController = new \App\Http\Controllers\Api\Web\CBTApiController();
            
            // Prepare the request with current year and batch size
            $apiRequest = new Request([
                'year' => $request->input('year', date('Y')),
                'batch_size' => $request->input('batch_size', 10)
            ]);
            
            // Call the updated CBTApiController method
            $response = $cbtController->generateCandidatePicture($apiRequest);
            
            // Return the response from CBTApiController
            return $response;
            
        } catch (\Exception $e) {
            Log::error('Generate images via CandidateController failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error generating images: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Pull/download images from external server
     */
    public function pullImages(Request $request)
    {
        try {
            // Use the CBTApiController for consistent behavior
            $cbtController = new \App\Http\Controllers\Api\Web\CBTApiController();
            
            // Prepare the request with current year
            $apiRequest = new Request([
                'year' => $request->input('year', date('Y'))
            ]);
            
            // Call the CBTApiController method
            $response = $cbtController->pullCandidatePictures($apiRequest);
            
            // Return the response from CBTApiController
            return $response;
            
        } catch (\Exception $e) {
            Log::error('Pull images via CandidateController failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error pulling images: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Manual upload of candidate images
     */
    public function uploadImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array',
            'files.*' => 'required|file|mimes:jpeg,jpg|max:5120', // 5MB max per file
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid files. Please upload valid JPG images (max 5MB each).',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $files = $request->file('files');
            $results = [];
            $successCount = 0;
            $errorCount = 0;
            
            // Ensure passport directory exists
            $passportDir = public_path(candidate_passport_path());
            if (!File::exists($passportDir)) {
                File::makeDirectory($passportDir, 0755, true);
            }

            foreach ($files as $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                
                try {
                    // Validate filename format (should match candidate indexing pattern)
                    // Convert underscores back to slashes for indexing lookup
                    $candidateIndexing = str_replace('_', '/', $fileName);
                    
                    // Check if candidate exists
                    $candidate = Candidate::where('indexing', $candidateIndexing)->first();
                    
                    if (!$candidate) {
                        $results[] = [
                            'filename' => $originalName,
                            'success' => false,
                            'message' => "No candidate found with indexing: {$candidateIndexing}"
                        ];
                        $errorCount++;
                        continue;
                    }
                    
                    // Save the file directly to the passport directory
                    
                    if ($file->move($passportDir, $fileName . '.jpg')) {
                        $results[] = [
                            'filename' => $originalName,
                            'success' => true,
                            'message' => "Successfully uploaded image for {$candidate->fullname()}"
                        ];
                        $successCount++;
                    } else {
                        $results[] = [
                            'filename' => $originalName,
                            'success' => false,
                            'message' => 'Failed to save image file'
                        ];
                        $errorCount++;
                    }
                } catch (\Exception $e) {
                    $results[] = [
                        'filename' => $originalName,
                        'success' => false,
                        'message' => 'Error processing file: ' . $e->getMessage()
                    ];
                    $errorCount++;
                }
            }

            $message = "Upload completed: {$successCount} successful, {$errorCount} failed";
            
            return response()->json([
                'success' => $successCount > 0,
                'message' => $message,
                'results' => $results,
                'summary' => [
                    'total' => count($files),
                    'successful' => $successCount,
                    'failed' => $errorCount
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading images: ' . $e->getMessage()
            ], 500);
        }
    }
}

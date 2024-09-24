<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Http;

class CBTApiController extends Controller
{
    
    public function generateCandidatePicture(Request $request){
        $year = date('Y');
        $candidate_pictures = Candidate::candidateWithoutPassport($year);
        $candidate_ids = $candidate_pictures['candidate_ids'];
        
        // $candidate_ids = array_slice($candidate_ids, 0, 10, true);
        $headers = [
            'Authorization' => 'Bearer your-token-here',
            'Accept' => 'application/json',
            'Custom-Header' => 'custom-value'
        ];
        $response = Http::withHeaders($headers)->post('https://app.chprbn.gov.ng/generate-candidate-passport',['indexings'=>$candidate_ids]);
        $response = json_decode($response);
        foreach($response as $candidate){
            // $imageName = str_replace('/', '_', $candidate->indexing).'.jpg';
            $location = candidate_passport_path().'/'.str_replace('/', '_', $candidate->indexing).'.jpg';
            $imageData = base64_decode($candidate->photo);
            $source = imagecreatefromstring($imageData);
            $imageSave = imagejpeg($source, $location, 20);
            imagedestroy($source);
        }
        return 'passports downloaded';
    }


    public function pullCandidatePictures(Request $request)
    {

        return 'hello';
        $year = date('Y');
        $candidate_pictures = Candidate::candidateWithoutPassport($year);
        $candidate_ids = $candidate_pictures['candidate_ids'];
        
        // $candidate_ids = array_slice($candidate_ids, 0, 10, true);
        $headers = [
            'Authorization' => 'Bearer your-token-here',
            'Accept' => 'application/json',
            'Custom-Header' => 'custom-value'
        ];
        $response = Http::withHeaders($headers)->post('https://cbt.chprbn.gov.ng/pull-picture',['indexings'=>$candidate_ids]);
        $response = json_decode($response);
        return $response;
        foreach($response as $candidate){
            // $imageName = str_replace('/', '_', $candidate->indexing).'.jpg';
            $location = candidate_passport_path().'/'.str_replace('/', '_', $candidate->indexing).'.jpg';
            $imageData = base64_decode($candidate->photo);
            $source = imagecreatefromstring($imageData);
            $imageSave = imagejpeg($source, $location, 80);
            imagedestroy($source);
        }
        return response()->json(['success' => true, 'message' => 'Download Successful'], 200);

    }
}

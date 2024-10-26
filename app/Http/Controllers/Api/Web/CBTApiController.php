<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Http;

class CBTApiController extends Controller
{
    

    
    public function pullCandidate(Request $request){
        $candidates = $request->graduands;
        // return $candidates;
        foreach(array_chunk($candidates, 500) as $key=>$candidate){
            if(!Candidate::upsert($candidate, ['indexing'])) {
                reset_auto_increment('candidates');
            }
        }
        return "Updated";
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


    public function generateCandidatePicture(Request $request){
        // set_time_limit(0);
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
            $imageSave = imagejpeg($source, $location, 50);
            imagedestroy($source);
        }
        return 'passports downloaded';
    }


    public function pullCandidatePictures(Request $request)
    {
        // set_time_limit(0);
        // return 'hello';
        $year = date('Y');
        $candidate_pictures = Candidate::candidateWithoutPassport($year);
        $candidate_ids = $candidate_pictures['candidate_ids'];
        // return $candidate_ids;
        // $candidate_ids = array_slice($candidate_ids, 0, 10, true);
        $headers = [
            'Authorization' => 'Bearer your-token-here',
            'Accept' => 'application/json',
            'Custom-Header' => 'custom-value'
        ];
        $response = Http::withHeaders($headers)->post('https://zxcvbnm.chprbn.gov.ng/pull-picture',['indexings'=>$candidate_ids]);
        $response = json_decode($response);
        // return $response;
        foreach($response as $candidate){
            // $imageName = str_replace('/', '_', $candidate->indexing).'.jpg';
            $location = candidate_passport_path().'/'.str_replace('/', '_', $candidate->indexing).'.jpg';
            $imageData = base64_decode($candidate->photo);
            $source = imagecreatefromstring($imageData);
            $imageSave = imagejpeg($source, $location, 80);
            imagedestroy($source);
        }
        $pictures = Candidate::candidateWithoutPassport($year);
        $total_candidates = Candidate::where('exam_year', $year)->count();
        $downloaded = $total_candidates - $pictures['total'];
        return response()->json(['success' => true, 'message' => 'Download Successful','data'=>$downloaded.'/'.$total_candidates], 200);

    }
}

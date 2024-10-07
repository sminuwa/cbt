<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AnswerOption;
use App\Models\Candidate;
use App\Models\CandidateSubject;
use App\Models\Centre;
use App\Models\ExamsDate;
use App\Models\ExamType;
use App\Models\QuestionBank;
use App\Models\ScheduledCandidate;
use App\Models\Scheduling;
use App\Models\Subject;
use App\Models\TestCode;
use App\Models\TestCompositor;
use App\Models\TestConfig;
use App\Models\TestInvigilator;
use App\Models\TestQuestion;
use App\Models\TestSection;
use App\Models\TestSubject;
use App\Models\TestType;
use App\Models\User;
use App\Models\TimeControl;
use App\Models\Presentation;
use App\Models\Score;
use App\Models\Venue;
use App\Models\Topic;
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class APIV1Controller extends Controller
{
    //


    public function basicData()
    {
        $data = [
            "centres"=>Centre::all(),
            "exam_types"=>ExamType::all(),
            "venues"=>Venue::all(),
            "test_codes"=>TestCode::all(),
            "test_types"=>TestType::all(),
            "topics"=>Topic::all()
            
        ];

        return response()->json($data);

    }

    public function testData(Request $request)
    {
        // return $request->api_key;
        //Use header data to get all venue ids
        // $api_key = $request->header('api_key');
        // $secretKey = $request->header('secret_key');
        // $api_key = $request->api_key;
        // $secretKey = $request->secret_key;
        // return $request;
        $api_key =  $request->api_key ?? $request->header('api_key');
        $secretKey = $request->secret_key ?? $request->header('secret_key');
        $center = Centre::where(['api_key'=>$api_key,'secret_key'=>$secretKey])->first();
        // return $center;
        if($center){
            $venueIds = Venue::where('centre_id',$center->id)->pluck('id');

            $data = [];
            //Use venue Ids to get Schedules for today
            $data['schedules'] = Scheduling::whereIn('venue_id',$venueIds)->whereDate("date",today())->get();
            
            $testConfigIds = $data['schedules']->pluck('test_config_id');

            
            $data['schedulings'] = Scheduling::whereIn('id',$data['schedules']->pluck('id'))->get();

            $data['test_configs'] = TestConfig::whereIn('id',$testConfigIds)->get();
            $data['test_compositors'] = TestCompositor::whereIn('test_config_id',$testConfigIds)->get();
            $data['users'] = User::whereIn('id',$data['test_compositors']->pluck('user_id'))->get();
            $subjectIds1 = $data['test_compositors']->pluck('subject_id');
            $data['test_subjects'] = TestSubject::whereIn('test_config_id',$testConfigIds)->get();
            $subjectIds2 = $data['test_subjects']->pluck('id');
            $subjectIds = array_merge($subjectIds1->toArray(),$subjectIds2->toArray());
            $data['subjects'] = Subject::all();//whereIn('id',$subjectIds)->get();
            $data['test_sections'] = TestSection::whereIn("test_subject_id",$subjectIds2)->get();
            $testSectionIds = $data['test_sections'] ->pluck('id');
            $data['test_questions'] = TestQuestion::whereIn('test_section_id',$testSectionIds)->get();//test_section_id
            $questionBankIds = $data['test_questions'] ->pluck('question_bank_id');//question_bank_id
            $data['question_banks'] = QuestionBank::whereIn('id',$questionBankIds)->get();
            $data['answer_options'] = AnswerOption::whereIn('question_bank_id',$questionBankIds)->get();
            $data['exams_dates'] = ExamsDate::whereIn('test_config_id',$testConfigIds)->get();
            $data['test_invigilators'] = TestInvigilator::whereIn('test_config_id',$testConfigIds)->get();
        

            return response()->json(['status'=>1,'data'=>$data]);
        }

        return response()->json(['status'=>0,'error'=>'Invalid Credentials'],403);
    }

    public function candidateData(Request $request)
    {

        $api_key =  $request->api_key ?? $request->header('api_key');
        $secretKey = $request->secret_key ?? $request->header('secret_key');
        
        $center = Centre::where(['api_key'=>$api_key,'secret_key'=>$secretKey])->first();
        if($center){
            $venueIds = Venue::where('centre_id',$center->id)->pluck('id');

            $data = [];

            //Use venue Ids to get Schedules for today
            $data['schedules'] = Scheduling::whereIn('venue_id',$venueIds)->whereDate("date",today())->get();
            $data['candidate_subjects'] = CandidateSubject::whereIn('schedule_id',$data['schedules']->pluck('id'))->get();
            $scheduledCandidateIds = $data['candidate_subjects']->pluck('scheduled_candidate_id');
            $data['scheduled_candidates'] = ScheduledCandidate::whereIn('id',$scheduledCandidateIds)->get();
            $candidateIds = $data['scheduled_candidates']->pluck('candidate_id');
            $data['candidates'] = Candidate::whereIn('id',$candidateIds)->get();
            return response()->json(['status'=>1,'data'=>$data]);
        }

        return response()->json(['status'=>0,'error'=>'Invalid Credentials'],403);

    }

    public function candidatePictures(Request $request)
    {
    
        // return $request;
        $indexings = $request->indexings ?? [];
        $candidates = Candidate::whereIn('indexing',$indexings)->limit(10)->get();
        $CAND = [];
        foreach($candidates as $cand){
            $data = file_get_contents($cand->passport(true));
            $photo = base64_encode($data);
            $CAND[]=[
                'indexing'=>$cand->indexing,
                'photo'=>$photo
            ];
        }
        return response()->json($CAND);


        $api_key =  $request->api_key ?? $request->header('api_key');
        $secretKey = $request->secret_key ?? $request->header('secret_key');
        $center = Centre::where(['api_key'=>$api_key,'secret_key'=>$secretKey])->first();
        if($center){
            $venueIds = Venue::where('centre_id',$center->id)->pluck('id');
            // return venueIds;
            $data = [];

            //Use venue Ids to get Schedules for today
            $data['schedules'] = Scheduling::whereIn('venue_id',$venueIds)->whereDate("date",today())->get();
            $data['candidate_subjects'] = CandidateSubject::whereIn('schedule_id',$data['schedules']->pluck('id'))->get();
            $scheduledCandidateIds = $data['candidate_subjects']->pluck('scheduled_candidate_id');
            $data['scheduled_candidates'] = ScheduledCandidate::whereIn('id',$scheduledCandidateIds)->get();
            $candidateIds = $data['scheduled_candidates']->pluck('candidate_id');
            $candidates = Candidate::whereIn('id',$candidateIds)->get();

            
            $zip = new ZipArchive();
            $filename = preg_replace('/[^A-Za-z0-9]/', '_', $center->name ?? 'CENTER_NAME');

            // Append the current date
            $date = date('Y_m_d'); // Format the date as needed, e.g., 'Y-m-d' for '2024-07-15'
            $filename .= '_' . $date;
            $zipFileName = "{$filename}.zip";
            $zipFilePath = storage_path("app/{$zipFileName}");
            
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

                foreach ($candidates as $candidate) {
                    $img_path = preg_replace('/[^A-Za-z0-9]/', '_', $candidate->indexing).'.jpg';
                    if ($candidate->indexing && public_path(candidate_passport_path()."/".$img_path)) {
                        $imagePath = public_path(candidate_passport_path()."/".$img_path);
                        $zip->addFile($imagePath, basename($imagePath));
                    }
                }

                $zip->close();
            }

            
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        }

        return response()->json(['status'=>0,'error'=>'Invalid Credentials'],403);
    }

    public function pushExams(Request $request){
        $request->session()->flush();
        // return $request->body['api_key'];
        $api_key =  $request->body['api_key'] ?? $request->header('api_key');
        $secretKey = $request->body['secret_key'] ?? $request->header('secret_key');
        $center = Centre::where(['api_key'=>$api_key,'secret_key'=>$secretKey])->first();
        if($center){
            // foreach(array_chunk($request->times, 500) as  $times) {
            //     TimeControl::upsert($times,['test_config_id','scheduled_candidate_id']);
            // }
            // foreach(array_chunk($request->presentations, 500) as  $presentations) {
            //     Presentation::upsert($presentations,['scheduled_candidate_id','test_config_id','test_section_id','question_bank_id']);
            // }
            // foreach(array_chunk($request->scores, 500) as  $scores) {
            //     Score::upsert($scores,['scheduled_candidate_id','test_config_id','question_bank_id','answer_option_id']);
            // }

            $maxAttempts = 5; // Maximum number of retry attempts

            foreach (array_chunk($request->times, 200) as $times) {
                for ($i = 0; $i < $maxAttempts; $i++) {
                    try {
                        DB::transaction(function () use ($times) {
                            TimeControl::upsert($times, ['test_config_id', 'scheduled_candidate_id']);
                        });
                        break; // Break out of the retry loop if successful
                    } catch (\Exception $e) {
                        if ($e->getCode() !== 1213) { // If the exception is not a deadlock error, rethrow it
                            throw $e;
                        }
                        usleep(100000); // Sleep for 100ms before retrying
                    }
                }
            }

            foreach (array_chunk($request->presentations, 200) as $presentations) {
                for ($i = 0; $i < $maxAttempts; $i++) {
                    try {
                        DB::transaction(function () use ($presentations) {
                            Presentation::upsert($presentations, ['scheduled_candidate_id', 'test_config_id', 'test_section_id', 'question_bank_id']);
                        });
                        break;
                    } catch (\Exception $e) {
                        if ($e->getCode() !== 1213) {
                            throw $e;
                        }
                        usleep(100000);
                    }
                }
            }

            foreach (array_chunk($request->scores, 200) as $scores) {
                for ($i = 0; $i < $maxAttempts; $i++) {
                    try {
                        DB::transaction(function () use ($scores) {
                            Score::upsert($scores, ['scheduled_candidate_id', 'test_config_id', 'question_bank_id', 'answer_option_id']);
                        });
                        break;
                    } catch (\Exception $e) {
                        if ($e->getCode() !== 1213) {
                            throw $e;
                        }
                        usleep(100000); // Retry after a brief pause
                    }
                }
            }

            return response()->json(['status'=>1,'data'=>1]);
        }

        return response()->json(['status'=>0,'error'=>'Invalid Credentials'],403);
    }
}

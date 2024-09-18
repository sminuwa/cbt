<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Centre;
use App\Models\Candidate;
use App\Models\CandidateSubject;
use App\Models\ScheduledCandidate;
use App\Models\Venue;
use App\Models\Scheduling;
use App\Models\Subject;
use App\Models\TestConfig;



class AttendanceController extends Controller
{
    public function fetchRecord(Request $request){
        
        try{

            $centre = $request->user();
            $api_key =  $centre->api_key;
        
            $secretKey = $centre->secret_key;
        
            // $center = Centre::where(['api_key'=>$api_key,'secret_key'=>$secretKey])->first();
            if($centre){
                $venueIds = Venue::where('centre_id',$centre->id)->pluck('id');
                $data = [];

                $schedules = Scheduling::whereIn('venue_id',$venueIds)->whereDate("date",today())->limit(3)->get();
                $schedule_ids = $schedules->pluck('id');
                $candidate_subjects = CandidateSubject::whereIn('schedule_id',$schedule_ids)->get();
                //Use venue Ids to get Schedules for today
                $subjects = Subject::select('id', 'subject_code as code', 'name')->whereIn('id',$candidate_subjects->pluck('subject_id'))->get();
                $centre->makeHidden(['created_at', 'updated_at','password','remember_token','secret_key','api_token']);
                $schedulings = $candidate_papers = $candidates2 = $candidates1 = [];
                foreach($schedules as $schedule){
                    
                    foreach($subjects as $subject){
                        $candidates1 = Candidate::
                        select('candidates.*','scheduled_candidates.id as scheduled_candidate_id')
                        ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', 'candidates.id')
                        ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', 'scheduled_candidates.id')
                        ->where('candidate_subjects.subject_id', $subject->id)
                        ->where('schedule_id', $schedule->id)
                        ->limit(3)->get();
                        $candidates2 = Candidate::
                        select('candidates.*','scheduled_candidates.id as scheduled_candidate_id')
                        ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', 'candidates.id')
                        ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', 'scheduled_candidates.id')
                        ->where('schedule_id', $schedule->id)
                        ->limit(3)->get();
                        $candidates1->makeHidden(['created_at', 'updated_at','password','nin','api_token','remember_token','country_id','lga_id','api_key']);
                        $candidates2->makeHidden(['created_at', 'updated_at','password','nin','api_token','remember_token','country_id','lga_id','api_key']);
                        foreach($candidates1 as $candidate){
                            $candidate_papers[] = [
                                'candidate_id' => $candidate->id,
                                'paper_id' => $subject->id,
                                'scheduled_candidate_id'=>$candidate->scheduled_candidate_id
                            ];
                        }
                        
                        // $subject['candidates'] = $candidates;
                    }

                    $test = TestConfig::
                    select('test_codes.name as test_code', 'test_types.name as test_type')
                    ->join('test_codes', 'test_codes.id', 'test_configs.test_code_id')
                    ->join('test_types', 'test_types.id', 'test_configs.test_type_id')
                    ->where('test_configs.id', $schedule->test_config_id)->first();

                    $CAND = [];
                    foreach($candidates2 as $cand){
                        $data = file_get_contents($cand->passport(true));
                        $photo = base64_encode($data);
                        $CAND[]=[
                            'id'=>$cand->id,
                            'indexing'=>$cand->indexing,
                            'fullname'=>$cand->fullname(),
                            'photo'=>$photo
                        ];
                    }
                    $schedulings[]=[
                        'id'=>$schedule->id,
                        'test_date'=>$schedule->date,
                        'test_code'=>$test->test_code,
                        'test_type'=>$test->test_type,
                        'paper_candidates'=>$candidate_papers,
                        'candidates'=>$CAND
                    ];
                }
                // return $candidate_papers;
                
                $centre['schedules'] = $schedulings;
                $centre['papers'] = $subjects;
                // $centre['candidates'] = $candidates2;
                
                // foreach ($centre as $c) {
                //     $c->makeHidden(['created_at', 'updated_at']);
                // }
                // return $centre;
                
                return jResponse(true, 'Successful', [
                    'schedules' => $schedulings,
                    'papers' => $subjects,
                ]);
            }

            
        }catch(\Exception $e){
            return jResponse(false, 'Failed', 'Something went wrong. '.$e->getMessage());
        }
    }

    public function pushRecord(Request $request){
        // exam number, cadre, paper, status [present, absent, cancelled, etc]
        try{
            $user = $request->user();
            $year = 2024;
            
            $records = json_decode($request->getContent());
            $candidate_ids = $attendance = [];
            foreach($records as $record){
                if($graduand->candidate_id == $record->candidate_id){
                    $candidate_ids[] = $record->scheduled_candidate_id;
                    $attendance[] = [
                        'scheduled_candidate_id' => $record->scheduled_candidate_id,
                        'paper_id' => $record->paper_id,
                        'sign_in' => $record->sign_in,
                        'sign_out' => $record->sign_out,
                        'remark' => $record->remark,
                        'year' => $graduand->year,
                    ];
                }
            }

            if(!empty($attendance)){
                if(ExamAttendance::upsert($attendance, ['scheduled_candidate_id', 'paper_id', 'year']))
                    return jResponse(true, 'Successful', $candidate_ids);

            }
            return jResponse(false, 'Something went wrong');
        }catch(\Exception $e){
            return jResponse(false, 'Failed', 'Something went wrong. '. $e->getMessage() );
        }
    }
}

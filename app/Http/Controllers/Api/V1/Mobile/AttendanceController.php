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
use App\Models\Attendance;
use App\Models\ProjectAssessment;
use App\Models\PracticalSection;
use App\Models\PracticalQuestion;
use App\Models\PracticalExamination;



class AttendanceController extends Controller
{

    // public function __construct()
    // {
    //     // Apply the CentreGuard middleware globally to all methods in this controller
    //     $this->middleware('centre');
    // }

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
                $schedulings = $candidate_papers = $candidates2 = $candidates1 = $sections = [];
                $has_practical = false;
                $year = date('Y');
                foreach($schedules as $schedule){
                    $year = date('Y', strtotime($schedule->date));
                    foreach($subjects as $subject){
                        if($subject->code == 'PE')
                            $has_practical = true;
                        $candidates1 = Candidate::
                        select('candidates.*','scheduled_candidates.id as scheduled_candidate_id')
                        ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', 'candidates.id')
                        ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', 'scheduled_candidates.id')
                        ->where('candidate_subjects.subject_id', $subject->id)
                        ->where('schedule_id', $schedule->id)
                        ->get();
                        $candidates2 = Candidate::
                        select('candidates.*','scheduled_candidates.id as scheduled_candidate_id')
                        ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', 'candidates.id')
                        ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', 'scheduled_candidates.id')
                        ->where('schedule_id', $schedule->id)
                        ->groupBy('candidates.id')->get();
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
                        'test_date'=>date('l, jS M Y', strtotime($schedule->date)),
                        'test_code'=>$test->test_code,
                        'test_type'=>$test->test_type,
                        'paper_candidates'=>$candidate_papers,
                        'candidates'=>$CAND
                    ];
                    $candidate_papers = [];
                }

                if($has_practical == true){
                    $sections = PracticalSection::where(['status'=>1])->with('questions',function($query){
                        $query->where('status', 1);
                    })->get();

                    foreach($sections as $section){
                        $sections->makeHidden(['created_at', 'updated_at']);
                        $section->questions->makeHidden(['created_at', 'updated_at']);
                    }
                }
                // return $candidate_papers;
                
                // $centre['schedules'] = $schedulings;
                // $centre['papers'] = $subjects;
                // $centre['candidates'] = $candidates2;
                
                // foreach ($centre as $c) {
                //     $c->makeHidden(['created_at', 'updated_at']);
                // }
                // return $centre;
                
                return jResponse(true, 'Successful', [
                    'centre'=>$centre,
                    'schedules' => $schedulings,
                    'papers' => $subjects,
                    'year'=>$year,
                    'sections'=>$sections,
                ]);
            }

            return jResponse(false, 'Failed', 'Something went wrong. ');
        }catch(\Exception $e){
            return jResponse(false, 'Failed', 'Something went wrong. '.$e->getMessage());
        }
    }

    public function pushRecord(Request $request){
        // exam number, cadre, paper, status [present, absent, cancelled, etc]
        try{
            $user = $request->user();
            $records = json_decode($request->getContent());
            $candidate_ids = $attendance = [];
            foreach($records as $record){
                $candidate_ids[] = $record->candidate_id;
                    $attendance[] = [
                        'scheduled_candidate_id' => $record->scheduled_candidate_id,
                        'schedule_id' => $record->schedule_id,
                        'candidate_id' => $record->candidate_id,
                        'paper_id' => $record->paper_id,
                        'sign_in' => $record->sign_in,
                        'sign_out' => $record->sign_out,
                        'remark' => $record->remark,
                        'year' => $record->year,
                    ];
            }

            if(!empty($attendance)){
                if(Attendance::upsert($attendance, ['scheduled_candidate_id', 'paper_id', 'year']))
                    return jResponse(true, 'Successful', $candidate_ids);

            }

            return jResponse(false, 'Something went wrong');
        }catch(\Exception $e){
            return jResponse(false, 'Failed', 'Something went wrong. '. $e->getMessage() );
        }
    }

    public function pushProject(Request $request){
        try{
            $user = $request->user();
            $records = json_decode($request->getContent());
            $candidate_ids = $attendance = [];
            foreach($records as $record){
                $candidate_ids[] = $record->scheduled_candidate_id;
                    $attendance[] = [
                        'scheduled_candidate_id' => $record->scheduled_candidate_id,
                        'schedule_id' => $record->schedule_id,
                        'candidate_id' => $record->candidate_id,
                        'paper_id' => $record->paper_id,
                        'score' => $record->score,
                    ];
            }

            if(!empty($attendance)){
                if(ProjectAssessment::upsert($attendance, ['scheduled_candidate_id', 'candidate_id','paper_id', 'schedule_id']))
                    return jResponse(true, 'Successful', $candidate_ids);

            }

            return jResponse(false, 'Something went wrong');
        }catch(\Exception $e){
            return jResponse(false, 'Failed', 'Something went wrong. '. $e->getMessage() );
        }
    }

    public function pushPractical(Request $request){
        try{
            $user = $request->user();
            $records = json_decode($request->getContent());
            $candidate_ids = $pro = $pra = [];
            foreach($records as $record){
                $practicals = $record->practicals;
                $projects = $record->projects;
                foreach($practicals as $practical){
                    $candidate_ids[] = $practical->scheduled_candidate_id;
                    $pro[] = [
                        'candidate_id' => $practical->candidate_id,
                        'paper_id' => $practical->paper_id,
                        'practical_question_id' => $practical->question_id,
                        'schedule_id' => $practical->schedule_id,
                        'scheduled_candidate_id' => $practical->scheduled_candidate_id,
                        'score' => $practical->score,
                    ];
                }
                foreach($projects as $project){
                    $pra[] = [
                        'scheduled_candidate_id' => $project->scheduled_candidate_id,
                        'schedule_id' => $project->schedule_id,
                        'candidate_id' => $project->candidate_id,
                        'paper_id' => $project->paper_id,
                        'score' => $project->score,
                    ];
                }
            }

            $error = "";
            if(!empty($pro)){
                if(PracticalExamination::upsert($pro, ['scheduled_candidate_id', 'practical_question_id','paper_id', 'schedule_id']))
                    $error = "Something went wrong.";

            }

            if(!empty($pra)){
                if(ProjectAssessment::upsert($pra, ['scheduled_candidate_id', 'candidate_id','paper_id', 'schedule_id']))
                    $error = "Something went wrong.";

            }
            if($error == "")
                return jResponse(true, 'Successful', $candidate_ids);

            return jResponse(false, 'Something went wrong');
        }catch(\Exception $e){
            return jResponse(false, 'Failed', 'Something went wrong. '. $e->getMessage() );
        }
    }
}

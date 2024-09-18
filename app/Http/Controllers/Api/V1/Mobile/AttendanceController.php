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
                $schedulings = [];
                foreach($schedules as $schedule){
                    $candidate_papers = $candidates2 = $candidates1 = [];
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
                    $schedulings[]=[
                        'test_code'=>$test->test_code,
                        'test_type'=>$test->test_type,
                        'paper_candidate'=>$candidate_papers,
                        'candidates'=>$candidates2
                    ];
                }
                // return $candidate_papers;
                
                $centre['schedules'] = $schedulings;
                $centre['papers'] = $subjects;
                // $centre['candidates'] = $candidates2;
                
                // foreach ($centre as $c) {
                //     $c->makeHidden(['created_at', 'updated_at']);
                // }
                return $centre;
                
                $data['candidate_subjects'] = CandidateSubject::whereIn('schedule_id',$data['schedules']->pluck('id'))->get();
                $scheduledCandidateIds = $data['candidate_subjects']->pluck('scheduled_candidate_id');
                $data['scheduled_candidates'] = ScheduledCandidate::whereIn('id',$scheduledCandidateIds)->limit(3)->get();
                $candidateIds = $data['scheduled_candidates']->pluck('candidate_id');
                $data['candidates'] = Candidate::whereIn('id',$candidateIds)->limit(3)->get();
                return response()->json(['status'=>1,'data'=>$data]);
            }


            $institutions = $candidates = $candidate_papers = [];
            $papers = ExamPaper::orderBy('id', 'asc')->get(['id', 'name', 'code', 'description'])->toArray();
            foreach($user_exams as $exam){
                $year = $exam->year;
                $institution_id = $exam->institution_id;
                $inst = Institution::find($institution_id);
                $c = Candidate::forInstitution($institution_id)->get('id')->toArray();
                $graduands = Graduand::whereIn('candidate_id', $c)->year($year)->with(['candidate', 'papers'])->status(STATUS_SUBMITTED)->get();
                foreach($graduands as $graduand){
                    $ps = $graduand->papers;
                    foreach($ps as $paper){
                        $candidate_papers[] = [
                            'candidate_id' => $graduand->candidate->id,
                            'paper_id' => $paper->paper_id
                        ];
                    }
                    $data = file_get_contents($graduand->candidate->passport(true));
                    $photo = base64_encode($data);
                    $candidates[] = [
                        'candidate_id' => $graduand->candidate->id,
                        'photo' => $photo,
                        'fullname' => $graduand->candidate->fullname(),
                        'exam_number' => $graduand->exam_number,
                        'cadre' => $graduand->candidate->cadre->name,
                    ];
                }
                $institutions[] = [
                    'id' => $inst->id,
                    'name' => $inst->name,
                    'code' => $inst->code,
                    'phone' => $inst->phone,
                    'exam_date'=> '2024-08-30',
                    'candidates' => $candidates,
                    'papers' => $candidate_papers,
                ];
                $candidates = $candidate_papers = [];
            }

            return jResponse(true, 'Successful', [
                'institutions' => $institutions,
                'year' => $year,
                'papers' => $papers,
            ]);
        }catch(\Exception $e){
            return jResponse(false, 'Failed', 'Something went wrong. '.$e->getMessage());
        }
    }

    public function pushRecord(Request $request){
        // exam number, cadre, paper, status [present, absent, cancelled, etc]
        try{
            /*$this->validate($request, [
                'records' => 'records',
            ]);*/
            $user = $request->user();
            //TODO::change the examination year here
            $year = 2024;
            $institutions = UserExam::where(['user_id'=>$user->id, 'year'=>$year])->get('id')->toArray();
            $candidates = Candidate::whereIn('institution_id', $institutions)->get('id')->toArray();
            $graduands = Graduand::whereIn('candidate_id', $candidates)->get();

            $records = json_decode($request->getContent());
            $candidate_ids = $attendance = [];
            foreach($graduands as $graduand){
                foreach($records as $record){
                    if($graduand->candidate_id == $record->candidate_id){
                        $candidate_ids[] = $record->candidate_id;
                        $attendance[] = [
                            'graduand_id' => $graduand->id,
                            'paper_id' => $record->paper_id,
                            'sign_in' => $record->sign_in,
                            'sign_out' => $record->sign_out,
                            'remark' => $record->remark,
                            'year' => $graduand->year,
                        ];
                    }
                }
            }

            if(!empty($attendance)){
                if(ExamAttendance::upsert($attendance, ['graduand_id', 'paper_id', 'year']))
                    return jResponse(true, 'Successful', $candidate_ids);

            }
            return jResponse(false, 'Something went wrong');
        }catch(\Exception $e){
            return jResponse(false, 'Failed', 'Something went wrong. '. $e->getMessage() );
        }
    }
}

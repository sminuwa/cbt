<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Admin\ExamAttendance;
use App\Models\Admin\User;
use App\Models\Admin\UserExam;
use App\Models\Cadre;
use App\Models\ExamPaper;
use App\Models\Institution\Candidate;
use App\Models\Institution\Graduand;
use App\Models\Institution\Institution;
use App\Models\Practitioner\Practitioner;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //

    public function fetchRecord(Request $request){
        try{
            $user = Practitioner::with(['user_exam' => function($query){
                $query->where('status', 1);
            }])->where('id',$request->user()->id)->first();
            $user_exams = $user->user_exam;
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

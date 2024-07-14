<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Centre;
use App\Models\ExamsDate;
use App\Models\ExamType;
use App\Models\QuestionBank;
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
use App\Models\Venue;
use Illuminate\Http\Request;

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
            "test_types"=>TestType::all()
        ];

        return response()->json($data);

    }

    public function testData(Request $request)
    {
        //Use header data to get all venue ids
        $api_key = $request->header('api_key');
        $secretKey = $request->header('secret_key');
        $center = Centre::where(['api_key'=>$api_key,'secret_key'=>$secretKey])->first();
        if($center){
            $venueIds = Venue::where('centre_id',$center->id)->pluck('id');

            $data = [];

            //Use venue Ids to get Schedules for today
            $data['schedules'] = Scheduling::whereIn('venue_id',$venueIds)->whereDate("date",today())->get();
            $testConfigIds = $data['schedules']->pluck('test_config_id');
            $data['test_configs'] = TestConfig::whereIn('id',$testConfigIds)->get();
            $data['test_compositors'] = TestCompositor::whereIn('test_config_id',$testConfigIds)->get();
            $data['users'] = User::whereIn('id',$data['test_compositors']->pluck('user_id'))->get();
            $subjectIds1 = $data['test_compositors']->pluck('subject_id');
            $data['test_subjects'] = TestSubject::whereIn('test_config_id',$testConfigIds)->get();
            $subjectIds2 = $data['test_subjects']->pluck('subject_id');
            $subjectIds = array_merge($subjectIds1->toArray(),$subjectIds2->toArray());
            $data['subjects'] = Subject::whereIn('id',$subjectIds)->get();
            $data['test_sections'] = TestSection::whereIn("test_subject_id",$subjectIds2)->get();
            $testSectionIds = $data['test_sections'] ->pluck('id');
            $data['test_questions'] = TestQuestion::whereIn('test_section_id',$testSectionIds)->get();//test_section_id
            $questionBankIds = $data['test_questions'] ->pluck('question_bank_id');//question_bank_id
            $data['question_banks'] = QuestionBank::whereIn('id',$questionBankIds)->get();
            $data['exams_dates'] = ExamsDate::whereIn('test_config_id',$testConfigIds)->get();
            $data['test_invigilators'] = TestInvigilator::whereIn('test_config_id',$testConfigIds)->get();

            return response()->json(['status'=>1,'data'=>$data]);
        }

        return response()->json(['status'=>0,'error'=>'Invalid Credentials'],403);
    }


}

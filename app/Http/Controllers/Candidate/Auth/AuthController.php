<?php

namespace App\Http\Controllers\Candidate\Auth;

use App\Http\Controllers\Controller;
use App\Models\ScheduledCandidate;
use App\Models\Scheduling;
use App\Models\TestConfig;
use App\Models\TimeControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    public function index(){
        $exams = TestConfig::exam()->get();
        return view('pages.candidate.auth.login',compact('exams'));
    }

    public function login(Request $request){
        //login checks
        $test_id = $request->test_id;
        $username = $request->username;
        $password = $request->password;
        //validations goes here

        //checking candidate's credentials
        $testConfig = TestConfig::where('test_configs.id',$test_id)->with('test_code','test_type');
        $test  = clone $testConfig;
        $test = $test->exam()->first();
        // check if the exam type is still available
        if(!$test) return back()->with('error', 'Exam Type is Invalid.')->withInput();
        $credentials = ["indexing" => $username, "password" => $password];
        if (Auth::guard("web")->attempt($credentials)) {
            //check candidate's schedules and compare with the selected test schedules
            $candidate = auth()->user();
            $scheduled_candidate = $candidate->schedules($test_id);
//            return $candidate->schedules($test_id);
            $candidate_subjects = ScheduledCandidate::forCandidate($test->schedule_id)->get();
            if($candidate->test_is_completed($test->id, $scheduled_candidate?->id)) return back()->with('error', 'You have already taken the selected exams.')->withInput();
            $timeControl = $candidate->has_time_control($test->id, $scheduled_candidate?->id);
            $duration = $test->duration; //duration in minute
            $start_time = date('H:i:s');
            $current_time = date('H:i:s');
            $elapsed = 0;
            $ip = request()->ip();
            if(!$timeControl){
                $timeControl = TimeControl::createRecord($test->id,$scheduled_candidate?->id,$start_time,$current_time,0,$ip);
                if(!$timeControl) return back()->with('error', 'Error creating time control.')->withInput();
            }
            $time_difference = (strtotime($timeControl->current_time) - strtotime($timeControl->start_time)) / 60;
            if($time_difference > $duration) return back()->with('error', 'Your exam time has elapsed.')->withInput();
            $remaining_seconds = $test->duration * 60 - $timeControl->elapsed;
            Session::put('candidate', $candidate);
            Session::put('scheduled_candidate', $scheduled_candidate);
            Session::put('candidate_subjects', $candidate_subjects);
            Session::put('time_difference', $time_difference);
            Session::put('remaining_seconds', $remaining_seconds);
            Session::put('test', $test);
            //if question are
            return redirect(route("candidate.test.instruction"));
        }

        return back()->with('error', 'Invalid credentials')->withInput();
    }



}

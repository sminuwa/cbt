<?php

namespace App\Http\Controllers\Candidate\Auth;

use App\Http\Controllers\Controller;
use App\Models\ScheduledCandidate;
use App\Models\CandidateSubject;
use App\Models\Scheduling;
use App\Models\TestConfig;
use App\Models\TimeControl;
use App\Models\Candidate;
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
        $candidate_record = Candidate::where('indexing', $username)->first();
        if(!$candidate_record)
            return back()->with('error', 'Invalid credentials')->withInput();
        if($password == $candidate_record->password)
            Candidate::where('id', $candidate_record->id)->update(['password'=>bcrypt($candidate_record->password)]);
        if(!$test) return back()->with('error', 'Test Type is Invalid.')->withInput();
        $credentials = ["indexing" => $username, "password" => $password];
        if (Auth::attempt($credentials,false)) {
            // return auth()->user();
            //check candidate's schedules and compare with the selected test schedules
            $candidate = auth()->user();
            // return $candidate;
            $scheduled_candidate = $candidate->schedules($test_id);
            // return $scheduled_candidate;
            if(!$scheduled_candidate)//check if logged in candidate is scheduled for the selected exams/text.
                return back()->with('error','You are not scheduled for this test. Please select appropriate test.');
            $candidate_subjects = ScheduledCandidate::forCandidate($test->schedule_id)->get();
            // return $candidate_subjects;
            if(count($candidate_subjects) < 1)
                return back()->with('error','This test does not have any paper. Contact system administrator.');

            /*
                checking if questions are available for the number of subject assigned for the configured test selected by
            */
            foreach($candidate_subjects as $key => $subject){
                $error = CandidateSubject::find($subject->subject_id)->has_required_questions($test);
                if($error != 1)
                    return back()->with('error',$subject->name.': '.$error);
            }
            // return 'Hello';
            if($candidate->test_is_completed($test->id, $scheduled_candidate?->id)) return back()->with('error', 'You have already taken the selected test.')->withInput();
            $timeControl = $candidate->has_time_control($test->id, $scheduled_candidate?->id);
            $duration = $test->duration; //duration in minute
            // return $candidate_subjects;
            Session::put('candidate', $candidate); //assign session candidate
            Session::put('scheduled_candidate', $scheduled_candidate);
            Session::put('candidate_subjects', $candidate_subjects);
            Session::put('test', $test);
            if($timeControl){
                // return $timeControl;
                $time_difference = (strtotime($timeControl->current_time) - strtotime($timeControl->start_time)) / 60;
                if($time_difference >= $duration) return back()->with('error', 'Your test time has elapsed.')->withInput();
                $remaining_seconds = $test->duration * 60 - $timeControl->elapsed;
                Session::put('time_control', $timeControl);
                Session::put('time_elapsed', $timeControl->elapsed);
                Session::put('remaining_seconds', $remaining_seconds);
                Session::put('time_difference', $time_difference);
                return redirect(route("candidate.test.question"));
            }
            // return 'hello';
            //Redirecting to instruction page.
            return redirect(route("candidate.test.instruction"));
        }
        //if login fails.
        return back()->with('error', 'Invalid credentials')->withInput();
    }



}

<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\AnswerOption;
use App\Models\CandidateSubject;
use App\Models\Presentation;
use App\Models\ScheduledCandidate;
use App\Models\Score;
use App\Models\TestQuestion;
use App\Models\TestSection;
use App\Models\TimeControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    //
    public function question(Request $request){
        // return 'Hello world';
        //logic to get questions from question
        $presentation_records = $err = $errors = [];
        $test = session('test');
        $candidate = auth()->user();
        // return $candidate;
        $scheduled_candidate = session('scheduled_candidate');
        $candidate_subjects = session('candidate_subjects');
        //checking time control table and logics
        $ip = request()->ip();
        // return $ip;
        $timeControl = $candidate->has_time_control($test->id, $scheduled_candidate?->id);
        $duration = $test->duration; //duration in minute
        if(!$timeControl){
            $start_time = date('H:i:s');
            $current_time = date('H:i:s');
            
            $timeControl = TimeControl::createRecord($test->id,$scheduled_candidate?->id,$start_time,$current_time,0,$ip);
            if(!$timeControl) return back()->with('error', 'Error creating time control.')->withInput();
            $time_difference = (strtotime($timeControl->current_time) - strtotime($timeControl->start_time)) / 60;
            if($time_difference >= $duration) return back()->with('error', 'Your exam time has elapsed.')->withInput();
            $remaining_seconds = $test->duration * 60 - $timeControl->elapsed;
            Session::put('time_difference', $time_difference);
            Session::put('remaining_seconds', $remaining_seconds);
            Session::put('time_control', $timeControl);
            Session::put('time_elapsed', $timeControl->elapsed);
        }else{
            if($timeControl->ip == ''){
                TimeControl::find($timeControl->id)->update(['ip'=>$ip]);
            }else{
                if($timeControl->ip != $ip)
                return redirect()->route('candidate.auth.page')->with('error','Your IP has changed. Contact administrator.');
            }
            
        }

        //generating exam question
        $q_test = [];
        $i=0;
        $presentations = $candidate->presentation($test->id,$scheduled_candidate->id);
        
        if(!$presentations || count($presentations) < 1){
            // return $candidate_subjects;
            foreach($candidate_subjects as $subject) {
                $sections = TestSection::forSubjects($subject->subject_id, $test->id)
            
                ->with(['test_questions'=> function($query) use ($test) { 
                    if($test->question_administration == 'random'){  // randomization is true
                        return $query->with('answer_options', function($options) use ($test){
                            if($test->option_administration == 'random'){ // randomization is true for option
                                return $options->inRandomOrder();
                            }
                            return $options; // randomization is not true for options
                        })->inRandomOrder();
                    }

                    // randomization is not true
                    return $query->with('answer_options', function($options) use ($test){
                        if($test->option_administration == 'random'){ // randomization is true for options
                            return $options->inRandomOrder();
                        }
                        return $options; // randomization is not true for options
                    });
                
                }])->get();

                return $sections;
                
                foreach($sections as $section){
                    // $questions = TestQuestion::forSection($section->id, $test->question_administration);
                    foreach($section->test_questions as $question){
                        foreach($question->answer_options as $answer){
                            $presentation_records[] = [
                                'scheduled_candidate_id' => $scheduled_candidate->id,
                                'test_config_id' => $test->id,
                                'test_section_id' => $question->test_section_id,
                                'question_bank_id' => $answer->question_bank_id,
                                'answer_option_id' => $answer->id,
                            ];
                        }
                    }
//                    $q_test[] = $presentation_records;
                }
            }
//            return $i;
        //    return $presentation_records;
        //    $first_before =  $presentation_records[50];
//                return $q_test
//            $presentation_records = (array)$presentation_records;
            if(!Presentation::upsert($presentation_records, ['scheduled_candidate_id', 'test_config_id','test_section_id', 'question_bank_id','answer_option_id'])) {
//            if(!Presentation::create($presentation_records)) {
                reset_auto_increment('presentations');
                $errors[] = 'Something went wrong.';
            }
            // $first_after = Presentation::where('id', 51)->first();
            //getting the question goes here
            // return [$first_before, $first_after];
        }

        if(!empty($errors)) {
            return back()->with('error',implode(', ',$errors).'.');
        }

        //return $candidate_subjects;
        if(count($candidate_subjects) < 1)
            return back()->with('Questions not available for you, contact system admin.');
        $subject_id = $request->subject_id;
        $subject = CandidateSubject::find($subject_id);
        if(!$subject)
            $subject = CandidateSubject::find($candidate_subjects[0]->subject_id);
        $question_array = Presentation::question_papers($subject->id,$test->id, $scheduled_candidate->id);
    //    return $question_array;
//        $question_array = (object)$question_array;
        $question_answered = Presentation::question_answered($subject->id,$test->id, $scheduled_candidate->id);
        // return $question_array;
        return view('pages.candidate.test.question', compact('question_array','question_answered','subject'));
    }

    public function goto_paper(Request $request){
        $subject_id = $request->subject_id;
        $test_config_id = $request->test_config_id;
        $scheduled_candidate_id = $request->scheduled_candidate_id;
        $subject = CandidateSubject::find($subject_id);
        $question_array = Presentation::question_papers($subject->id,$test_config_id, $scheduled_candidate_id);
//        return $question_array;
//        $question_array = (object)array_filter($question_array);
        $question_answered = Presentation::question_answered($subject->id,$test_config_id, $scheduled_candidate_id);
        return view('pages.candidate.test.question', compact('question_array','question_answered','subject'));
    }

    public function answering(Request $request){
        $test_config_id = $request->test_config_id;
        $scheduled_candidate_id = $request->scheduled_candidate_id;
        $test_subject_id = $request->test_subject_id;
        $scores = Score::where([
            'scheduled_candidate_id' => $scheduled_candidate_id,
            'test_config_id' => $test_config_id,
            'question_bank_id' => $request->question_bank_id,
        ])->first();
        if(!$scores)
            $scores = new Score();
        $scores->scheduled_candidate_id = $scheduled_candidate_id;
        $scores->test_config_id = $test_config_id;
        $scores->point_scored = $request->mark_per_question;
        $scores->question_bank_id = $request->question_bank_id;
        $scores->answer_option_id = $request->answer_option_id;
        $scores->time_elapse = now();
        $scores->scoring_mode = $request->scoring_mode;
        if($scores->save()){
            //saving time control
            $time_control_id = $request->time_control_id;
            $remaining_seconds = $request->remaining_seconds;
            $time_elapsed = $request->time_elapsed;
            $time_control = TimeControl::find($time_control_id);
            $current_time = date('H:i:s');
            TimeControl::find($time_control_id)->update([
                'current_time' => $current_time,
                'elapsed' => $time_elapsed,
            ]);
            $time_difference = (strtotime($current_time) - strtotime($time_control->start_time)) / 60;
            Session::put('time_control', $time_control);
            Session::put('time_difference', $time_difference);
            Session::put('remaining_seconds', $remaining_seconds);
            //attempt_tracker
            $question_array = Presentation::question_papers($test_subject_id,$test_config_id, $scheduled_candidate_id);
            $question_answered = Presentation::question_answered($test_subject_id,$test_config_id, $scheduled_candidate_id);
            // return $question_array;
            return ['status'=>true, 'total'=>count($question_array), 'answered'=>count($question_answered)];
        }

        return false;
    }

    public function time_control(Request $request){
        $test_config_id = $request->test_config_id;
        $scheduled_candidate_id = $request->scheduled_candidate_id;
        $test_subject_id = $request->test_subject_id;
        $time_control_id = $request->time_control_id;
        $remaining_seconds = $request->remaining_seconds;
        $time_elapsed = $request->time_elapsed;
        $time_control = TimeControl::find($time_control_id);
        $current_time = date('H:i:s');
        TimeControl::find($time_control_id)->update([
            'current_time' => $current_time,
            'elapsed' => $time_elapsed,
        ]);
        $time_difference = (strtotime($current_time) - strtotime($time_control->start_time)) / 60;
        Session::put('time_control', $time_control);
        Session::put('time_difference', $time_difference);
        Session::put('remaining_seconds', $remaining_seconds);
        $question_array = Presentation::question_papers($test_subject_id,$test_config_id, $scheduled_candidate_id);
        return $question_array;
    }


    public function submit_test(Request $request){
        $time_control_id = $request->time_control_id;
        $remaining_seconds = $request->remaining_seconds;
        $time_elapsed = $request->time_elapsed;
        $time_control = TimeControl::find($time_control_id);
        $current_time = date('H:i:s');
        TimeControl::find($time_control_id)->update([
            'current_time' => $current_time,
            'elapsed' => $time_elapsed,
            'completed' => 1,
        ]);
        $time_difference = (strtotime($current_time) - strtotime($time_control->start_time)) / 60;
        Session::put('time_control', $time_control);
        Session::put('time_difference', $time_difference);
        Session::put('remaining_seconds', $remaining_seconds);

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return ['status'=>true, 'message'=>'Time is Up','url'=>route('candidate.auth.page')];
    }

}

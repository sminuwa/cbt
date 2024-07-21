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
    public function question(){
        //logic to get questions from question
        $presentation_records = $err = $errors = [];
        $test = session('test');
        $candidate = auth()->user();
        $scheduled_candidate = session('scheduled_candidate');
        $candidate_subjects = session('candidate_subjects');
        //checking time control table and logics
        $timeControl = $candidate->has_time_control($test->id, $scheduled_candidate?->id);
        $duration = $test->duration; //duration in minute
        if(!$timeControl){
            $start_time = date('H:i:s');
            $current_time = date('H:i:s');
            $ip = request()->ip();
            $timeControl = TimeControl::createRecord($test->id,$scheduled_candidate?->id,$start_time,$current_time,0,$ip);
            if(!$timeControl) return back()->with('error', 'Error creating time control.')->withInput();
            $time_difference = (strtotime($timeControl->current_time) - strtotime($timeControl->start_time)) / 60;
            if($time_difference >= $duration) return back()->with('error', 'Your exam time has elapsed.')->withInput();
            $remaining_seconds = $test->duration * 60 - $timeControl->elapsed;
            Session::put('time_difference', $time_difference);
            Session::put('remaining_seconds', $remaining_seconds);
            Session::put('time_control', $timeControl);
            Session::put('time_elapsed', $timeControl->elapsed);
        }


        //generating exam question
        $presentations = $candidate->presentation($test->id,$scheduled_candidate->id);
        if(!$presentations || count($presentations) < 1){
            foreach($candidate_subjects as $subject) {
                $sections = TestSection::forSubjects($subject->subject_id, $test->id)->get();
                foreach($sections as $section){
                    $questions = TestQuestion::forSection($section->id, $test->question_administration);
                    foreach($questions as $question){
                        $answers = AnswerOption::for_questions($question->id, $test->option_administration);
                        foreach($answers as $answer){
                            $presentation_records[] = [
                                'scheduled_candidate_id' => $scheduled_candidate->id,
                                'test_config_id' => $test->id,
                                'test_section_id' => $question->test_section_id,
                                'question_bank_id' => $answer->question_bank_id,
                                'answer_option_id' => $answer->id,
                            ];
                        }
                    }
                }
            }

            foreach(array_chunk($presentation_records, 1000) as $key => $p) {
                if(!Presentation::upsert($p, ['scheduled_candidate_id', 'test_config_id','test_section_id', 'question_bank_id','answer_option_id'])) {
                    reset_auto_increment('presentations');
                    $err[] = 'Something went wrong.';
                }
                if(count($err) == 0){
                    reset_auto_increment('presentations');
                }else{
                    $errors[] = 'Something went wrong while updating papers records for graduands.';
                }
            }
            //getting the question goes here
        }

        if(!empty($errors)) {
            return back()->with('error',implode(', ',$errors).'.');
        }

        //return $candidate_subjects;
        if(count($candidate_subjects) < 1)
            return back()->with('Questions not available for you, contact system admin.');
        $subject = CandidateSubject::find($candidate_subjects[0]->subject_id);
        $question_array = Presentation::question_papers($subject->id,$test->id, $scheduled_candidate->id);
//        return $question_array;
        $question_array = (object)$question_array;
        return view('pages.candidate.test.question', compact('question_array','subject'));
    }

    public function goto_paper(Request $request){
        $subject_id = $request->subject_id;
        $test_config_id = $request->test_config_id;
        $scheduled_candidate_id = $request->scheduled_candidate_id;
        $subject = CandidateSubject::find($subject_id);
        $question_array = Presentation::question_papers($subject->id,$test_config_id, $scheduled_candidate_id);
//        return $question_array;
        $question_array = (object)array_filter($question_array);
        return view('pages.candidate.test.question', compact('question_array','subject'));
    }

    public function answering(Request $request){
        $test_config_id = $request->test_config_id;
        $scheduled_candidate_id = $request->scheduled_candidate_id;
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
            $qs = Presentation::selectRaw("
                presentations.question_bank_id as question_bank_id,
                test_sections.title as section_title,
                test_sections.mark_per_question as mark_per_question,
                test_sections.instruction as section_instruction,
                test_subjects.test_config_id,
                question_banks.title as question_name,
                (SELECT question_bank_id
                    FROM scores
                    WHERE scores.question_bank_id = presentations.question_bank_id
                    GROUP BY scores.question_bank_id) as has_score
            ")->join('test_sections', 'test_sections.id', 'presentations.test_section_id')
                ->join('question_banks', 'question_banks.id', 'presentations.question_bank_id')
                ->join('test_subjects', 'test_subjects.id', 'test_sections.test_subject_id')
                ->where([
                    'test_subjects.test_config_id'=>$test_config_id,
                    'scheduled_candidate_id'=>$scheduled_candidate_id
                ])
                ->distinct()
                ->get();
            return $time_control;
        }

        return false;
    }

    public function time_control(Request $request){
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
        return $time_control;
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

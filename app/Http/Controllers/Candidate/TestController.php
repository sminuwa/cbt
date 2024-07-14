<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\AnswerOption;
use App\Models\Presentation;
use App\Models\TestQuestion;
use App\Models\TestSection;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function question(){
        //logic to get questions from question
        $presentation_records = $err = $errors = [];
        $candidate = auth()->user();
        $test = session('test');
        $scheduled_candidate = session('scheduled_candidate');
        $candidate_subjects = session('candidate_subjects');
        $presentations = $candidate->presentation($test->id,$scheduled_candidate->id);
        if(!$presentations || count($presentations) < 1){
            foreach($candidate_subjects as $key=>$subject) {
                $sections = TestSection::forSubjects($subject->subject_id, $test->id, $test->question_administration)->get();
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
                    $err[] = 'Something went wrong. [Graduands chunk upload]';
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

        $test_questions = Presentation::selectRaw("
            question_bank_id,
            (SELECT question_bank_id FROM scores where scores.question_bank_id = question_bank_id limit 1) as has_score
            ")->distinct()->get();

        return view('pages.candidate.test.question', compact('test_questions'));
    }

}

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

        $all_test_questions = Presentation::selectRaw("
            question_bank_id,
            (SELECT question_bank_id
                FROM scores
                WHERE scores.question_bank_id = presentations.question_bank_id
                AND scores.scheduled_candidate_id = presentations.scheduled_candidate_id
                AND scores.test_config_id = presentations.test_config_id
                LIMIT 1) as has_score
            ")->distinct()->get();


        $question_papers = $question_array = $answer_array = [];
//        return $candidate_subjects;
        foreach($candidate_subjects as $subject){
            $subject_id = $subject->subject_id;
            $test_config_id = $test->id;

            $get_questions = Presentation::selectRaw("
                presentations.question_bank_id as question_bank_id,
                test_sections.title as section_title,
                test_sections.instruction as section_instruction,
                test_subjects.test_config_id,
                question_banks.title as question_name
            ")->join('test_sections', 'test_sections.id', 'presentations.test_section_id')
                ->join('question_banks', 'question_banks.id', 'presentations.question_bank_id')
                ->join('test_subjects', 'test_subjects.id', 'test_sections.test_subject_id')
                ->distinct()
                ->where(['test_subjects.subject_id'=>$subject_id, 'test_subjects.test_config_id'=>$test_config_id])->get();

            foreach($get_questions as $q){
                $answer_array = [];
                $get_answers = Presentation::selectRaw("
                    presentations.*,
                    question_banks.title as question_name,
                    answer_options.id as answer_option_id,
                    answer_options.question_option as answer_name,
                    (SELECT answer_option_id
                        FROM scores
                        WHERE scores.answer_option_id = presentations.answer_option_id
                        AND scores.scheduled_candidate_id = presentations.scheduled_candidate_id
                        AND scores.test_config_id = presentations.test_config_id
                    LIMIT 1) as selected_answer_option
                ")->join('test_sections', 'test_sections.id', 'presentations.test_section_id')
                ->join('question_banks', 'question_banks.id', 'presentations.question_bank_id')
                ->join('test_subjects', 'test_subjects.id', 'test_sections.test_subject_id')
                ->join('answer_options', 'answer_options.id', 'presentations.answer_option_id')
                ->distinct()
                ->where(['test_subjects.subject_id'=>$subject_id, 'test_subjects.test_config_id'=>$test_config_id, 'question_banks.id'=>$q->question_bank_id])->get();
                foreach($get_answers as $a){
                    $answer_array[] = [
                        'answer_option_id'=>$a->answer_option_id,
                        'answer_name'=>$a->answer_name,
                        'selected_answer_option'=>$a->selected_answer_option,
                    ];
                }
                $question_array[] = [
                    'question_bank_id'=>$q->question_bank_id,
                    'section_title'=>$q->section_title,
                    'section_instruction'=>$q->section_instruction,
                    'question_name'=>$q->question_name,
                    'answer_options'=>$answer_array,
                ];

            }

            /*$paper_info = [];
            foreach($pre as $p){
                $paper_info[] = [
                    'test_config_id'=>$p->answer_option_id,
                    'section_title'=>$p->section_title,
                    'section_instruction'=>$p->section_instruction,
                    'question_bank_id'=>$p->question_bank_id,
                    'answer_option_id'=>$p->answer_option_id,
                    'selected_answer_option'=>$p->selected_answer_option,
                    'question_name'=>$p->question_name,
                    'answer_name'=>$p->answer_name,
                ];
            }
            $question_papers[] = [
                'subject_id' => $subject->subject_id,
                'schedule_id' => $subject->schedule_id,
                'candidate_id' => $subject->candidate_id,
                'paper_name' => $subject->name,
                'exam_type' => $subject->exam_type,
                'paper_info' => $paper_info
            ];*/

        }
        $question_array = (object)array_filter($question_array);
        return view('pages.candidate.test.question', compact('all_test_questions','question_array'));
    }

}

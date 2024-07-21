<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function question_papers($subject_id, $test_config_id = null, $scheduled_candidate_id=null)  {
        if(is_null($test_config_id))
            $test_config_id = session('test')->id;
        if(is_null($scheduled_candidate_id))
            $scheduled_candidate_id = session('$scheduled_candidate')->id;
        $question_array = [];
        $get_questions = Presentation::selectRaw("
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
                'test_subjects.subject_id'=>$subject_id,
                'test_subjects.test_config_id'=>$test_config_id,
                'scheduled_candidate_id'=>$scheduled_candidate_id
            ])
            ->distinct()
            ->get();

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
                ->where([
                    'presentations.scheduled_candidate_id'=>$scheduled_candidate_id,
                    'test_subjects.subject_id'=>$subject_id,
                    'test_subjects.test_config_id'=>$test_config_id,
                    'question_banks.id'=>$q->question_bank_id
                ])->get();
            foreach($get_answers as $a){
                $answer_array[] = [
                    'test_section_id'=>$a->test_section_id,
                    'answer_option_id'=>$a->answer_option_id,
                    'answer_name'=>$a->answer_name,
                    'selected_answer_option'=>$a->selected_answer_option,
                ];
            }
            $question_array[] = [
                'test_config_id'=>$q->test_config_id,
                'question_bank_id'=>$q->question_bank_id,
                'section_title'=>$q->section_title,
                'section_instruction'=>$q->section_instruction,
                'mark_per_question'=>$q->mark_per_question,
                'question_name'=>$q->question_name,
                'has_score'=>$q->has_score,
                'answer_options'=>$answer_array,
            ];
        }

        return $question_array;
    }
}

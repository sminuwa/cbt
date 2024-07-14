<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

/**
 * Class TestQuestion
 *
 * @property int $id
 * @property int $test_section_id
 * @property int $question_bank_id
 * @property int $version
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property QuestionBank $question_bank
 * @property TestSection $test_section
 *
 * @package App\Models
 */
class TestQuestion extends Model
{
	protected $table = 'test_questions';

	protected $casts = [
		'test_section_id' => 'int',
		'question_bank_id' => 'int',
		'version' => 'int'
	];
    protected $guarded = [];

	public function question_bank()
	{
		return $this->belongsTo(QuestionBank::class);
	}

	public function test_section()
	{
		return $this->belongsTo(TestSection::class);
	}

    public static function forSection($test_section_id, $question_administration){
        $section = TestSection::find($test_section_id);
        $simple = self::
            join('question_banks', 'question_banks.id', 'test_questions.question_bank_id')
            ->where('test_questions.test_section_id', $section->id)
            ->where('question_banks.difficulty_level', 'simple')
            ->limit($section->num_of_simple)
            ->select('test_questions.*');
        if($question_administration == 'random'){
            $simple->inRandomOrder();
        }
        $moderate = self::
        join('question_banks', 'question_banks.id', 'test_questions.question_bank_id')
            ->where('test_questions.test_section_id', $section->id)
            ->where('question_banks.difficulty_level', 'moderate')
            ->limit($section->num_of_moderate)
            ->select('test_questions.*');
        if($question_administration == 'random'){
            $moderate->inRandomOrder();
        }
        $difficult = self::
        join('question_banks', 'question_banks.id', 'test_questions.question_bank_id')
            ->where('test_questions.test_section_id', $section->id)
            ->where('question_banks.difficulty_level', 'difficult')
            ->limit($section->num_of_difficult)
            ->select('test_questions.*');
        if($question_administration == 'random'){
            $difficult->inRandomOrder();
        }
        $question = $simple->union($moderate)->union($difficult)->get();
        return $question;
    }
}

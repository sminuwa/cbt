<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

/**
 * Class AnswerOption
 *
 * @property int $id
 * @property string|null $question_option
 * @property int|null $question_bank_id
 * @property int|null $correctness
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property QuestionBank|null $question_bank
 *
 * @package App\Models
 */
class AnswerOption extends Model
{
	protected $table = 'answer_options';

	protected $casts = [
		'question_bank_id' => 'int',
		'correctness' => 'int'
	];

	protected $fillable = [
		'question_option',
		'question_bank_id',
		'correctness'
	];

	public function question_bank()
	{
		return $this->belongsTo(QuestionBank::class);
	}

    public static function for_questions($question_bank_id, $option_administration){
        $answers = self::where('question_bank_id', $question_bank_id);
        if($option_administration == 'random')
            $answers->inRandomOrder();
        return $answers->get();
    }
}

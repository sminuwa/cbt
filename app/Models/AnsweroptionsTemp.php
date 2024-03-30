<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AnsweroptionsTemp
 * 
 * @property int $id
 * @property string|null $question_option
 * @property int|null $question_bank_id
 * @property string|null $correctness
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AnsweroptionsTemp extends Model
{
	protected $table = 'answeroptions_temps';

	protected $casts = [
		'question_bank_id' => 'int'
	];

	protected $fillable = [
		'question_option',
		'question_bank_id',
		'correctness'
	];
}

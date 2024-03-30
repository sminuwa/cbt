<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionBankTemp
 * 
 * @property int $id
 * @property string $title
 * @property string|null $difficulty_level
 * @property Carbon|null $questiontime
 * @property string|null $active
 * @property int|null $author
 * @property int|null $subject_id
 * @property string|null $topic
 * @property int|null $topic_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class QuestionBankTemp extends Model
{
	protected $table = 'question_bank_temps';

	protected $casts = [
		'questiontime' => 'datetime',
		'author' => 'int',
		'subject_id' => 'int',
		'topic_id' => 'int'
	];

	protected $fillable = [
		'title',
		'difficulty_level',
		'questiontime',
		'active',
		'author',
		'subject_id',
		'topic',
		'topic_id'
	];
}

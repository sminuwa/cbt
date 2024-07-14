<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionBank
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
 * @property Subject|null $subject
 * @property Collection|AnswerOption[] $answer_options
 * @property Collection|TestQuestion[] $test_questions
 *
 * @package App\Models
 */
class QuestionBank extends Model
{
	protected $table = 'question_banks';

	protected $casts = [
		'questiontime' => 'datetime',
		'author' => 'int',
		'subject_id' => 'int',
		'topic_id' => 'int'
	];

	protected $fillable = [
        'id',
		'title',
		'difficulty_level',
		'questiontime',
		'active',
		'author',
		'subject_id',
		'topic',
		'topic_id'
	];

	public function topic()
	{
		return $this->belongsTo(Topic::class);
	}

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}

	public function answer_options()
	{
		return $this->hasMany(AnswerOption::class);
	}

	public function test_questions()
	{
		return $this->hasMany(TestQuestion::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subject
 *
 * @property int $id
 * @property string $subject_code
 * @property int|null $exam_type_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property ExamType|null $exam_type
 * @property Collection|CandidateStudent[] $candidate_students
 * @property Collection|QuestionBank[] $question_banks
 * @property Collection|TestCompositor[] $test_compositors
 * @property Collection|TestSubject[] $test_subjects
 * @property Collection|Topic[] $topics
 *
 * @package App\Models
 */
class Subject extends Model
{
	protected $table = 'subjects';

	protected $casts = [
		'exam_type_id' => 'int'
	];

	protected $fillable = [
		'subject_code',
		'exam_type_id',
		'name'
	];

	public function exam_type()
	{
		return $this->belongsTo(ExamType::class);
	}

	public function candidate_students()
	{
		return $this->hasMany(CandidateStudent::class);
	}

	public function question_banks()
	{
		return $this->hasMany(QuestionBank::class);
	}

	public function test_compositors()
	{
		return $this->hasMany(TestCompositor::class);
	}

	public function test_subjects()
	{
		return $this->hasMany(TestSubject::class);
	}

	public function topics()
	{
		return $this->hasMany(Topic::class);
	}
}

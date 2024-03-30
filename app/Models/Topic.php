<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Topic
 * 
 * @property int $id
 * @property int $subject_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Subject $subject
 * @property Collection|QuestionBank[] $question_banks
 *
 * @package App\Models
 */
class Topic extends Model
{
	protected $table = 'topics';

	protected $casts = [
		'subject_id' => 'int'
	];

	protected $fillable = [
		'subject_id',
		'name'
	];

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}

	public function question_banks()
	{
		return $this->hasMany(QuestionBank::class);
	}
}

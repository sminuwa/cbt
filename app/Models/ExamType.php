<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExamType
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|ScheduledCandidate[] $scheduled_candidates
 * @property Collection|Subject[] $subjects
 *
 * @package App\Models
 */
class ExamType extends Model
{
	protected $table = 'exam_types';

	protected $fillable = [
		'name'
	];

	public function scheduled_candidates()
	{
		return $this->hasMany(ScheduledCandidate::class, 'candidate_type_id');
	}

	public function subjects()
	{
		return $this->hasMany(Subject::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FacultyScheduleMapping
 * 
 * @property int $id
 * @property int $faculty_id
 * @property int $scheduling_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Faculty $faculty
 * @property Scheduling $scheduling
 *
 * @package App\Models
 */
class FacultyScheduleMapping extends Model
{
	protected $table = 'faculty_schedule_mappings';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'faculty_id' => 'int',
		'scheduling_id' => 'int'
	];

	protected $fillable = [
		'id',
		'faculty_id',
		'scheduling_id'
	];

	public function faculty()
	{
		return $this->belongsTo(Faculty::class);
	}

	public function scheduling()
	{
		return $this->belongsTo(Scheduling::class);
	}
}

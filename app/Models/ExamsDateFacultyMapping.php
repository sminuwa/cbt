<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExamsDateFacultyMapping
 * 
 * @property int $id
 * @property int|null $scheduling_id
 * @property int $faculty_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Faculty $faculty
 * @property Scheduling|null $scheduling
 *
 * @package App\Models
 */
class ExamsDateFacultyMapping extends Model
{
	protected $table = 'exams_date_faculty_mappings';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'scheduling_id' => 'int',
		'faculty_id' => 'int'
	];

	protected $fillable = [
		'id',
		'scheduling_id',
		'faculty_id'
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

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Faculty
 * 
 * @property int $id
 * @property string $name
 * @property int $complex_id
 * @property bool|null $is_other_institutes
 * @property string $faculty_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Department[] $departments
 * @property ExamsDateFacultyMapping $exams_date_faculty_mapping
 * @property FacultyScheduleMapping $faculty_schedule_mapping
 *
 * @package App\Models
 */
class Faculty extends Model
{
	protected $table = 'faculties';

	protected $casts = [
		'complex_id' => 'int',
		'is_other_institutes' => 'bool'
	];

	protected $fillable = [
		'name',
		'complex_id',
		'is_other_institutes',
		'faculty_code'
	];

	public function departments()
	{
		return $this->hasMany(Department::class);
	}

	public function exams_date_faculty_mapping()
	{
		return $this->hasOne(ExamsDateFacultyMapping::class);
	}

	public function faculty_schedule_mapping()
	{
		return $this->hasOne(FacultyScheduleMapping::class);
	}
}

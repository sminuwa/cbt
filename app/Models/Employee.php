<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * 
 * @property int $id
 * @property string $first_name
 * @property string $surname
 * @property string|null $other_names
 * @property int|null $department_id
 * @property Carbon $date_of_first_appointment
 * @property int $rank_on_employment
 * @property string $salary_on_appointment
 * @property Carbon|null $date_of_birth
 * @property int $nationality
 * @property int|null $lga
 * @property string|null $place_of_birth
 * @property string|null $marital_status
 * @property string $gender
 * @property string|null $permanent_address
 * @property string|null $personnel_no
 * @property string|null $status
 * 
 * @property Department|null $department
 *
 * @package App\Models
 */
class Employee extends Model
{
	protected $table = 'employees';
	public $timestamps = false;

	protected $casts = [
		'department_id' => 'int',
		'date_of_first_appointment' => 'datetime',
		'rank_on_employment' => 'int',
		'date_of_birth' => 'datetime',
		'nationality' => 'int',
		'lga' => 'int'
	];

	protected $fillable = [
		'first_name',
		'surname',
		'other_names',
		'department_id',
		'date_of_first_appointment',
		'rank_on_employment',
		'salary_on_appointment',
		'date_of_birth',
		'nationality',
		'lga',
		'place_of_birth',
		'marital_status',
		'gender',
		'permanent_address',
		'personnel_no',
		'status'
	];

	public function department()
	{
		return $this->belongsTo(Department::class);
	}
}

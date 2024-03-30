<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $name
 * @property int|null $faculty_id
 * @property int $dept_type
 * @property string $department_code
 * 
 * @property Faculty|null $faculty
 * @property Collection|Employee[] $employees
 * @property Collection|Programme[] $programmes
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';
	public $timestamps = false;

	protected $casts = [
		'faculty_id' => 'int',
		'dept_type' => 'int'
	];

	protected $fillable = [
		'name',
		'faculty_id',
		'dept_type',
		'department_code'
	];

	public function faculty()
	{
		return $this->belongsTo(Faculty::class);
	}

	public function employees()
	{
		return $this->hasMany(Employee::class);
	}

	public function programmes()
	{
		return $this->hasMany(Programme::class);
	}
}

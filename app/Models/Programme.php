<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Programme
 * 
 * @property int $id
 * @property int $department_id
 * @property string $name
 * @property string $duration
 * @property int $programme_type_id
 * @property string|null $art_science
 * @property string|null $hprog_type_code
 * @property string $pcode
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ProgrammeType $programme_type
 * @property Department $department
 * @property ExamsDateProgrammeMapping $exams_date_programme_mapping
 *
 * @package App\Models
 */
class Programme extends Model
{
	protected $table = 'programmes';

	protected $casts = [
		'department_id' => 'int',
		'programme_type_id' => 'int'
	];

	protected $fillable = [
		'department_id',
		'name',
		'duration',
		'programme_type_id',
		'art_science',
		'hprog_type_code',
		'pcode'
	];

	public function programme_type()
	{
		return $this->belongsTo(ProgrammeType::class);
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function exams_date_programme_mapping()
	{
		return $this->hasOne(ExamsDateProgrammeMapping::class);
	}
}

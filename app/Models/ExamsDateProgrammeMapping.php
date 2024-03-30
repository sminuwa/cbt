<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExamsDateProgrammeMapping
 * 
 * @property int $id
 * @property int|null $scheduling_id
 * @property int $programme_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Programme $programme
 * @property Scheduling|null $scheduling
 *
 * @package App\Models
 */
class ExamsDateProgrammeMapping extends Model
{
	protected $table = 'exams_date_programme_mappings';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'scheduling_id' => 'int',
		'programme_id' => 'int'
	];

	protected $fillable = [
		'id',
		'scheduling_id',
		'programme_id'
	];

	public function programme()
	{
		return $this->belongsTo(Programme::class);
	}

	public function scheduling()
	{
		return $this->belongsTo(Scheduling::class);
	}
}

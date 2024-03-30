<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExamsDateStateMapping
 * 
 * @property int $id
 * @property int|null $scheduling_id
 * @property int $state_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Scheduling|null $scheduling
 * @property State $state
 *
 * @package App\Models
 */
class ExamsDateStateMapping extends Model
{
	protected $table = 'exams_date_state_mappings';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'scheduling_id' => 'int',
		'state_id' => 'int'
	];

	protected $fillable = [
		'id',
		'scheduling_id',
		'state_id'
	];

	public function scheduling()
	{
		return $this->belongsTo(Scheduling::class);
	}

	public function state()
	{
		return $this->belongsTo(State::class);
	}
}

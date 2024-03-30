<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeControl
 * 
 * @property int $id
 * @property int $test_id
 * @property int $candidate_id
 * @property bool $completed
 * @property Carbon $start_time
 * @property Carbon $curent_time
 * @property int $elapsed
 * @property string $ip
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ScheduledCandidate $scheduled_candidate
 * @property TestConfig $test_config
 *
 * @package App\Models
 */
class TimeControl extends Model
{
	protected $table = 'time_controls';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'test_id' => 'int',
		'candidate_id' => 'int',
		'completed' => 'bool',
		'start_time' => 'datetime',
		'curent_time' => 'datetime',
		'elapsed' => 'int'
	];

	protected $fillable = [
		'id',
		'completed',
		'start_time',
		'curent_time',
		'elapsed',
		'ip'
	];

	public function scheduled_candidate()
	{
		return $this->belongsTo(ScheduledCandidate::class, 'candidate_id');
	}

	public function test_config()
	{
		return $this->belongsTo(TestConfig::class, 'test_id');
	}
}

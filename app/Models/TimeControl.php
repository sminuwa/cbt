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
 * @property int $test_config_id
 * @property int $scheduled_candidate_id
 * @property bool $completed
 * @property Carbon $start_time
 * @property Carbon $current_time
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
	protected $casts = [
		'id' => 'int',
		'test_config_id' => 'int',
		'scheduled_candidate_id' => 'int',
		'completed' => 'bool',
		'elapsed' => 'int'
	];

	protected $guarded = [];

	public function scheduled_candidate()
	{
		return $this->belongsTo(ScheduledCandidate::class, 'candidate_id');
	}

	public function test_config()
	{
		return $this->belongsTo(TestConfig::class, 'test_id');
	}


    public static function createRecord($test_config_id, $scheduled_candidate_id, $start_time, $current_time, $elapsed, $ip = null){
        $record = new self;
        $record->test_config_id = $test_config_id;
        $record->scheduled_candidate_id = $scheduled_candidate_id;
        $record->completed = 0;
        $record->start_time = $start_time;
        $record->current_time = $current_time;
        $record->elapsed = $elapsed;
        $record->ip = $ip;
        if($record->save())
            return $record;
        return false;
    }
}

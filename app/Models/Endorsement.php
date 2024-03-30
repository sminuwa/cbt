<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Endorsement
 * 
 * @property int $id
 * @property int $candidate_id
 * @property int $test_id
 * @property string $pass_key
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TestConfig $test_config
 * @property ScheduledCandidate $scheduled_candidate
 *
 * @package App\Models
 */
class Endorsement extends Model
{
	protected $table = 'endorsements';

	protected $casts = [
		'candidate_id' => 'int',
		'test_id' => 'int'
	];

	protected $fillable = [
		'candidate_id',
		'test_id',
		'pass_key'
	];

	public function test_config()
	{
		return $this->belongsTo(TestConfig::class, 'test_id');
	}

	public function scheduled_candidate()
	{
		return $this->belongsTo(ScheduledCandidate::class, 'candidate_id');
	}
}

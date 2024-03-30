<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FeedBack
 * 
 * @property int $id
 * @property int $test_id
 * @property int $candidate_id
 * @property string $comments
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TestConfig $test_config
 * @property ScheduledCandidate $scheduled_candidate
 *
 * @package App\Models
 */
class FeedBack extends Model
{
	protected $table = 'feed_backs';

	protected $casts = [
		'test_id' => 'int',
		'candidate_id' => 'int'
	];

	protected $fillable = [
		'test_id',
		'candidate_id',
		'comments'
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

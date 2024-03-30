<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestCompositor
 * 
 * @property int $id
 * @property int $user_id
 * @property int $test_id
 * @property int $subject_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Subject $subject
 * @property TestConfig $test_config
 * @property User $user
 *
 * @package App\Models
 */
class TestCompositor extends Model
{
	protected $table = 'test_compositors';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'user_id' => 'int',
		'test_id' => 'int',
		'subject_id' => 'int'
	];

	protected $fillable = [
		'id'
	];

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}

	public function test_config()
	{
		return $this->belongsTo(TestConfig::class, 'test_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestInvigilator
 * 
 * @property int $id
 * @property int $user_id
 * @property int $test_id
 * @property int $scheduling_id
 * @property string $pass_key
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Scheduling $scheduling
 * @property TestConfig $test_config
 *
 * @package App\Models
 */
class TestInvigilator extends Model
{
	protected $table = 'test_invigilators';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'user_id' => 'int',
		'test_id' => 'int',
		'scheduling_id' => 'int'
	];

	protected $fillable = [
		'id',
		'pass_key'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function scheduling()
	{
		return $this->belongsTo(Scheduling::class);
	}

	public function test_config()
	{
		return $this->belongsTo(TestConfig::class, 'test_id');
	}
}

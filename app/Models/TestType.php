<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestType
 *
 * @property int $id
 * @property string|null $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|TestConfig[] $test_configs
 *
 * @package App\Models
 */
class TestType extends Model
{
	protected $table = 'test_types';

	protected $guarded = [];

	public function test_configs()
	{
		return $this->hasMany(TestConfig::class);
	}
}

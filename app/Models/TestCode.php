<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestCode
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|TestConfig[] $test_configs
 *
 * @package App\Models
 */
class TestCode extends Model
{
	protected $table = 'test_codes';
    protected $guarded=[];

	public function test_configs()
	{
		return $this->hasMany(TestConfig::class);
	}
}

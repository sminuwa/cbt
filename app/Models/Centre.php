<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Centre
 *
 * @property int $id
 * @property string|null $name
 * @property string $location
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Venue[] $venues
 *
 * @package App\Models
 */
class Centre extends Model
{
	protected $table = 'centres';

	protected $fillable = ['id',
		'name',
		'location',
		'status'
	];

	public function venues()
	{
		return $this->hasMany(Venue::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

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
class Centre extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	protected $table = 'centres';

	protected $guarded = [];

	public function venues()
	{
		return $this->hasMany(Venue::class);
	}
}

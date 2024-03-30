<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Host
 * 
 * @property int $id
 * @property string|null $ip_uv
 * @property string|null $ip_lv
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Venue[] $venues
 *
 * @package App\Models
 */
class Host extends Model
{
	protected $table = 'hosts';

	protected $fillable = [
		'ip_uv',
		'ip_lv'
	];

	public function venues()
	{
		return $this->hasMany(Venue::class);
	}
}

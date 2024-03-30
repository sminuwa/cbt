<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Venue
 * 
 * @property int $id
 * @property int $centre_id
 * @property int|null $host_id
 * @property string $name
 * @property string|null $location
 * @property int $capacity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Centre $centre
 * @property Host|null $host
 * @property Collection|Scheduling[] $schedulings
 *
 * @package App\Models
 */
class Venue extends Model
{
	protected $table = 'venues';

	protected $casts = [
		'centre_id' => 'int',
		'host_id' => 'int',
		'capacity' => 'int'
	];

	protected $fillable = [
		'centre_id',
		'host_id',
		'name',
		'location',
		'capacity'
	];

	public function centre()
	{
		return $this->belongsTo(Centre::class);
	}

	public function host()
	{
		return $this->belongsTo(Host::class);
	}

	public function schedulings()
	{
		return $this->hasMany(Scheduling::class);
	}
}

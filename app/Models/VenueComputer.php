<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VenueComputer
 * 
 * @property int $id
 * @property int $venue_id
 * @property string $computer_mac_address
 * @property string $computer_ip
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class VenueComputer extends Model
{
	protected $table = 'venue_computers';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'venue_id' => 'int'
	];

	protected $fillable = [
		'id',
		'computer_ip'
	];
}

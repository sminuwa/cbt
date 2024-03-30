<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lga
 * 
 * @property int $id
 * @property int $state_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property State $state
 *
 * @package App\Models
 */
class Lga extends Model
{
	protected $table = 'lgas';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'state_id' => 'int'
	];

	protected $fillable = [
		'state_id',
		'name'
	];

	public function state()
	{
		return $this->belongsTo(State::class);
	}
}

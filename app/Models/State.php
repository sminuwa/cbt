<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 * 
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ExamsDateStateMapping $exams_date_state_mapping
 * @property Collection|Lga[] $lgas
 *
 * @package App\Models
 */
class State extends Model
{
	protected $table = 'states';

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'name',
		'country_id'
	];

	public function exams_date_state_mapping()
	{
		return $this->hasOne(ExamsDateStateMapping::class);
	}

	public function lgas()
	{
		return $this->hasMany(Lga::class);
	}
}

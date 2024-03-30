<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProgrammeType
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Programme[] $programmes
 *
 * @package App\Models
 */
class ProgrammeType extends Model
{
	protected $table = 'programme_types';

	protected $fillable = [
		'name'
	];

	public function programmes()
	{
		return $this->hasMany(Programme::class);
	}
}

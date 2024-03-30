<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoginData
 * 
 * @property string $username
 * @property string $password
 * @property int $enabled
 *
 * @package App\Models
 */
class LoginData extends Model
{
	protected $table = 'login_datas';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'enabled' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'password',
		'enabled'
	];
}

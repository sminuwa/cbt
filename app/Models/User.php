<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $display_name
 * @property string $email
 * @property string $personnel_no
 * @property int $enabled
 * @property string $question
 * @property string $answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TestCompositor[] $test_compositors
 * @property Collection|TestConfig[] $test_configs
 * @property Collection|TestInvigilator[] $test_invigilators
 * @property Collection|Permission[] $permissions
 * @property Collection|Role[] $roles
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'enabled' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'password',
		'display_name',
		'email',
		'personnel_no',
		'enabled',
		'question',
		'answer'
	];

	public function test_compositors()
	{
		return $this->hasMany(TestCompositor::class);
	}

	public function test_configs()
	{
		return $this->hasMany(TestConfig::class, 'initiated_by');
	}

	public function test_invigilators()
	{
		return $this->hasMany(TestInvigilator::class);
	}

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'user_permissions')
					->withPivot('id')
					->withTimestamps();
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'user_roles')
					->withPivot('id')
					->withTimestamps();
	}
}

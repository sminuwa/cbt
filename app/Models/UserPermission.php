<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPermission
 * 
 * @property int $id
 * @property int $user_id
 * @property int $permission_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Permission $permission
 *
 * @package App\Models
 */
class UserPermission extends Model
{
	protected $table = 'user_permissions';

	protected $casts = [
		'user_id' => 'int',
		'permission_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'permission_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}
}

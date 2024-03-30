<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SbrsStudent
 * 
 * @property int $id
 * @property string|null $old_sbrsno
 * @property string|null $sbrs_no
 * @property string|null $jamb_no
 * @property string|null $combination
 * @property string $surname
 * @property string $first_name
 * @property string|null $other_names
 * @property string|null $gender
 * @property Carbon|null $dob
 * @property int|null $lga
 * @property string|null $lgac
 * @property int|null $state
 * @property string|null $statec
 * @property int|null $nationality
 * @property string|null $entry_session
 * @property string|null $contact_address
 * @property string|null $home_address
 * @property string|null $gsm_number
 * @property string|null $email
 * @property string|null $login_password
 * @property int|null $first_choice
 * @property int|null $second_choice
 * @property string|null $firstc
 * @property string|null $secondc
 * @property float|null $cgpa
 * @property string|null $enable_std
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SbrsStudent extends Model
{
	protected $table = 'sbrs_students';

	protected $casts = [
		'dob' => 'datetime',
		'lga' => 'int',
		'state' => 'int',
		'nationality' => 'int',
		'first_choice' => 'int',
		'second_choice' => 'int',
		'cgpa' => 'float'
	];

	protected $hidden = [
		'login_password'
	];

	protected $fillable = [
		'old_sbrsno',
		'sbrs_no',
		'jamb_no',
		'combination',
		'surname',
		'first_name',
		'other_names',
		'gender',
		'dob',
		'lga',
		'lgac',
		'state',
		'statec',
		'nationality',
		'entry_session',
		'contact_address',
		'home_address',
		'gsm_number',
		'email',
		'login_password',
		'first_choice',
		'second_choice',
		'firstc',
		'secondc',
		'cgpa',
		'enable_std'
	];
}

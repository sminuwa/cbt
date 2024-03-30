<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Jamb
 * 
 * @property int $id
 * @property string $reg_number
 * @property string $candidate_name
 * @property string $state_id
 * @property string $lga_id
 * @property string $gender
 * @property int $age
 * @property int $eng_score
 * @property string $subj_2
 * @property int $subj_2_Score
 * @property string $subj_3
 * @property int $subj_3_Score
 * @property string $subj_4
 * @property int $subj_4_Score
 * @property int $total_Score
 * @property string $faculty_id
 * @property string $programme_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Jamb extends Model
{
	protected $table = 'jambs';

	protected $casts = [
		'age' => 'int',
		'eng_score' => 'int',
		'subj_2_Score' => 'int',
		'subj_3_Score' => 'int',
		'subj_4_Score' => 'int',
		'total_Score' => 'int'
	];

	protected $fillable = [
		'reg_number',
		'candidate_name',
		'state_id',
		'lga_id',
		'gender',
		'age',
		'eng_score',
		'subj_2',
		'subj_2_Score',
		'subj_3',
		'subj_3_Score',
		'subj_4',
		'subj_4_Score',
		'total_Score',
		'faculty_id',
		'programme_id'
	];
}

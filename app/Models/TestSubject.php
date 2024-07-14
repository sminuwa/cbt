<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestSubject
 *
 * @property int $id
 * @property int $test_id
 * @property int $subject_id
 * @property string|null $title
 * @property string|null $instruction
 * @property float|null $total_mark
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Subject $subject
 * @property TestConfig $test_config
 * @property Collection|TestSection[] $test_sections
 *
 * @package App\Models
 */
class TestSubject extends Model
{
	protected $table = 'test_subjects';

	protected $casts = [
		'test_config_id' => 'int',
		'subject_id' => 'int',
		'total_mark' => 'float'
	];

	protected $fillable = [
		'title',
		'instruction',
		'total_mark'
	];

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}

	public function test_config()
	{
		return $this->belongsTo(TestConfig::class, 'test_config_id');
	}

	public function test_sections()
	{
		return $this->hasMany(TestSection::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestQuestion
 *
 * @property int $id
 * @property int $test_section_id
 * @property int $question_bank_id
 * @property int $version
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property QuestionBank $question_bank
 * @property TestSection $test_section
 *
 * @package App\Models
 */
class TestQuestion extends Model
{
	protected $table = 'test_questions';

	protected $casts = [
		'test_section_id' => 'int',
		'question_bank_id' => 'int',
		'version' => 'int'
	];
    protected $guarded = [];

	public function question_bank()
	{
		return $this->belongsTo(QuestionBank::class);
	}

	public function test_section()
	{
		return $this->belongsTo(TestSection::class);
	}
}

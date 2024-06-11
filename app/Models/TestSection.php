<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestSection
 *
 * @property int $id
 * @property int $test_subject_id
 * @property string|null $title
 * @property string|null $instruction
 * @property float|null $mark_per_question
 * @property int|null $num_to_answer
 * @property int|null $num_of_easy
 * @property int|null $num_of_moderate
 * @property int|null $num_of_difficult
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property TestSubject $test_subject
 * @property Collection|TestQuestion[] $test_questions
 *
 * @package App\Models
 */
class TestSection extends Model
{
    protected $table = 'test_sections';

    protected $casts = [
        'test_subject_id' => 'int',
        'mark_per_question' => 'float',
        'num_to_answer' => 'int',
        'num_of_easy' => 'int',
        'num_of_moderate' => 'int',
        'num_of_difficult' => 'int'
    ];

    protected $fillable = [
        'title',
        'instruction',
        'mark_per_question',
        'num_to_answer',
        'num_of_easy',
        'num_of_moderate',
        'num_of_difficult'
    ];

    public function test_subject()
    {
        return $this->belongsTo(TestSubject::class);
    }

    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class);
    }
}

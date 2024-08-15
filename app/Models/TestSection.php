<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

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

    protected $guarded = [];

    public function test_subject()
    {
        return $this->belongsTo(TestSubject::class)->with('subject');
    }

    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class);
    }

    public function scopeExclude($query, $value = []) 
    {
        return $query->select(array_diff($this->columns, (array) $value));
    }
    
    public function scopeForSubjects($query, $subject_id, $test_id){
        $query = $query
            ->join('test_subjects', function(JoinClause $joinTQ){
                return $joinTQ->on('test_subjects.id', '=', 'test_sections.test_subject_id');
            })
            ->where('test_subjects.subject_id', $subject_id)
            ->where('test_subjects.test_config_id', $test_id)
            ->select('test_sections.*');
        return $query;
    }
}

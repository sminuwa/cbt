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
 * Class ScheduledCandidate
 *
 * @property int $candidate_id
 * @property int|null $candidate_type_id
 * @property string $reg_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property ExamType|null $exam_type
 * @property Collection|CandidateStudent[] $candidate_students
 * @property Collection|Endorsement[] $endorsements
 * @property Collection|FeedBack[] $feed_back
 * @property Collection|TimeControl[] $time_controls
 *
 * @package App\Models
 */
class ScheduledCandidate extends Model
{
    protected $table = 'scheduled_candidates';
    protected $primaryKey = 'id';

    protected $casts = [
        'candidate_type_id' => 'int'
    ];

    protected $fillable = [
        'id',
        'candidate_type_id',
        'reg_number'
    ];

    public function exam_type()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id');
    }

    public function candidate_students()
    {
        return $this->hasMany(CandidateSubject::class, 'scheduled_candidate_id');
    }

    public function endorsements()
    {
        return $this->hasMany(Endorsement::class, 'scheduled_candidate_id');
    }

    public function feed_back()
    {
        return $this->hasMany(FeedBack::class, 'scheduled_candidate_id');
    }

    public function time_controls()
    {
        return $this->hasMany(TimeControl::class, 'scheduled_candidate_id');
    }


    public function scopeForCandidate($query,$schedule_id, $candidate_id = null){
        if(is_null($candidate_id))
            $candidate_id = auth()->id();
        return $query->where('scheduled_candidates.candidate_id',$candidate_id)
            ->join('candidates', function(JoinClause $joinCandidate){
                return $joinCandidate->on('candidates.id', '=','scheduled_candidates.candidate_id');
            })->join('candidate_subjects',function(JoinClause $joinCS){
                return $joinCS->on('candidate_subjects.scheduled_candidate_id','=','scheduled_candidates.id');
            })->join('schedulings',function(JoinClause $joinSchedule){
                return $joinSchedule->on('schedulings.id','=','candidate_subjects.schedule_id');
            })->join('subjects',function(JoinClause $joinSubject){
                return $joinSubject->on('subjects.id','=','candidate_subjects.subject_id');
            })->join('exam_types', function(JoinClause $joinType){
                return $joinType->on('exam_types.id', 'scheduled_candidates.exam_type_id');
            })
            ->where('candidate_subjects.schedule_id',$schedule_id)
            ->select(
                'scheduled_candidates.id',
                'scheduled_candidates.candidate_id',
                'candidate_subjects.schedule_id',
                'candidate_subjects.subject_id',
                'subjects.name',
                'exam_types.name as exam_type',

            );
    }

    public static function check_completion($test_config_id,$candidate_id = null){
        if(is_null($candidate_id))
            $candidate_id = auth()->id();
//        $completion = self::join('')
    }
}

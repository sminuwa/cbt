<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
    protected $primaryKey = 'candidate_id';

    protected $casts = [
        'candidate_type_id' => 'int'
    ];

    protected $fillable = [
        'candidate_type_id',
        'reg_number'
    ];

    public function exam_type()
    {
        return $this->belongsTo(ExamType::class, 'candidate_type_id');
    }

    public function candidate_students()
    {
        return $this->hasMany(CandidateStudent::class, 'candidate_id');
    }

    public function endorsements()
    {
        return $this->hasMany(Endorsement::class, 'candidate_id');
    }

    public function feed_back()
    {
        return $this->hasMany(FeedBack::class, 'candidate_id');
    }

    public function time_controls()
    {
        return $this->hasMany(TimeControl::class, 'candidate_id');
    }
}

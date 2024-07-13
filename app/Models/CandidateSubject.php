<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CandidateStudent
 *
 * @property int $id
 * @property int $schedule_id
 * @property int $candidate_id
 * @property int $subject_id
 * @property int|null $add_index
 * @property bool $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property ScheduledCandidate $scheduled_candidate
 * @property Scheduling $scheduling
 * @property Subject $subject
 *
 * @package App\Models
 */
class CandidateSubject extends Model
{
    protected $table = 'candidate_subjects';

    protected $casts = [
        'schedule_id' => 'int',
        'scheduled_candidate_id' => 'int',
        'subject_id' => 'int',
        'add_index' => 'int',
        'enabled' => 'bool'
    ];

    protected $fillable = [
        'add_index',
        'enabled'
    ];

    public function scheduled_candidate()
    {
        return $this->belongsTo(ScheduledCandidate::class, 'candidate_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function scheduling()
    {
        return $this->belongsTo(Scheduling::class, 'schedule_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

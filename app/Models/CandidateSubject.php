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

    protected $guarded = [];

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

    public function has_required_questions($test){
        $sections = TestSection::forSubjects($this->subject_id, $test->id)->with('test_subject','test_questions')->get();
    
        if(count($sections) < 1)
            return "Some papers does not have any section. Please contact administrators.";
        foreach($sections as $key => $section){
            $total_questions = count($section->test_questions);
            if($total_questions != $section->num_to_answer)
                return $section->title.": Questions not compose for this section. Please contact administrators.";
        }
        return true;
    }
}

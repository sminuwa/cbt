<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Scheduling
 *
 * @property int $id
 * @property int|null $test_id
 * @property int|null $venue_id
 * @property Carbon|null $date
 * @property int $maximum_batch
 * @property int|null $no_per_schedule
 * @property Carbon|null $daily_start_time
 * @property Carbon|null $daily_end_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property TestConfig|null $test_config
 * @property Venue|null $venue
 * @property Collection|CandidateSubject[] $candidate_students
 * @property ExamsDateFacultyMapping $exams_date_faculty_mapping
 * @property ExamsDateProgrammeMapping $exams_date_programme_mapping
 * @property ExamsDateStateMapping $exams_date_state_mapping
 * @property FacultyScheduleMapping $faculty_schedule_mapping
 * @property Collection|TestInvigilator[] $test_invigilators
 *
 * @package App\Models
 */
class Scheduling extends Model
{
    protected $table = 'schedulings';

    // protected $casts = [
    //     'test_config_id' => 'int',
    //     'venue_id' => 'int',
    //     'date' => 'datetime',
    //     'maximum_batch' => 'int',
    //     'no_per_schedule' => 'int',
    //     'daily_start_time' => 'datetime',
    //     'daily_end_time' => 'datetime'
    // ];

	protected $guarded = [];
    public function test_config()
    {
        return $this->belongsTo(TestConfig::class, 'test_config_id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function candidate_students()
    {
        return $this->hasMany(CandidateSubject::class, 'schedule_id');
    }

    public function exams_date_faculty_mapping()
    {
        return $this->hasOne(ExamsDateFacultyMapping::class);
    }

    public function exams_date_programme_mapping()
    {
        return $this->hasOne(ExamsDateProgrammeMapping::class);
    }

    public function exams_date_state_mapping()
    {
        return $this->hasOne(ExamsDateStateMapping::class);
    }

    public function faculty_schedule_mapping()
    {
        return $this->hasOne(FacultyScheduleMapping::class);
    }

    public function test_invigilators()
    {
        return $this->hasMany(TestInvigilator::class);
    }
}

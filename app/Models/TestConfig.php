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
 * Class TestConfig
 *
 * @property int $id
 * @property string $test_category
 * @property float $total_mark
 * @property int|null $test_code_id
 * @property int|null $test_type_id
 * @property int $session
 * @property int|null $semester
 * @property Carbon|null $daily_start_time
 * @property Carbon|null $daily_end_time
 * @property int|null $duration
 * @property string|null $starting_mode
 * @property string|null $display_mode
 * @property string|null $question_administration
 * @property string|null $option_administration
 * @property int $versions
 * @property int|null $active_version
 * @property int $initiated_by
 * @property Carbon $date_initiated
 * @property bool $status
 * @property string $endorsement
 * @property string $pass_key
 * @property int $time_padding
 * @property bool $allow_calc
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property TestCode|null $test_code
 * @property TestType|null $test_type
 * @property User $user
 * @property Collection|Endorsement[] $endorsements
 * @property Collection|ExamsDate[] $exams_dates
 * @property Collection|FeedBack[] $feed_back
 * @property Collection|Scheduling[] $schedulings
 * @property Collection|TestCompositor[] $test_compositors
 * @property Collection|TestInvigilator[] $test_invigilators
 * @property Collection|TestSubject[] $test_subjects
 * @property Collection|TimeControl[] $time_controls
 *
 * @package App\Models
 */
class TestConfig extends Model
{
    protected $table = 'test_configs';

    protected $casts = ['id',
        'total_mark' => 'float',
        'test_code_id' => 'int',
        'test_type_id' => 'int',
        'session' => 'int',
        'semester' => 'int',
        'daily_start_time' => 'datetime',
        'daily_end_time' => 'datetime',
        'duration' => 'int',
        'versions' => 'int',
        'active_version' => 'int',
        'initiated_by' => 'int',
        'date_initiated' => 'datetime',
        'status' => 'bool',
        'time_padding' => 'int',
        'allow_calc' => 'bool'
    ];

    protected $fillable = [
        'test_category',
        'total_mark',
        'test_code_id',
        'test_type_id',
        'session',
        'semester',
        'daily_start_time',
        'daily_end_time',
        'duration',
        'starting_mode',
        'display_mode',
        'question_administration',
        'option_administration',
        'versions',
        'active_version',
        'initiated_by',
        'date_initiated',
        'status',
        'endorsement',
        'pass_key',
        'time_padding',
        'allow_calc'
    ];

    public function test_code()
    {
        return $this->belongsTo(TestCode::class);
    }

    public function test_type()
    {
        return $this->belongsTo(TestType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function endorsements()
    {
        return $this->hasMany(Endorsement::class, 'test_config_id');
    }

    public function exams_dates()
    {
        return $this->hasMany(ExamsDate::class, 'test_config_id');
    }

    public function feed_back()
    {
        return $this->hasMany(FeedBack::class, 'test_config_id');
    }

    public function schedulings()
    {
        return $this->hasMany(Scheduling::class, 'test_config_id');
    }

    public function test_compositors()
    {
        return $this->hasMany(TestCompositor::class, 'test_config_id');
    }

    public function test_invigilators()
    {
        return $this->hasMany(TestInvigilator::class, 'test_config_id');
    }

    public function test_subjects()
    {
        return $this->hasMany(TestSubject::class, 'test_config_id');
    }

    public function time_controls()
    {
        return $this->hasMany(TimeControl::class, 'test_config_id');
    }

    public function scopeExam($query){
        return $query->join('test_codes', function(JoinClause $join_code){
            return $join_code->on('test_configs.test_code_id', '=', 'test_codes.id');
        })->join('schedulings', function(JoinClause $join_scheduling){
            return $join_scheduling->on('test_configs.id', '=', 'schedulings.test_config_id')
                ->whereDate('schedulings.date',date('Y-m-d'))
                ->whereTime('schedulings.daily_start_time', '<=', date('H:i:s'))
                ->whereTime('schedulings.daily_end_time', '>=', date('H:i:s'));
        })->join('test_types', function(JoinClause $join_type){
            return $join_type->on('test_configs.test_type_id', '=', 'test_types.id');
        })->where('test_configs.status', 1)
            ->select(
            'test_configs.*',
            'test_codes.name as code',
            'test_types.name as type',
            'schedulings.id as schedule_id',
        );
    }

}

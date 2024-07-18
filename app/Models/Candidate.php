<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Candidate extends Authenticatable
{
//    use  HasFactory, Notifiable;
    use HasFactory;

    protected $guarded = [];

    public function scheduledCandidates()
    {
        return $this->hasMany(ScheduledCandidate::class);
    }

    public function fullname(){
        return ($this->surname ?? null).' '.($this->firstname ?? null). ' '.($this->other_name ?? null);
    }

    public function passport(){

    }
    public function exam_type(){

    }

    public function schedules($test_id){
        return ScheduledCandidate::where(['candidate_id'=>$this->id])
            ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', 'scheduled_candidates.id')
            ->join('schedulings', 'schedulings.id', 'candidate_subjects.schedule_id')
            ->join('test_configs','test_configs.id', 'schedulings.test_config_id')
            ->where('test_configs.id', $test_id)
            ->select('scheduled_candidates.*')
            ->with('exam_type')
            ->first();
    }

    public function test_is_completed($test_config_id, $scheduled_candidate_id){
        $control = TimeControl::where(['test_config_id'=>$test_config_id,'scheduled_candidate_id'=>$scheduled_candidate_id])->first();
        if(!$control)
            return false;
        if($control->completed == 1)
            return true;
        return false;
    }

    public function has_time_control($test_config_id, $scheduled_candidate_id){
        $control = TimeControl::where(['test_config_id'=>$test_config_id,'scheduled_candidate_id'=>$scheduled_candidate_id])->first();
        if($control)
            return $control;
        return false;
    }

    public function presentation($test_config_id,$scheduled_candidate_id){
        return Presentation::where(['test_config_id'=>$test_config_id, 'scheduled_candidate_id'=>$scheduled_candidate_id])
            ->get();

    }

    public function loginTask(){


    }




}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Query\JoinClause;

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
        return ($this->surname ?? '').' '.($this->firstname ?? ''). ' '.($this->other_names ?? '');
    }


    public function indexing_to_image_name(){
        return str_replace('/', '_', $this->indexing);
    }

    // public function passport(){
    //     $path = candidate_passport_path().'/'.$this->indexing_to_image_name().'.jpg';
    //     if(File::exists($path))
    //         return asset($path);
    //     return tempPassport();
        
    // }

    public function passport($return_path = false){
        $path = candidate_passport_path().'/'.$this->indexing_to_image_name().'.jpg';
        if (!$return_path){
            if(File::exists($path))
                return asset($path);
            return tempPassport();
        }else{
            if(File::exists($path))
                return $path;
            return 'commons/images/user.jpg';
        }
    }

    public static function candidateWithoutPassport($year){
        if(is_null($year))
            $year = date('Y');
        $candidates = self::where(['exam_year'=>$year])->get();
        $count = [];
        $total = 0;
        foreach($candidates as $candidate){
            $path = candidate_passport_path().'/'.str_replace('/', '_', $candidate->indexing).'.jpg';
            if(file_exists($path)) {
                continue;
            }else{
                $count[] = $candidate->indexing;
                $total++;
            }
        }
        return ['total'=>$total, 'candidate_ids'=>$count];
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


    public function papers(){
        return 'P1,P2';
    }


    public function scopeManage($query, $test_config_id){
        return $query->join('scheduled_candidates', function(joinClause $schedule){
            return $schedule->on('scheduled_candidates.candidate_id', '=', 'candidates.id');
        })->join('candidate_subjects', function(joinClause $subject) use ($test_config_id) {
            return $subject->on('candidate_subjects.scheduled_candidate_id', '=', 'scheduled_candidates.id');
        })->join('schedulings', function(joinClause $scheduling){
            return $scheduling->on('schedulings.id', '=', 'candidate_subjects.schedule_id');
        })->join('test_configs', function(joinClause $config){
            return $config->on('test_configs.id', '=', 'schedulings.test_config_id');
        })->where('schedulings.test_config_id', '=', $test_config_id)
        ->selectRaw("
            candidates.*,
            test_configs.duration,
            scheduled_candidates.id as scheduled_candidate_id,
            (SELECT id 
            FROM time_controls
            WHERE time_controls.scheduled_candidate_id = scheduled_candidates.id 
            AND time_controls.test_config_id = schedulings.test_config_id
            ) as time_control_id,
            (SELECT completed 
            FROM time_controls
            WHERE time_controls.scheduled_candidate_id = scheduled_candidates.id 
            AND time_controls.test_config_id = schedulings.test_config_id
            ) as completed,
            (SELECT elapsed 
            FROM time_controls
            WHERE time_controls.scheduled_candidate_id = scheduled_candidates.id 
            AND time_controls.test_config_id = schedulings.test_config_id
            ) as elapsed,
            (SELECT ip
            FROM time_controls
            WHERE time_controls.scheduled_candidate_id = scheduled_candidates.id 
            AND time_controls.test_config_id = schedulings.test_config_id
            ) as address,
            (SELECT GROUP_CONCAT(s.subject_code)
                FROM candidate_subjects cs
                JOIN subjects s ON s.id = cs.subject_id 
                WHERE cs.scheduled_candidate_id = scheduled_candidates.id
            ) as papers
        ")
        ->groupBy('candidate_subjects.scheduled_candidate_id');
    }


    public static function general_statistics($year, $test_code_id, $test_type_id){
        return Candidate::selectRaw("
                COUNT(candidates.id) AS total_candidates,

                -- Total count of candidates with below 50 in each subject/assessment
                SUM(CASE WHEN subjects.subject_code = 'P1' AND scores.point_scored < 50 THEN 1 ELSE 0 END) AS P1_below_50_count,
                SUM(CASE WHEN subjects.subject_code = 'P2' AND scores.point_scored < 50 THEN 1 ELSE 0 END) AS P2_below_50_count,
                SUM(CASE WHEN subjects.subject_code = 'P3' AND scores.point_scored < 50 THEN 1 ELSE 0 END) AS P3_below_50_count,
                SUM(CASE WHEN (SELECT SUM(pe.score) FROM practical_examinations pe WHERE pe.candidate_id = candidates.id) < 50 THEN 1 ELSE 0 END) AS PE_below_50_count,
                SUM(CASE WHEN (SELECT SUM(pa.score) FROM project_assessments pa WHERE pa.candidate_id = candidates.id) < 50 THEN 1 ELSE 0 END) AS PA_below_50_count,

                -- Total count of candidates with above 50 in each subject/assessment
                SUM(CASE WHEN subjects.subject_code = 'P1' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) AS P1_above_50_count,
                SUM(CASE WHEN subjects.subject_code = 'P2' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) AS P2_above_50_count,
                SUM(CASE WHEN subjects.subject_code = 'P3' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) AS P3_above_50_count,
                SUM(CASE WHEN (SELECT SUM(pe.score) FROM practical_examinations pe WHERE pe.candidate_id = candidates.id) >= 50 THEN 1 ELSE 0 END) AS PE_above_50_count,
                SUM(CASE WHEN (SELECT SUM(pa.score) FROM project_assessments pa WHERE pa.candidate_id = candidates.id) >= 50 THEN 1 ELSE 0 END) AS PA_above_50_count,

                -- Percentage calculations
                (SUM(CASE WHEN subjects.subject_code = 'P1' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS P1_above_50_percentage,
                (SUM(CASE WHEN subjects.subject_code = 'P2' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS P2_above_50_percentage,
                (SUM(CASE WHEN subjects.subject_code = 'P3' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS P3_above_50_percentage,
                (SUM(CASE WHEN (SELECT SUM(pe.score) FROM practical_examinations pe WHERE pe.candidate_id = candidates.id) >= 50 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS PE_above_50_percentage,
                (SUM(CASE WHEN (SELECT SUM(pa.score) FROM project_assessments pa WHERE pa.candidate_id = candidates.id) >= 50 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS PA_above_50_percentage
            ")
            ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', '=', 'candidates.id')
            ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', '=', 'scheduled_candidates.id')
            ->join('schedulings', 'schedulings.id', '=', 'scheduled_candidates.schedule_id')
            ->join('test_configs', 'test_configs.id', '=', 'schedulings.test_config_id')
            ->join('venues', 'venues.id', '=', 'schedulings.venue_id')
            ->join('centres', 'centres.id', '=', 'venues.centre_id')
            ->leftJoin('scores', 'scores.scheduled_candidate_id', '=', 'scheduled_candidates.id')
            ->leftJoin('subjects', 'subjects.id', '=', 'candidate_subjects.subject_id')
            ->where([
                'candidates.exam_year' => $year,
                'test_configs.test_code_id' => $test_code_id,
                'test_configs.test_type_id' => $test_type_id,
            ])
            ->first();
    }
   

}

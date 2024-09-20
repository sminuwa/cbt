<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $scheduled_candidate_id scheduled candidate id
@property bigint $paper_id paper id
@property int $score score
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class ProjectAssessment extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'project_assessments';

    /**
    * Mass assignable columns
    */
    protected $fillable=['scheduled_candidate_id',
'paper_id',
'score'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
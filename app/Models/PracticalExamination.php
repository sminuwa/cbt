<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $scheduled_candidate_id scheduled candidate id
@property bigint $candidate_id candidate id
@property bigint $practical_question_id practical question id
@property decimal $score score
@property bigint $examiner examiner
@property timestamp $created_at created at
@property timestamp $update_at update at
   
 */
class PracticalExamination extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'practical_examinations';

    /**
    * Mass assignable columns
    */
    protected $fillable=['update_at',
'scheduled_candidate_id',
'candidate_id',
'practical_question_id',
'score',
'examiner',
'update_at'];

    /**
    * Date time columns.
    */
    protected $dates=['update_at'];




}
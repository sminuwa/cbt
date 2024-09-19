<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $scheduled_candidate_id scheduled candidate id
@property bigint $paper_id paper id
@property int $sign_in sign in
@property int $sign_out sign out
@property varchar $remark remark
@property int $year year
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Attendance extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'attendances';

    /**
    * Mass assignable columns
    */
    protected $fillable=['scheduled_candidate_id',
'paper_id',
'sign_in',
'sign_out',
'remark',
'year'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
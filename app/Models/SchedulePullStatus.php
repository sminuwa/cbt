<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $schedule_id schedule id
@property int $total_candidate total candidate
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class SchedulePullStatus extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'schedule_pull_statuses';

    /**
    * Mass assignable columns
    */
    protected $fillable=['schedule_id',
'total_candidate'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
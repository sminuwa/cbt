<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint $section_id section id
@property varchar $name name
@property int $mark mark
@property int $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class PracticalQuestion extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'practical_questions';

    /**
    * Mass assignable columns
    */
    protected $fillable=['section_id',
'name',
'mark',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
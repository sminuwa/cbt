<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property int $status status
@property timestamp $created created
@property timestamp $updated updated
   
 */
class PracticalSection extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'practical_sections';

    /**
    * Mass assignable columns
    */
    protected $fillable=['updated',
'name',
'status',
'created',
'updated'];

    /**
    * Date time columns.
    */
    protected $dates=['created',
'updated'];


public function questions(){
    return $this->hasMany(PracticalQuestion::class,'section_id');
}


}
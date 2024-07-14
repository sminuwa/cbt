<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminCentre extends Model
{
    use HasFactory;
    protected $fillable = ['id','name', 'location', 'api_key', 'secret_key', 'status', 'created_at', 'updated_at'];
}

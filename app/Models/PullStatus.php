<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PullStatus extends Model
{
    use HasFactory;
    protected $fillable = ['resource', 'pull_date', 'status', 'message'];
}

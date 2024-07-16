<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function answerOption()
    {
        return $this->belongsTo(AnswerOption::class);
    }

    public function questionBank()
    {
        return $this->belongsTo(QuestionBank::class);
    }

    public function scheduledCandidate()
    {
        return $this->belongsTo(ScheduledCandidate::class);
    }
}

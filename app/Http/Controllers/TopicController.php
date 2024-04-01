<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function topicBy($subject_id)
    {
        $topics = Topic::where(['subject_id' => $subject_id])->get();

        return view('pages.admin.questions.ajax.topics', compact('topics'));
    }
}

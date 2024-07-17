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

    public function storeTopic(Request $request)
    {
        try {
            $name = $request->name;
            $subject = $request->subject_id;

            if (!isset($subject)) {
                return ['success' => false, 'message' => 'Please select PAPER to continue'];
            }

            $topic = Topic::where(['name' => $name, 'subject_id' => $subject])->first();
            if (isset($topic))
                return ['success' => false, 'message' => 'Subject already exists'];

            $topic = new Topic();
            $topic->name = $name;
            $topic->subject_id = $subject;
            if ($topic->save())
                return ['success' => true];

            return ['success' => false, 'message' => 'Something went wrong'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

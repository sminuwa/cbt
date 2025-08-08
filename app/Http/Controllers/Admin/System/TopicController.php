<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Subject;
use Illuminate\Http\Request;
use Exception;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::with('subject')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        return view('pages.admin.toolbox.manage_topics', compact('topics', 'subjects'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'subject_id' => 'required|exists:subjects,id'
            ]);

            // Check for duplicates
            $existing = Topic::where('name', $request->name)
                           ->where('subject_id', $request->subject_id)
                           ->where('id', '!=', $request->id)
                           ->first();
            
            if ($existing) {
                return back()->with('error', 'Topic already exists for this subject.');
            }

            if ($request->id) {
                // Update existing
                $topic = Topic::findOrFail($request->id);
                $topic->update([
                    'name' => $request->name,
                    'subject_id' => $request->subject_id
                ]);
                $message = 'Topic updated successfully';
            } else {
                // Create new
                Topic::create([
                    'name' => $request->name,
                    'subject_id' => $request->subject_id
                ]);
                $message = 'Topic created successfully';
            }

            return back()->with('success', $message);
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Topic $topic)
    {
        try {
            // Check if topic is being used
            if ($topic->question_banks()->count() > 0) {
                return back()->with('error', 'Cannot delete topic. It has questions associated with it.');
            }

            $topic->delete();
            return back()->with('success', 'Topic deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

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

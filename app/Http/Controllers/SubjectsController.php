<?php

namespace App\Http\Controllers;

use App\Models\ExamType;
use App\Models\Subject;
use App\Models\Venue;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $examsTypes = ExamType::all();
        $subjects = Subject::all();
        return view('pages.toolbox.manage_subject', compact('examsTypes', 'subjects'));
    }

    public function create(Request $request)
    {
        //$examsTypes = ExamType::all();
//        return $request;
        try {
            if (isset($request->id))
                $subject = Subject::find($request->id);
            else
                $subject = new Subject();
            $subject->exam_type_id = $request->etype;
            $subject->name = $request->sname;
            $subject->subject_code = $request->scode;
            if ($subject->save())
                return back()->with(['success' => 'Subject saved successfully.']);

            return back()->with(['error' => 'Oops! Looks like something went wrong.']);
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }

    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->json(['success' => 'Subject deleted successfully.']);
    }
}

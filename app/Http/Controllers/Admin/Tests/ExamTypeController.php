<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Controller;
use App\Models\ExamType;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;

class ExamTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    //
    public function index()
    {
        $candidateTypes = ExamType::all();
        return view('pages.admin.toolbox.candidate_type', compact('candidateTypes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'etype' => 'required|string|max:255',
        ]);

        try {
            if (isset($request->id))
                $examtype = ExamType::find($request->id);
            else
                $examtype = new ExamType();
            $examtype->name = $request->etype;
            if ($examtype->save())
                return back()->with(['success' => 'Exam Type saved successfully.']);

            return back()->with(['error' => 'Oops! Looks like something went wrong.']);
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(ExamType $examType)
    {
        $examType->delete();
        return response()->json(['success' => 'Exam Type deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ExamType;
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
        return view('pages.toolbox.candidate_type', compact('candidateTypes'));
    }

    public function create()
    {
        return view('candidate_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidatetypename' => 'required|string|max:255',
        ]);

        ExamType::create([
            'name' => $request->input('candidatetypename'),
        ]);

        return redirect()->route('candidateTypes.index')->with('success', 'Saved successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Imports\CandidatesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Maatwebsite\Excel;
use Maatwebsite\Excel\Excel;

//use Vtiful\Kernel\Excel;

class CandidateUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('pages.toolbox.candidate_upload');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            Excel::import(new CandidatesImport, $request->file('file'));

            return back()->with('success', 'File uploaded and processed successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

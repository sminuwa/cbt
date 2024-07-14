<?php

namespace App\Http\Controllers;

use App\Imports\CandidatesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//use Maatwebsite\Excel;

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

public function imageIndex()
{
    return view('pages.toolbox.candidate_image_upload');
}

    public function imageUpload(Request $request)
    {
        // Adjust memory limit and execution time if needed
        // ini_set("memory_limit", "256M");
        // ini_set('max_execution_time', 300);

        $request->validate([
            'files.*' => 'required|file|mimes:jpg|max:2048', // Validate file types and size
        ]);

        $path = public_path('candidate_pics'); // Define your upload directory
        $successMessage = '';

        foreach ($request->file('files') as $file) {
            $fileName = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();

            if ($file->isValid() && in_array($fileExtension, ['jpg', 'png'])) {
                $file->move($path, $fileName); // Move uploaded file to specified directory

                $successMessage .= "Image '$fileName' uploaded successfully!<br>";
            } else {
                $successMessage .= "Error uploading '$fileName': Invalid format or something went wrong.<br>";
            }
        }

        return back()->with('success', "Images uploaded successfully!");
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

<?php

namespace App\Http\Controllers;

use App\Imports\CandidatesImport;
use App\Models\Candidate;
use App\Models\ExamType;
use App\Models\TestConfig;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // $request->validate([
        //     'files.*' => 'required|file|mimes:jpg|max:2048', // Validate file types and size
        // ]);
        
        $path = public_path(candidate_passport_path()); // Define your upload directory
        $successMessage = '';
        // return $path;
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
    public function invigilator()
    {

        $candidateTypes = ExamType::all();
        $testConfigs = TestConfig::exam()->get();

        $candidateTypes = DB::table('exam_types')->get();
        $examTypes = DB::table('test_configs')
            ->join('test_codes', 'test_configs.test_code_id', '=', 'test_codes.id')
            ->join('test_types', 'test_configs.test_type_id', '=', 'test_types.id')
            ->join('exams_dates', 'exams_dates.test_config_id', '=', 'test_configs.id')
            ->where('exams_dates.date', '=', now()->format('Y-m-d'))
            ->select('test_configs.id', 'test_codes.name', 'test_types.name', 'session', 'semester')
            ->get();
        return view('pages.toolbox.invigilator_panel',compact('testConfigs','examTypes','candidateTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function viewCandidateTime(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function saveTimeAdjustment(Request $request)
    {
        $timespent = $request->input('timespent') * 60;
        $candid = $request->input('candid');
        $examtype = $request->input('examtyp');

        $starttime = DB::table('time_controls')
            ->where('candidate_id', $candid)
            ->where('test_config_id', $examtype)
            ->value('start_time');

        $stimedt = new DateTime("2014-01-01 " . $starttime);
        $ctime = $stimedt->add(new DateInterval("PT" . $timespent . "S"));

        $updated = DB::table('time_controls')
            ->where('candidate_id', $candid)
            ->where('test_config_id', $examtype)
            ->update(['curent_time' => $ctime->format("H:i:s"), 'elapsed' => $timespent]);

        return $updated ? response()->json(1) : response()->json(0);
    }

    public function resetCandidatePassword(Request $request)
    {
        //return $request;
        $this->validate($request, [
            "index_number" => "required",
            "npassword" => "required|min:3|confirmed"
        ]);
        $candidate = Candidate::where(['indexing' => $request->index_number])->first();
        if ($candidate) {
            $candidate->password = bcrypt($request->password);
            $candidate->save();
            return back()->with("Password Reset for {{$request->username}} to {{$request->password}}");
        }
        return back()->with("Invalid UserName");

    }

    public function loadProfile(Request $request)
    {

        $examtype = $request->input('examtype');
        $username = $request->input('username');

        $studentInfo = DB::table('candidates')
            ->leftJoin('scheduled_candidates', 'candidates.indexing', '=', 'scheduled_candidates.candidate_id')
            ->leftJoin('candidate_subjects', 'scheduled_candidates.candidate_id', '=', 'candidate_subjects.scheduled_candidate_id')
            ->leftJoin('schedulings', 'candidate_subjects.schedule_id', '=', 'schedulings.id')
            ->leftJoin('venues', 'schedulings.venue_id', '=', 'venues.id')
            ->leftJoin('centres', 'venues.centre_id', '=', 'centres.id')
            ->where('candidates.indexing', $username)
            ->select(
                'candidates.indexing',
                'candidates.surname',
                'candidates.firstname',
                'candidates.other_names',
                'venues.name as venue_name',
                'centres.name as centre_name'
            )
            ->first();

        if ($studentInfo) {
            $indexing=$studentInfo->indexing;
            $candName = $studentInfo->surname . " " . $studentInfo->firstname . " " . $studentInfo->other_names;
            $venueName = $studentInfo->venue_name;
            $centreName = $studentInfo->centre_name;

            return response()->json([
                'indexing'=>$indexing,
                'candName' => $candName,
                'venueName' => $venueName,
                'centreName' => $centreName,
            ]);
        }

        return redirect()->back()->withErrors(['Candidate not found']);
    }

}

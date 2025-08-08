<?php

namespace App\Http\Controllers\Student\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\ExamType;
use App\Models\TestConfig;
use App\Models\TimeControl;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function restoreCandidate(Request $request)
    {
        $restore=TimeControl::find($request->id);
        $restore->ip = null;
        $restore->save();
        return response()->json(['status'=>true,'message' => 'IP address has been cleared successfully']);
    }
    
    public function endCandidateExam(Request $request)
    {
        $restore=TimeControl::find($request->id);
        $restore->completed = 1;
        $restore->save();
        return response()->json(['status'=>true,'message' => 'Exam ended']);
    }

    public function adjustCandidateTime(Request $request)
    {
        // return $request;
        $restore=TimeControl::find($request->id);
        if($restore){
            $restore->elapsed = $request->new_time * 60 ?? $restore->elapsed;
            $restore->save();
        }
        return response()->json(['status'=>true,'message' => 'Time adjusted successfully']);
        // return response()->json(['message' => 'Time Adjusted successfully']);
}

    public function resetPassword(Request $request){
        $id = $request->id;
        $password = $request->password;
        if(Candidate::where('id', $id)->update(['password'=>bcrypt($password)])){
            return response()->json(['status'=>true,'message' => 'Password reset successfully']);
        }
    }
}

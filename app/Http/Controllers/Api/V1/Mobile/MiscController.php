<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceRemark;

class MiscController extends Controller
{
    public function __construct()
    {
        // Apply the CentreGuard middleware globally to all methods in this controller
        $this->middleware('centre');
    }
    
    public function attendanceRemark(Request $request){
        try{
            $records = AttendanceRemark::orderBy('code','asc')->get(['id','code', 'description']);
            return jResponse(true, 'Successful', $records);
        }catch(\Exception $e){
            return jResponse(false, 'Failed', 'Something went wrong');
        }
    }
}

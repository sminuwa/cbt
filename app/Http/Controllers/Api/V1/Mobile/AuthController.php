<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function __construct()
    {
        // Apply the CentreGuard middleware globally to all methods in this controller
        $this->middleware('centre');
    }


    public function login(Request $request)
    {

    
        try {
            $this->validate($request, [
                "username" => "required",
                "password" => "required"
            ]);
            
//        if(!$check->canAccess('attendance.mobile.login') || !$check->canAccess('attendance.desktop.login'))
//            return ['status'=>false,'message'=>'You are not allowed to access this portal.'];
            $credentials = ["api_key" => $request->username, "password" => $request->password];
            if (Auth::guard('centre')->attempt($credentials)) {
                // auth()->guard('centre')->user();
                // $request->user()->tokens()->delete();
                $token = $request->user()->createToken('mobile-app-access', ['server:mobile-app'])->plainTextToken;
                return jResponse(true, 'login successful', ['token' => $token]);
            }
            return ['status' => false, 'message' => 'Invalid credentials'];
        }catch (\Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}

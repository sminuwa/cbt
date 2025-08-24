<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Centre;
use App\Models\User as ModelsUser;
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
        $username = $request->username;
        $password = $request->password;
        $centre_user = Centre::where('api_key', $username)->first();
            // return $practitioner_record;
        if(!$centre_user)
            return back()->with('error', 'Invalid credentials')->withInput();
        if($password == $centre_user->password)
        Centre::where('id', $centre_user->id)->update(['password'=>bcrypt($centre_user->password)]);
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

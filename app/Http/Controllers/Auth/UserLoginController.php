<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('pages.auth.admin.login');
    }

    public function login(Request $request)
    {
//        return $request;
//        return bcrypt(123456);
        if($request->username == 'chprbn-staff')
            return back();
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function credentials(Request $request)
    {
        return ['username'=>$request->username,'password'=>$request->password];
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::guard('admin')->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

//        $this->clearLoginAttempts($request);

        return  redirect()->route("admin.dashboard.index");
    }

    protected function redirectPath(){
        return route("admin.dashboard.index");
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->route('admin.auth.login')
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => __('auth.failed'),
            ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.auth.login'));
    }
}

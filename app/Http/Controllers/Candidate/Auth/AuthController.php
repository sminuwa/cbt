<?php

namespace App\Http\Controllers\Candidate\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function index(){
        return view('pages.candidate.auth.login');
    }




}

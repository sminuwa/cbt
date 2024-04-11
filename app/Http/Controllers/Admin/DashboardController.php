<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    //
    public function index(Request $request)
    {
        $user = $request->user();
        return view('pages.admin.dashboard.index');
    }
}

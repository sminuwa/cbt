<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\TimeControl;

class DashboardController extends Controller
{

    public function __construct()
    {
        //
    }

    //
    public function index(Request $request)
    {
        $user = $request->user();
        $total_candidates = Candidate::count();
        $total_submitted = TimeControl::where('completed',1)->count();
        $total_in_progress = TimeControl::where('completed',0)->count();
        $total_pending = $total_candidates - ($total_submitted + $total_in_progress);
        return view('pages.admin.dashboard.index', compact('total_candidates', 'total_submitted','total_in_progress', 'total_pending'));
    }
}

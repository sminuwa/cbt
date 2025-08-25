<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\TimeControl;
use App\Models\TestConfig;
use App\Models\Subject;
use App\Models\CandidateSubject;
use App\Models\Score;
use App\Models\TestCode;
use App\Models\ScheduledCandidate;
use App\Models\Scheduling;
use App\Models\SchedulePullStatus;
use App\Models\SchedulePushStatus;
use App\Models\Attendance;
use App\Models\Centre;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;

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
        
        // System overview stats (fast queries for immediate display)
        $total_centres = Centre::count();
        $total_venues = Venue::count();
        $total_schedules = Scheduling::count();
        $total_attendances = Attendance::count();
        
        // Basic statistics (fast queries)
        $total_candidates = Candidate::count();
        $total_submitted = TimeControl::where('completed',1)->count();
        $total_in_progress = TimeControl::where('completed',0)->count();
        $total_pending = $total_candidates - ($total_submitted + $total_in_progress);
        
        // Recent activity stats (fast query)
        $recent_submissions = TimeControl::where('completed', 1)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        
        $active_tests = TestConfig::where('status', 1)->count();
        $total_tests = TestConfig::count();
        
        return view('pages.admin.dashboard.index', compact(
            'total_candidates', 
            'total_submitted',
            'total_in_progress', 
            'total_pending',
            'recent_submissions',
            'active_tests',
            'total_tests',
            'total_centres',
            'total_venues',
            'total_schedules',
            'total_attendances'
        ));
    }
}

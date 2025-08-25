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
        
        // 1. Total scheduled centres (schedules) per paper/test_codes
        $scheduled_centres_per_paper = DB::select("
            SELECT 
                tc.name as paper_name,
                tc.id as test_code_id,
                COUNT(DISTINCT s.id) as total_schedules,
                COUNT(DISTINCT s.venue_id) as unique_venues,
                COUNT(DISTINCT v.centre_id) as unique_centres
            FROM test_codes tc
            LEFT JOIN test_configs tcfg ON tcfg.test_code_id = tc.id
            LEFT JOIN schedulings s ON s.test_config_id = tcfg.id
            LEFT JOIN venues v ON v.id = s.venue_id
            GROUP BY tc.id, tc.name
            ORDER BY tc.name
        ");
        
        // 2. Total centres pulled (schedule_pull_statuses table)
        $centres_pulled_stats = DB::select("
            SELECT 
                tc.name as paper_name,
                COUNT(DISTINCT sps.schedule_id) as centres_pulled,
                SUM(sps.total_candidate) as total_candidates_pulled
            FROM test_codes tc
            LEFT JOIN test_configs tcfg ON tcfg.test_code_id = tc.id
            LEFT JOIN schedulings s ON s.test_config_id = tcfg.id
            LEFT JOIN schedule_pull_statuses sps ON sps.schedule_id = s.id
            WHERE sps.id IS NOT NULL
            GROUP BY tc.id, tc.name
            ORDER BY tc.name
        ");
        
        // 3. Total centres pushed (schedule_push_statuses table)
        $centres_pushed_stats = DB::select("
            SELECT 
                tc.name as paper_name,
                COUNT(DISTINCT spss.schedule_id) as centres_pushed,
                SUM(spss.total_candidate) as total_candidates_pushed
            FROM test_codes tc
            LEFT JOIN test_configs tcfg ON tcfg.test_code_id = tc.id
            LEFT JOIN schedulings s ON s.test_config_id = tcfg.id
            LEFT JOIN schedule_push_statuses spss ON spss.schedule_id = s.id
            WHERE spss.id IS NOT NULL
            GROUP BY tc.id, tc.name
            ORDER BY tc.name
        ");
        
        // 4. Total candidates attended a particular paper (based on time_controls scheduled_candidate_id)
        $candidates_attended_per_paper = DB::select("
            SELECT 
                tc.name as paper_name,
                COUNT(DISTINCT t.scheduled_candidate_id) as candidates_attended,
                COUNT(DISTINCT CASE WHEN t.completed = 1 THEN t.scheduled_candidate_id END) as candidates_completed
            FROM test_codes tc
            LEFT JOIN test_configs tcfg ON tcfg.test_code_id = tc.id
            LEFT JOIN time_controls t ON t.test_config_id = tcfg.id
            WHERE t.id IS NOT NULL
            GROUP BY tc.id, tc.name
            ORDER BY tc.name
        ");
        
        // 5. Total candidates attendances (attendances table) with attendance remark
        $attendance_stats = DB::select("
            SELECT 
                a.remark,
                COUNT(*) as count,
                ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM attendances)), 2) as percentage
            FROM attendances a
            GROUP BY a.remark
            ORDER BY count DESC
        ");
        
        // 6. Statistics on students performance per centre
        $centre_performance = DB::select("
            SELECT 
                c.name as centre_name,
                c.location as centre_location,
                COUNT(DISTINCT sc.candidate_id) as total_candidates,
                COUNT(DISTINCT CASE WHEN tc.completed = 1 THEN sc.candidate_id END) as completed_candidates,
                ROUND(AVG(s.point_scored), 2) as average_score,
                COUNT(s.id) as total_responses
            FROM centres c
            LEFT JOIN venues v ON v.centre_id = c.id
            LEFT JOIN schedulings sch ON sch.venue_id = v.id
            LEFT JOIN scheduled_candidates sc ON sc.schedule_id = sch.id
            LEFT JOIN time_controls tc ON tc.scheduled_candidate_id = sc.id
            LEFT JOIN scores s ON s.scheduled_candidate_id = sc.id
            GROUP BY c.id, c.name, c.location
            HAVING total_candidates > 0
            ORDER BY average_score DESC
        ");
        
        // 7. Additional useful statistics
        
        // Daily exam activity trend (last 5 days)
        $daily_activity = DB::select("
            SELECT 
                DATE(tc.created_at) as exam_date,
                COUNT(DISTINCT tc.scheduled_candidate_id) as candidates_started,
                COUNT(DISTINCT CASE WHEN tc.completed = 1 THEN tc.scheduled_candidate_id END) as candidates_completed
            FROM time_controls tc
            WHERE tc.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY)
            GROUP BY DATE(tc.created_at)
            ORDER BY exam_date ASC
        ");
        
        // Subject-wise performance statistics
        $subject_performance_detailed = DB::select("
            SELECT 
                sub.name as subject_name,
                sub.subject_code,
                COUNT(DISTINCT cs.scheduled_candidate_id) as enrolled_candidates,
                COUNT(s.id) as total_responses,
                ROUND(AVG(s.point_scored), 2) as average_score,
                COUNT(DISTINCT CASE WHEN s.point_scored >= 0.5 THEN cs.scheduled_candidate_id END) as passed_candidates
            FROM subjects sub
            LEFT JOIN candidate_subjects cs ON cs.subject_id = sub.id
            LEFT JOIN scores s ON s.scheduled_candidate_id = cs.scheduled_candidate_id
            LEFT JOIN question_banks qb ON qb.id = s.question_bank_id AND qb.subject_id = sub.id
            GROUP BY sub.id, sub.name, sub.subject_code
            HAVING enrolled_candidates > 0
            ORDER BY average_score DESC
        ");
        
        // Centre capacity utilization
        $centre_capacity_utilization = DB::select("
            SELECT 
                c.name as centre_name,
                SUM(v.capacity) as total_capacity,
                COUNT(DISTINCT sc.candidate_id) as scheduled_candidates,
                ROUND((COUNT(DISTINCT sc.candidate_id) * 100.0 / SUM(v.capacity)), 2) as utilization_percentage
            FROM centres c
            LEFT JOIN venues v ON v.centre_id = c.id
            LEFT JOIN schedulings sch ON sch.venue_id = v.id
            LEFT JOIN scheduled_candidates sc ON sc.schedule_id = sch.id
            GROUP BY c.id, c.name
            HAVING total_capacity > 0
            ORDER BY utilization_percentage DESC
        ");
        
        // System overview stats
        $total_centres = Centre::count();
        $total_venues = Venue::count();
        $total_schedules = Scheduling::count();
        $total_attendances = Attendance::count();
        $centres_with_pulls = SchedulePullStatus::distinct('schedule_id')->count();
        $centres_with_pushes = SchedulePushStatus::distinct('schedule_id')->count();
        
        // Basic statistics
        $total_candidates = Candidate::count();
        $total_submitted = TimeControl::where('completed',1)->count();
        $total_in_progress = TimeControl::where('completed',0)->count();
        $total_pending = $total_candidates - ($total_submitted + $total_in_progress);
        
        // Chart data for subjects performance
        $subjects = Subject::orderBy('subject_code')->get();
        $subject_performance = [];
        
        foreach($subjects as $subject) {
            $total_scores = Score::join('question_banks', 'scores.question_bank_id', '=', 'question_banks.id')
                ->where('question_banks.subject_id', $subject->id)
                ->count();
            
            $total_candidates_for_subject = CandidateSubject::where('subject_id', $subject->id)->count();
            
            $subject_performance[] = [
                'name' => $subject->subject_code,
                'candidates' => $total_candidates_for_subject,
                'responses' => $total_scores
            ];
        }
        
        // Test codes performance data
        $test_codes_performance = TestCode::select('test_codes.name')
            ->selectRaw('COUNT(DISTINCT candidates.id) as candidate_count')
            ->selectRaw('COUNT(DISTINCT scores.id) as total_responses')
            ->leftJoin('test_configs', 'test_configs.test_code_id', '=', 'test_codes.id')
            ->leftJoin('schedulings', 'schedulings.test_config_id', '=', 'test_configs.id')
            ->leftJoin('scheduled_candidates', 'scheduled_candidates.schedule_id', '=', 'schedulings.id')
            ->leftJoin('candidates', 'candidates.id', '=', 'scheduled_candidates.candidate_id')
            ->leftJoin('scores', 'scores.scheduled_candidate_id', '=', 'scheduled_candidates.id')
            ->groupBy('test_codes.id', 'test_codes.name')
            ->orderBy('test_codes.name')
            ->get();
        
        // Recent activity stats
        $recent_submissions = TimeControl::where('completed', 1)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        
        $active_tests = TestConfig::where('status', 1)->count();
        $total_tests = TestConfig::count();
        
        // Exam status distribution
        $exam_status = [
            'completed' => $total_submitted,
            'in_progress' => $total_in_progress,
            'not_started' => $total_pending
        ];
        
        // Top scorers per cadre/programme
        $top_scorers_by_cadre = DB::select("
            SELECT 
                tc.name as cadre_name,
                CONCAT(c.surname, ' ', c.firstname) as candidate_name,
                c.indexing,
                AVG(s.point_scored) as average_score,
                COUNT(s.id) as total_questions
            FROM test_codes tc
            LEFT JOIN test_configs tcfg ON tcfg.test_code_id = tc.id
            LEFT JOIN schedulings sch ON sch.test_config_id = tcfg.id
            LEFT JOIN scheduled_candidates sc ON sc.schedule_id = sch.id
            LEFT JOIN candidates c ON c.id = sc.candidate_id
            LEFT JOIN scores s ON s.scheduled_candidate_id = sc.id
            WHERE s.point_scored IS NOT NULL
            GROUP BY tc.id, tc.name, c.id, c.surname, c.firstname, c.indexing
            HAVING COUNT(s.id) > 0
            ORDER BY tc.name, average_score DESC
        ");
        
        // Group top scorers by cadre and get the highest scorer for each
        $cadre_top_scorers = [];
        $grouped_scorers = collect($top_scorers_by_cadre)->groupBy('cadre_name');
        
        foreach($grouped_scorers as $cadre => $scorers) {
            $top_scorer = $scorers->first(); // Get the highest scorer for this cadre
            if($top_scorer && $top_scorer->average_score > 0) {
                $cadre_top_scorers[] = [
                    'cadre' => $cadre,
                    'candidate_name' => $top_scorer->candidate_name,
                    'indexing' => $top_scorer->indexing,
                    'average_score' => round($top_scorer->average_score, 2),
                    'total_questions' => $top_scorer->total_questions,
                    'percentage' => round(($top_scorer->average_score / 1) * 100, 1) // Assuming 1 point per question
                ];
            }
        }
        
        return view('pages.admin.dashboard.index', compact(
            'total_candidates', 
            'total_submitted',
            'total_in_progress', 
            'total_pending',
            'subject_performance',
            'test_codes_performance', 
            'recent_submissions',
            'active_tests',
            'total_tests',
            'exam_status',
            'cadre_top_scorers',
            // New comprehensive statistics
            'scheduled_centres_per_paper',
            'centres_pulled_stats',
            'centres_pushed_stats',
            'candidates_attended_per_paper',
            'attendance_stats',
            'centre_performance',
            'daily_activity',
            'subject_performance_detailed',
            'centre_capacity_utilization',
            'total_centres',
            'total_venues',
            'total_schedules',
            'total_attendances',
            'centres_with_pulls',
            'centres_with_pushes'
        ));
    }
}

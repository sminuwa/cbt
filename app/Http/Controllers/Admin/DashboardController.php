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
            'cadre_top_scorers'
        ));
    }
}

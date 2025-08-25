<?php

namespace App\Http\Controllers\Api;

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
use Illuminate\Support\Facades\Cache;

class DashboardApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function scheduledCentresPerPaper()
    {
        try {
            $data = DB::select("
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

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function centresPullStats()
    {
        try {
            $data = DB::select("
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

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function centresPushStats()
    {
        try {
            $data = DB::select("
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

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function candidatesAttendedPerPaper()
    {
        try {
            $data = DB::select("
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

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function attendanceStats()
    {
        try {
            $data = DB::select("
                SELECT 
                    a.remark,
                    COUNT(*) as count,
                    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM attendances)), 2) as percentage
                FROM attendances a
                GROUP BY a.remark
                ORDER BY count DESC
            ");

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function centrePerformance()
    {
        try {
            // Cache this heavy query for 10 minutes
            $data = Cache::remember('dashboard_centre_performance', 600, function () {
                try {
                    return DB::select("
                        SELECT 
                            c.name as centre_name,
                            c.location as centre_location,
                            COUNT(DISTINCT sc.candidate_id) as total_candidates,
                            COUNT(DISTINCT CASE WHEN tc.completed = 1 THEN sc.candidate_id END) as completed_candidates,
                            ROUND(AVG(s.point_scored), 2) as average_score,
                            COUNT(s.id) as total_responses
                        FROM centres c
                        INNER JOIN venues v ON v.centre_id = c.id
                        INNER JOIN schedulings sch ON sch.venue_id = v.id
                        INNER JOIN scheduled_candidates sc ON sc.schedule_id = sch.id
                        LEFT JOIN time_controls tc ON tc.scheduled_candidate_id = sc.id
                        LEFT JOIN scores s ON s.scheduled_candidate_id = sc.id
                        WHERE sc.id IS NOT NULL
                        GROUP BY c.id, c.name, c.location
                        HAVING total_candidates > 0
                        ORDER BY average_score DESC
                        LIMIT 20
                    ");
                } catch (\Exception $e) {
                    // Fallback to simpler query if complex one fails
                    return DB::select("
                        SELECT 
                            c.name as centre_name,
                            c.location as centre_location,
                            COUNT(DISTINCT sc.candidate_id) as total_candidates,
                            0 as completed_candidates,
                            0 as average_score,
                            0 as total_responses
                        FROM centres c
                        INNER JOIN venues v ON v.centre_id = c.id
                        INNER JOIN schedulings sch ON sch.venue_id = v.id
                        INNER JOIN scheduled_candidates sc ON sc.schedule_id = sch.id
                        GROUP BY c.id, c.name, c.location
                        HAVING total_candidates > 0
                        ORDER BY total_candidates DESC
                        LIMIT 15
                    ");
                }
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Unable to load centre performance data. Please try again later.']);
        }
    }

    public function dailyActivity()
    {
        try {
            $data = DB::select("
                SELECT 
                    DATE(tc.created_at) as exam_date,
                    COUNT(DISTINCT tc.scheduled_candidate_id) as candidates_started,
                    COUNT(DISTINCT CASE WHEN tc.completed = 1 THEN tc.scheduled_candidate_id END) as candidates_completed
                FROM time_controls tc
                WHERE tc.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY)
                GROUP BY DATE(tc.created_at)
                ORDER BY exam_date ASC
            ");

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function subjectPerformance()
    {
        try {
            // Cache this heavy query for 10 minutes
            $data = Cache::remember('dashboard_subject_performance', 600, function () {
                try {
                    return DB::select("
                        SELECT 
                            sub.name as subject_name,
                            sub.subject_code,
                            COUNT(DISTINCT cs.scheduled_candidate_id) as enrolled_candidates,
                            COUNT(s.id) as total_responses,
                            ROUND(AVG(s.point_scored), 2) as average_score,
                            COUNT(DISTINCT CASE WHEN s.point_scored >= 0.5 THEN cs.scheduled_candidate_id END) as passed_candidates
                        FROM subjects sub
                        INNER JOIN candidate_subjects cs ON cs.subject_id = sub.id
                        INNER JOIN scores s ON s.scheduled_candidate_id = cs.scheduled_candidate_id
                        WHERE cs.scheduled_candidate_id IS NOT NULL
                        GROUP BY sub.id, sub.name, sub.subject_code
                        HAVING enrolled_candidates > 0
                        ORDER BY average_score DESC
                        LIMIT 15
                    ");
                } catch (\Exception $e) {
                    // Fallback to simpler query
                    return DB::select("
                        SELECT 
                            sub.name as subject_name,
                            sub.subject_code,
                            COUNT(DISTINCT cs.scheduled_candidate_id) as enrolled_candidates,
                            0 as total_responses,
                            0 as average_score,
                            0 as passed_candidates
                        FROM subjects sub
                        INNER JOIN candidate_subjects cs ON cs.subject_id = sub.id
                        GROUP BY sub.id, sub.name, sub.subject_code
                        HAVING enrolled_candidates > 0
                        ORDER BY enrolled_candidates DESC
                        LIMIT 10
                    ");
                }
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Unable to load subject performance data. Please try again later.']);
        }
    }

    public function centreCapacityUtilization()
    {
        try {
            // Cache this query for 15 minutes
            $data = Cache::remember('dashboard_capacity_utilization', 900, function () {
                return DB::select("
                    SELECT 
                        c.name as centre_name,
                        SUM(v.capacity) as total_capacity,
                        COUNT(DISTINCT sc.candidate_id) as scheduled_candidates,
                        ROUND((COUNT(DISTINCT sc.candidate_id) * 100.0 / SUM(v.capacity)), 2) as utilization_percentage
                    FROM centres c
                    INNER JOIN venues v ON v.centre_id = c.id
                    INNER JOIN schedulings sch ON sch.venue_id = v.id
                    INNER JOIN scheduled_candidates sc ON sc.schedule_id = sch.id
                    WHERE v.capacity > 0
                    GROUP BY c.id, c.name
                    HAVING total_capacity > 0
                    ORDER BY utilization_percentage DESC
                    LIMIT 15
                ");
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function examStatus()
    {
        try {
            $total_candidates = Candidate::count();
            $total_submitted = TimeControl::where('completed', 1)->count();
            $total_in_progress = TimeControl::where('completed', 0)->count();
            $total_pending = $total_candidates - ($total_submitted + $total_in_progress);

            $data = [
                'completed' => $total_submitted,
                'in_progress' => $total_in_progress,
                'not_started' => $total_pending
            ];

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function testProgrammePerformance()
    {
        try {
            $data = TestCode::select('test_codes.name')
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

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function topScorers()
    {
        try {
            // Cache this heavy query for 15 minutes
            $top_scorers_by_cadre = Cache::remember('dashboard_top_scorers', 900, function () {
                try {
                    return DB::select("
                        SELECT 
                            tc.name as cadre_name,
                            CONCAT(c.surname, ' ', c.firstname) as candidate_name,
                            c.indexing,
                            AVG(s.point_scored) as average_score,
                            COUNT(s.id) as total_questions
                        FROM test_codes tc
                        INNER JOIN test_configs tcfg ON tcfg.test_code_id = tc.id
                        INNER JOIN schedulings sch ON sch.test_config_id = tcfg.id
                        INNER JOIN scheduled_candidates sc ON sc.schedule_id = sch.id
                        INNER JOIN candidates c ON c.id = sc.candidate_id
                        INNER JOIN scores s ON s.scheduled_candidate_id = sc.id
                        WHERE s.point_scored > 0
                        GROUP BY tc.id, tc.name, c.id, c.surname, c.firstname, c.indexing
                        HAVING COUNT(s.id) >= 5
                        ORDER BY tc.name, average_score DESC
                        LIMIT 50
                    ");
                } catch (\Exception $e) {
                    // Fallback to empty array - will show "No data available" message
                    return [];
                }
            });

            // Group top scorers by cadre and get the highest scorer for each
            $cadre_top_scorers = [];
            $grouped_scorers = collect($top_scorers_by_cadre)->groupBy('cadre_name');

            foreach($grouped_scorers as $cadre => $scorers) {
                $top_scorer = $scorers->first();
                if($top_scorer && $top_scorer->average_score > 0) {
                    $cadre_top_scorers[] = [
                        'cadre' => $cadre,
                        'candidate_name' => $top_scorer->candidate_name,
                        'indexing' => $top_scorer->indexing,
                        'average_score' => round($top_scorer->average_score, 2),
                        'total_questions' => $top_scorer->total_questions,
                        'percentage' => round(($top_scorer->average_score / 1) * 100, 1)
                    ];
                }
            }

            return response()->json(['success' => true, 'data' => $cadre_top_scorers]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}

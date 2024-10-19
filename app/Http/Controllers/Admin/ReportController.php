<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Centre;
use App\Models\Score;
use App\Models\Subject;
use App\Models\TestConfig;
use App\Models\TestQuestion;
use App\Models\TestSubject;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.admin.reports.index');
    }

    public function testReports()
    {
        return view('pages.admin.reports.test-reports');
    }

    public function reportSummary()
    {
        $years = TestConfig::select('session')->groupBy('session')->orderBy('session', 'desc')->get()->pluck('session');
        $centres = Centre::orderBy('name','asc')->get();
        return view('pages.admin.reports.report-summary', compact('years', 'centres'));
    }

    public function generateReport(Request $request)
    {
        try {
            // return  $request;
            $subjects = Subject::distinct()->pluck('subject_code')->toArray();
            $subjects = Subject::all();
            $centre_id = $request->centre_id;
            $year = $request->year;
            $code_id = $request->code_id;
            $type_id = $request->type_id;
            // // return $subjects;
            $titles = $scores = $candidates = $results = [];
            foreach($subjects as $subject){
                $titles[$subject->id] = $subject->subject_code;
            }
            $candidates = Candidate::selectRaw("
                CONCAT(candidates.surname, ' ', candidates.firstname, ' ', IFNULL(candidates.other_names, '')) AS fullname,
                candidates.indexing AS indexing,
                scheduled_candidates.id AS scheduled_candidate_id,
                candidates.id AS candidate_id,
                test_configs.id AS test_config_id,
                centres.name AS centre,
                SUM(CASE WHEN subjects.subject_code = 'P1' THEN scores.point_scored ELSE 0 END) AS P1,
                SUM(CASE WHEN subjects.subject_code = 'P2' THEN scores.point_scored ELSE 0 END) AS P2,
                SUM(CASE WHEN subjects.subject_code = 'P3' THEN scores.point_scored ELSE 0 END) AS P3,
                (SELECT SUM(pe.score) FROM practical_examinations pe WHERE pe.candidate_id = candidates.id) AS PE,
                (SELECT SUM(pa.score) FROM project_assessments pa WHERE pa.candidate_id = candidates.id) AS PA
            ")
            ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', '=', 'candidates.id')
            ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', '=', 'scheduled_candidates.id')
            ->join('schedulings', 'schedulings.id', '=', 'scheduled_candidates.schedule_id')
            ->join('test_configs', 'test_configs.id', '=', 'schedulings.test_config_id')
            ->join('venues', 'venues.id', '=', 'schedulings.venue_id')
            ->join('centres', 'centres.id', '=', 'venues.centre_id')
            ->leftJoin('scores', 'scores.scheduled_candidate_id', '=', 'scheduled_candidates.id')
            ->leftJoin('subjects', 'subjects.id', '=', 'candidate_subjects.subject_id')
            ->where([
                'centres.id' => $centre_id,
                'candidates.exam_year' => $year,
                'test_configs.test_code_id' => $code_id,
                'test_configs.test_type_id' => $type_id,
            ])
            ->groupBy('candidates.id')
            ->get();


            // $statistics = Candidate::selectRaw("
            //     COUNT(candidates.id) AS total_candidates,

            //     -- Total count of candidates with below 50 in each subject/assessment
            //     -- SUM(CASE WHEN subjects.subject_code = 'P1' AND scores.point_scored < 50 THEN 1 ELSE 0 END) AS P1_below_50_count,
            //     SUM(CASE WHEN subjects.subject_code = 'P2' AND scores.point_scored < 50 THEN 1 ELSE 0 END) AS P2_below_50_count,
            //     SUM(CASE WHEN subjects.subject_code = 'P3' AND scores.point_scored < 50 THEN 1 ELSE 0 END) AS P3_below_50_count,
            //     SUM(CASE WHEN (SELECT SUM(pe.score) FROM practical_examinations pe WHERE pe.candidate_id = candidates.id) < 50 THEN 1 ELSE 0 END) AS PE_below_50_count,
            //     SUM(CASE WHEN (SELECT SUM(pa.score) FROM project_assessments pa WHERE pa.candidate_id = candidates.id) < 10 THEN 1 ELSE 0 END) AS PA_below_50_count,

            //     -- Total count of candidates with above 50 in each subject/assessment
            //     SUM(CASE WHEN subjects.subject_code = 'P1' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) AS P1_above_50_count,
            //     SUM(CASE WHEN subjects.subject_code = 'P2' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) AS P2_above_50_count,
            //     SUM(CASE WHEN subjects.subject_code = 'P3' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) AS P3_above_50_count,
            //     SUM(CASE WHEN (SELECT SUM(pe.score) FROM practical_examinations pe WHERE pe.candidate_id = candidates.id) >= 50 THEN 1 ELSE 0 END) AS PE_above_50_count,
            //     SUM(CASE WHEN (SELECT SUM(pa.score) FROM project_assessments pa WHERE pa.candidate_id = candidates.id) >= 10 THEN 1 ELSE 0 END) AS PA_above_50_count,

            //     -- Percentage calculations
            //     (SUM(CASE WHEN subjects.subject_code = 'P1' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS P1_above_50_percentage,
            //     (SUM(CASE WHEN subjects.subject_code = 'P2' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS P2_above_50_percentage,
            //     (SUM(CASE WHEN subjects.subject_code = 'P3' AND scores.point_scored >= 50 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS P3_above_50_percentage,
            //     (SUM(CASE WHEN (SELECT SUM(pe.score) FROM practical_examinations pe WHERE pe.candidate_id = candidates.id) >= 50 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS PE_above_50_percentage,
            //     (SUM(CASE WHEN (SELECT SUM(pa.score) FROM project_assessments pa WHERE pa.candidate_id = candidates.id) >= 10 THEN 1 ELSE 0 END) / COUNT(candidates.id)) * 100 AS PA_above_50_percentage,

            //     SUM(
            //         CASE 
            //         WHEN subjects.subject_code = 'P1' 
            //         AND 
            //         (
            //             SELECT sum(s.point_scored) 
            //             FROM scores s
            //             JOIN scheduled_candidates sc ON sc.id = s.scheduled_candidate_id
            //             JOIN candidates c ON c.id = sc.candidate_id
            //             JOIN candidate_subjects cs ON cs.scheduled_candidate_id = sc.id
            //             JOIN subjects sj ON sj.id = cs.subject_id
            //             WHERE c.id = candidates.id
            //             AND sj.subject_code = 'P1'
            //         )  < 50 
            //         THEN 1 
            //         ELSE 0 
            //         END
            //     ) AS P1_below_50_count
                
            // ")
            // ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', '=', 'candidates.id')
            // ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', '=', 'scheduled_candidates.id')
            // ->join('schedulings', 'schedulings.id', '=', 'scheduled_candidates.schedule_id')
            // ->join('test_configs', 'test_configs.id', '=', 'schedulings.test_config_id')
            // ->join('venues', 'venues.id', '=', 'schedulings.venue_id')
            // ->join('centres', 'centres.id', '=', 'venues.centre_id')
            // ->leftJoin('scores', 'scores.scheduled_candidate_id', '=', 'scheduled_candidates.id')
            // ->leftJoin('subjects', 'subjects.id', '=', 'candidate_subjects.subject_id')
            // ->where([
            //     'centres.id' => $centre_id,
            //     'candidates.exam_year' => $year,
            //     'test_configs.test_code_id' => $code_id,
            //     'test_configs.test_type_id' => $type_id,
            // ])
            // // ->groupBy('candidates.id')
            // ->first();

            // $statistics = DB::select("
            //     SELECT 
            //         COUNT(DISTINCT candidates.id) AS total_candidates,
            //         SUM(CASE WHEN scores_total.subject_code = 'P1' AND scores_total.total_score < 50 THEN 1 ELSE 0 END) AS P1_below_50_count,
            //         SUM(CASE WHEN scores_total.subject_code = 'P1' AND scores_total.total_score >= 50 THEN 1 ELSE 0 END) AS P1_above_50_count,
            //         SUM(CASE WHEN scores_total.subject_code = 'P2' AND scores_total.total_score < 50 THEN 1 ELSE 0 END) AS P2_below_50_count,
            //         SUM(CASE WHEN scores_total.subject_code = 'P2' AND scores_total.total_score >= 50 THEN 1 ELSE 0 END) AS P2_above_50_count,
            //         SUM(CASE WHEN scores_total.subject_code = 'P3' AND scores_total.total_score < 50 THEN 1 ELSE 0 END) AS P3_below_50_count,
            //         SUM(CASE WHEN scores_total.subject_code = 'P3' AND scores_total.total_score >= 50 THEN 1 ELSE 0 END) AS P3_above_50_count
            //     FROM candidates
            //     JOIN scheduled_candidates ON scheduled_candidates.candidate_id = candidates.id
            //     JOIN schedulings ON schedulings.id = scheduled_candidates.schedule_id
            //     JOIN venues ON venues.id = schedulings.venue_id
            //     JOIN centres ON centres.id = venues.centre_id
            //     JOIN test_configs ON test_configs.id = schedulings.test_config_id
            //     LEFT JOIN (
            //         SELECT
            //             scheduled_candidates.candidate_id,
            //             subjects.subject_code,
            //             SUM(scores.point_scored) AS total_score
            //         FROM scores
            //         JOIN scheduled_candidates ON scheduled_candidates.id = scores.scheduled_candidate_id
            //         JOIN candidate_subjects ON candidate_subjects.scheduled_candidate_id = scheduled_candidates.id
            //         JOIN subjects ON subjects.id = candidate_subjects.subject_id
            //         JOIN schedulings ON schedulings.id = scheduled_candidates.schedule_id
            //         JOIN venues ON venues.id = schedulings.venue_id
            //         JOIN centres ON centres.id = venues.centre_id
            //         JOIN test_configs ON test_configs.id = schedulings.test_config_id
            //         WHERE centres.id = ? 
                
            //         AND test_configs.test_code_id = ? 
            //         AND test_configs.test_type_id = ?
            //         GROUP BY scores.scheduled_candidate_id
            //     ) AS scores_total ON scores_total.candidate_id = candidates.id
            //     WHERE centres.id = ? 
            //     AND candidates.exam_year = ? 
            //     AND test_configs.test_code_id = ? 
            //     AND test_configs.test_type_id = ?
            //     GROUP BY centres.id
                
            //     ", [$centre_id, $code_id, $type_id,$centre_id, $year, $code_id, $type_id]
            // );
        
            
            $statistics = [
                'P1_below_50_count'=>0,
                'P2_below_50_count'=>0,
                'P3_below_50_count'=>0,
                'PE_below_50_count'=>0,
                'PA_below_50_count'=>0,
                'P1_above_50_count'=>0,
                'P2_above_50_count'=>0,
                'P3_above_50_count'=>0,
                'PE_above_50_count'=>0,
                'PA_above_50_count'=>0,
            ];

            foreach($candidates as $candidate){
                if($candidate->P1 >= 50) $statistics['P1_above_50_count'] ++; else $statistics['P1_below_50_count'] ++;
                if($candidate->P2 >= 50) $statistics['P2_above_50_count'] ++; else $statistics['P2_below_50_count'] ++;
                if($candidate->P3 >= 50) $statistics['P3_above_50_count'] ++; else $statistics['P3_below_50_count'] ++;
                if($candidate->PE >= 50) $statistics['PE_above_50_count'] ++; else $statistics['PE_below_50_count'] ++;
                if($candidate->PA >= 10) $statistics['PA_above_50_count'] ++; else $statistics['PA_below_50_count'] ++;
            }

            return $statistics;
            // return $statistics;
            // $candidates = Candidate::selectRaw("
            //     CONCAT(candidates.surname,' ', candidates.firstname,' ', IFNULL(candidates.other_names, '')) as fullname,
            //     candidates.indexing as indexing,
            //     scheduled_candidates.id as scheduled_candidate_id,
            //     candidate_id,
            //     test_configs.id as test_config_id,
            //     centres.name as centre,
            //     (
            //         SELECT sum(s.point_scored) 
            //         FROM scores s
            //         JOIN scheduled_candidates sc ON sc.id = s.scheduled_candidate_id
            //         JOIN candidates c ON c.id = sc.candidate_id
            //         JOIN candidate_subjects cs ON cs.scheduled_candidate_id = sc.id
            //         JOIN subjects sj ON sj.id = cs.subject_id
            //         WHERE c.id = candidates.id
            //         AND sj.subject_code = 'P1'
            //     ) as P1,
            //     (
            //         SELECT sum(s.point_scored) 
            //         FROM scores s
            //         JOIN scheduled_candidates sc ON sc.id = s.scheduled_candidate_id
            //         JOIN candidates c ON c.id = sc.candidate_id
            //         JOIN candidate_subjects cs ON cs.scheduled_candidate_id = sc.id
            //         JOIN subjects sj ON sj.id = cs.subject_id
            //         WHERE c.id = candidates.id
            //         AND sj.subject_code = 'P2'
            //     ) as P2,
            //     (
            //         SELECT sum(s.point_scored) 
            //         FROM scores s
            //         JOIN scheduled_candidates sc ON sc.id = s.scheduled_candidate_id
            //         JOIN candidates c ON c.id = sc.candidate_id
            //         JOIN candidate_subjects cs ON cs.scheduled_candidate_id = sc.id
            //         JOIN subjects sj ON sj.id = cs.subject_id
            //         WHERE c.id = candidates.id
            //         AND sj.subject_code = 'P3'
            //     ) as P3,
            //     (
            //         SELECT sum(pe.score) 
            //         FROM practical_examinations pe
            //         WHERE pe.candidate_id = candidates.id
            //     ) AS PE,
            //     (
            //         SELECT sum(pa.score) 
            //         FROM project_assessments pa
            //         WHERE pa.candidate_id = candidates.id
            //     ) AS PA

            // ")
            // ->join('scheduled_candidates','scheduled_candidates.candidate_id', 'candidates.id')
            // ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', 'scheduled_candidates.id')
            // ->join('schedulings', 'schedulings.id', 'scheduled_candidates.schedule_id')
            // ->join('test_configs','test_configs.id', 'schedulings.test_config_id')
            // ->join('venues','venues.id', 'schedulings.venue_id')
            // ->join('centres','centres.id', 'venues.centre_id')    
            // ->where([
            //     'centres.id'=>$centre_id,
            //     'candidates.exam_year'=>$year,
            //     'test_configs.test_code_id'=>$code_id,
            //     'test_configs.test_type_id'=>$type_id
            // ])
            // ->groupBy('candidates.id')
            // ->get();

            // $candidates = Candidate::all();
            // return $candidates;
            // return $scores;
            // // return $titles;

            // $candidates = Candidate::select('candidates.indexing', 'candidates.firstname', 'candidates.surname', 'candidates.other_names')
            //     ->join('scheduled_candidates', 'candidates.id', '=', 'scheduled_candidates.candidate_id')
            //     ->join('candidate_subjects', 'scheduled_candidates.id', '=', 'candidate_subjects.scheduled_candidate_id')
            //     ->join('subjects', 'candidate_subjects.subject_id', '=', 'subjects.id')
            //     ->join('scores', 'scores.scheduled_candidate_id', '=', 'scheduled_candidates.id')
            //     ->join('question_banks', 'scores.question_bank_id', '=', 'question_banks.id')
            //     ->join('test_configs', 'scores.test_config_id', '=', 'test_configs.id')
            //     ->where('test_config_id', $request->test_config_id)
            //     ->groupBy('candidates.indexing')
            //     ->get();

            // return $candidates;

            // $reports = [];
            // foreach ($candidates as $candidate) {
            //     $candidateData = [
            //         'indexing' => $candidate->indexing,
            //         'surname' => $candidate->surname,
            //         'firstname' => $candidate->firstname,
            //         'other_names' => $candidate->other_names,
            //     ];

            //     foreach ($subjects as $subject) {
            //         $score = DB::table('scores')
            //             ->join('candidate_subjects', 'scores.scheduled_candidate_id', '=', 'candidate_subjects.scheduled_candidate_id')
            //             ->join('subjects', 'candidate_subjects.subject_id', '=', 'subjects.id')
            //             ->join('test_configs', 'scores.test_config_id', '=', 'test_configs.id')
            //             ->where('subjects.name', $subject)
            //             ->where('scores.scheduled_candidate_id', $candidate->scheduled_candidate_id)
            //             ->select(DB::raw('(scores.point_scored / test_configs.total_mark) * 100 as percentage'))
            //             ->value('percentage');
            //         $candidateData[$subject] = $score ? number_format($score, 2) . '%' : '';
            //     }

            //     $reports[] = $candidateData;
            // }

            return view('pages.admin.reports.ajax.report-summary', compact('candidates', 'subjects','statistics'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function questionSummary()
    {
        $configs = $this->tests();

        return view('pages.admin.reports.question-summary', compact('configs'));
    }

    public function generateQuestionSummary(Request $request)
    {
        try {
            $where = [];
            $subject_id = $request->test_subject_id;
            $config_id = $request->test_config_id;

            if ($subject_id != '%')
                $where[] = ['subject_id', $subject_id];

            $where[] = ['test_config_id', $config_id];

            $report = [];

            $subjects = TestSubject::with('subject')->where($where)->get()->pluck('subject');
            foreach ($subjects as $subject) {
                $obj = [];
                $questions = TestQuestion::with('question_bank')
                    ->join('test_sections', 'test_sections.id', '=', 'test_questions.test_section_id')
                    ->join('test_subjects', 'test_subjects.id', '=', 'test_sections.test_subject_id')
                    ->select('question_bank_id')
                    ->where([
                        'test_subjects.test_config_id' => $config_id,
                        'subject_id' => $subject->id
                    ])
                    ->get();

                $qtns = [];
                foreach ($questions as $q) {
                    $qtnStat = [];
                    $question = $q->question_bank;
                    $options = $q->question_bank->answer_options;
                    $counts = DB::table('presentations')
                        ->select(DB::raw('count(distinct scheduled_candidate_id) as presented'))
                        ->where(['test_config_id' => $config_id, 'question_bank_id' => $question->id])
                        ->pluck('presented')->first();

                    $qtnStat['id'] = $question->id;
                    $qtnStat['presented'] = $counts;

                    $correct = 0;
                    $optionStat = [];
                    foreach ($options as $option) {
                        $stat = [];
                        $stat['correct'] = 0;
                        if ($option->correctness == 1) {
                            $correct = $option->id;
                            $stat['correct'] = 1;
                        }

                        $counts = DB::table('scores')
                            ->select(DB::raw('count(*) as total'))
                            ->where(['test_config_id' => $config_id, 'answer_option_id' => $option->id])
                            ->pluck('total')->first();

                        $stat['option'] = $option->question_option;
                        $stat['count'] = $counts;

                        $optionStat[] = $stat;
                    }

                    $failed = 0;
                    if ($correct !== 0) {
                        $counts = DB::table('scores')
                            ->select(DB::raw('count(distinct scheduled_candidate_id) as correct'))
                            ->where(['test_config_id' => $config_id, 'question_bank_id' => $question->id, 'answer_option_id' => $correct])
                            ->pluck('correct')->first();
                        $correct = $counts;

                        $counts = DB::table('scores')
                            ->select(DB::raw('count(distinct scheduled_candidate_id) as correct'))
                            ->where(['test_config_id' => $config_id, 'question_bank_id' => $question->id])
                            ->where('answer_option_id', '<>', $correct)
                            ->pluck('correct')->first();
                        $failed = $counts;
                    }

                    $qtnStat['failed'] = $failed;
                    $qtnStat['passed'] = $correct;
                    $qtnStat['options'] = $optionStat;
                    $qtnStat['question'] = $question->title;
                    $qtnStat['no_count'] = $qtnStat['presented'] - ($failed + $correct);

                    $qtns[] = $qtnStat;
                }

                $obj['subject'] = $subject->subject_code . ' - ' . $subject->name;
                $obj['questions'] = $qtns;

                $report[] = $obj;
            }

            //return $report;

            return view('pages.admin.reports.ajax.question-summary', compact('report'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function presentationSummary()
    {
        $configs = $this->tests();

        return view('pages.admin.reports.presentation-summary', compact('configs'));
    }

    public function generatePresentationSummary(Request $request)
    {
        try {
            $config = $request->test_config_id;
            $candidatesIds = $request->candidates;

            $testSubjects = TestSubject::with('subject')
                ->select('subject_id')
                ->where('test_config_id', $config)
                ->get();

            $subjects = [];
            foreach ($testSubjects as $testSubject)
                $subjects[] = $testSubject->subject;


            $candidates = Candidate::select('id', 'indexing', 'surname', 'firstname', 'other_names')
                ->whereIn('id', $candidatesIds)
                ->get();

            return view('pages.admin.reports.ajax.presentation-summary', compact('candidates', 'subjects', 'config'));

            /*
            foreach ($candidates as $candidate) {
                foreach ($subjects as $subject) {
                    $sections = TestSection::select('id', 'title', 'instruction')
                        ->where('test_subject_id', $subject->id)->get();

                    foreach ($sections as $section) {
                        $questions = DB::table('presentations')
                            ->join('test_sections', 'test_sections.id', '=', 'presentations.test_section_id')
                            ->join('question_banks', 'question_banks.id', '=', 'presentations.question_bank_id')
                            ->join('test_subjects', 'test_subjects.id', '=', 'test_sections.test_subject_id')//
                            ->select('question_banks.id', 'question_banks.title as question')
                            ->where([
                                'test_sections.id' => $section->id,
                                'presentations.test_config_id' => $config,
                                'presentations.scheduled_candidate_id' => $candidate->id
                            ])
                            ->distinct('presentations.question_bank_id')
                            ->get();

                        foreach ($questions as $question) {
                            $options = AnswerOption::select('id', 'question_option as option', 'correctness')
                                ->where('question_bank_id', $question->id)->get();
                            $selection = Score::select('answer_option_id as selection')
                                ->where([
                                    'test_config_id' => $config,
                                    'question_bank_id' => $question->id,
                                    'scheduled_candidate_id' => $candidate->id
                                ])
                                ->pluck('selection')->first();

                            $question->selection = $selection;
                            $question->options = $options;
                        }

                        $section['questions'] = $questions;
                    }

                    $subject['sections'] = $sections;
                }
                $candidate['subjects'] = $subjects;
            }

            return $candidate;
            */
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function activeCandidates()
    {
        $exams = TestConfig::exam()->get();
        return view('pages.admin.reports.active-candidates', compact('exams'));
    }

    public function daily()
    {
        return view('pages.admin.reports.test-reports');
    }

    public function generateActiveCandidates(Request $request)
    {
        try {
            $test_config_id  = $request->test_config_id;
            // $actives = DB::table('time_controls')
            //     ->join('candidates', 'candidates.id', '=', 'time_controls.scheduled_candidate_id')
            //     ->select(
            //         'indexing',
            //         'time_controls.id AS eid',
            //         'scheduled_candidate_id',
            //         DB::raw('concat(candidates.surname," ",candidates.firstname," ",candidates.other_names) as name'),
            //         'ip as address'
            //     )
            //     ->where(['test_config_id' => $request->test_config_id, 'completed' => 0])
            //     ->get();
            // return $test_config_id;
            $candidates =  Candidate::manage($test_config_id)->get();
            
            return view('pages.toolbox.ajax.active', compact('candidates'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function generateDaily(Request $request)
    {
        return $request;
    }


    private function tests()
    {
        return TestConfig::with(['test_type', 'test_code'])
            ->select(['id', 'session', 'semester', 'test_type_id', 'test_code_id'])
            ->orderBy('session', 'desc')
            ->get();
    }
}

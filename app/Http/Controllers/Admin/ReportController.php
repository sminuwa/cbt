<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Score;
use App\Models\Subject;
use App\Models\TestConfig;
use App\Models\TestQuestion;
use App\Models\TestSubject;
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
        return view('pages.admin.reports.report-summary', compact('years'));
    }

    public function generateReport(Request $request)
    {
        try {
            $subjects = Subject::distinct()->pluck('subject_code')->toArray();

            $candidates = Candidate::select('candidates.indexing', 'candidates.firstname', 'candidates.surname', 'candidates.other_names')
                ->join('scheduled_candidates', 'candidates.id', '=', 'scheduled_candidates.candidate_id')
                ->join('candidate_subjects', 'scheduled_candidates.id', '=', 'candidate_subjects.scheduled_candidate_id')
                ->join('subjects', 'candidate_subjects.subject_id', '=', 'subjects.id')
                ->join('scores', 'scores.scheduled_candidate_id', '=', 'scheduled_candidates.id')
                ->join('question_banks', 'scores.question_bank_id', '=', 'question_banks.id')
                ->join('test_configs', 'scores.test_config_id', '=', 'test_configs.id')
                ->where('test_config_id', $request->test_config_id)
                ->groupBy('candidates.indexing')
                ->get();

            $reports = [];
            foreach ($candidates as $candidate) {
                $candidateData = [
                    'indexing' => $candidate->indexing,
                    'surname' => $candidate->surname,
                    'firstname' => $candidate->firstname,
                    'other_names' => $candidate->other_names,
                ];

                foreach ($subjects as $subject) {
                    $score = DB::table('scores')
                        ->join('candidate_subjects', 'scores.scheduled_candidate_id', '=', 'candidate_subjects.scheduled_candidate_id')
                        ->join('subjects', 'candidate_subjects.subject_id', '=', 'subjects.id')
                        ->join('test_configs', 'scores.test_config_id', '=', 'test_configs.id')
                        ->where('subjects.name', $subject)
                        ->where('scores.scheduled_candidate_id', $candidate->scheduled_candidate_id)
                        ->select(DB::raw('(scores.point_scored / test_configs.total_mark) * 100 as percentage'))
                        ->value('percentage');
                    $candidateData[$subject] = $score ? number_format($score, 2) . '%' : '';
                }

                $reports[] = $candidateData;
            }

            return view('pages.admin.reports.ajax.report-summary', compact('reports', 'subjects'));
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
            $actives = DB::table('time_controls')
                ->join('candidates', 'candidates.id', '=', 'time_controls.scheduled_candidate_id')
                ->select(
                    'indexing',
                    'time_controls.id AS eid',
                    'scheduled_candidate_id',
                    DB::raw('concat(candidates.surname," ",candidates.firstname," ",candidates.other_names) as name'),
                    'ip as address'
                )
                ->where(['test_config_id' => $request->test_config_id, 'completed' => 0])
                ->get();

            return view('pages.admin.reports.ajax.active', compact('actives'));
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

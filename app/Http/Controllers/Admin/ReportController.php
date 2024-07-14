<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presentation;
use App\Models\Score;
use App\Models\TestConfig;
use App\Models\TestSubject;
use App\Models\Topic;
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
            $scores = Score::with([
                'answerOption',
                'questionBank.subject',
                'scheduledCandidate.candidate'
            ])
                ->whereHas('answerOption', function($query) {
                    $query->where('correctness', 1);
                })
                ->where('test_config_id', $request->test_config_id)
                ->get();

            $result = $scores->groupBy('scheduled_candidate_id')->map(function ($group) {
                $firstScore = $group->first();
                $candidate = $firstScore->scheduledCandidate->candidate;
                $subjectCodes = $group->pluck('questionBank.subject.subject_code')->unique()->implode(', ');

                return [
                    'scheduled_candidate_id' => $firstScore->scheduled_candidate_id,
                    'indexing' => $candidate->indexing,
                    'name' => $candidate->surname . ' ' . $candidate->firstname . ' ' . $candidate->other_names,
                    'test_config_id' => $firstScore->test_config_id,
                    'subject_codes' => $subjectCodes,
                    'aggregate' => $group->sum('mark_per_question'),
                    'score' => $group->count('question_bank_id')
                ];
            })->values();

            return $result;

            $codes = TestSubject::join('subjects', 'subjects.id', '=', 'test_subjects.subject_id')
                ->where('test_config_id', $request->test_config_id)->get()->pluck('subject_code')->toArray();

            $reports = Score::join('answer_options', 'answer_options.id', '=', 'scores.answer_option_id')
                ->join('question_banks', 'question_banks.id', '=', 'scores.question_bank_id')
                ->join('subjects', 'subjects.id', '=', 'question_banks.subject_id')
                ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', '=', 'scores.scheduled_candidate_id')
                ->join('candidates', 'candidates.id', '=', 'scheduled_candidates.candidate_id')
                ->join('test_questions', 'test_questions.question_bank_id', '=', 'scores.question_bank_id')
                ->join('test_sections', 'test_sections.id', '=', 'test_questions.test_section_id')
                ->select(
                    'scores.scheduled_candidate_id',
                    'candidates.indexing',
                    DB::raw('concat(candidates.surname," ",candidates.firstname," ",candidates.other_names) as name'),
                    'test_config_id',
                    'subjects.subject_code as codes',
                )
                ->where([
                    'correctness' => 1,
                    'test_config_id' => $request->test_config_id
                ])
                ->groupBy(
                    'scores.scheduled_candidate_id',
                    'candidates.indexing',
                    'candidates.surname',
                    'candidates.firstname',
                    'candidates.other_names',
                    'test_config_id',
                    'subjects.subject_code'
                )
                ->get();

            return view('pages.admin.reports.ajax.report-summary', compact('reports'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function testCode()
    {
        $years = TestConfig::select('session')->groupBy('session')->orderBy('session', 'desc')->get()->pluck('session');
        return view('pages.admin.reports.report-by-test-code', compact('years'));
    }

    public function daily()
    {
        return view('pages.admin.reports.test-reports');
    }

    public function generateByCode(Request $request)
    {
        $testConfig = TestConfig::where([
            'session' => $request->year, 'semester' => $request->semester,
            'test_code_id' => $request->test_code_id, 'test_type_id' => $request->test_type_id
        ])->get()->first();

        $message = '';
        if (!$testConfig)
            $message = 'No record matched';
        else {
            Presentation::where(['' => $testConfig->id])->distinct('candidate_id')->get();
        }

        $reports = Topic::all();

        return view('pages.admin.reports.ajax.testcode', compact('reports'));
    }

    public function generateDaily(Request $request)
    {
        return $request;
    }

}

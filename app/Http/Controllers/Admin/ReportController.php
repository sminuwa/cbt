<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presentation;
use App\Models\TestConfig;
use App\Models\Topic;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.admin.reports.index');
    }

    public function testCode()
    {
        $years = TestConfig::select('session')->groupBy('session')->orderBy('session', 'desc')->get()->pluck('session');
        return view('pages.admin.reports.report-by-test-code', compact('years'));
    }

    public function daily()
    {
        return view('pages.admin.reports.dailyreport');
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

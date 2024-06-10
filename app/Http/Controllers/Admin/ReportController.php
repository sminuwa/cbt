<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('pages.admin.reports.report-by-test-code');
    }

    public function daily()
    {
        return view('pages.admin.reports.dailyreport');
    }

    public function generateByCode(Request $request)
    {
        $reports = Topic::all();

        return view('pages.admin.reports.ajax.testcode', compact('reports'));
    }

    public function generateDaily(Request $request)
    {
        return $request;
    }

}

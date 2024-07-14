<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\FacultyScheduleMapping;
use App\Models\Scheduling;
use App\Models\TestConfig;
use App\Models\Venue;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;

class MiscController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function venues($centre_id)
    {
        return Venue::where(['centre_id' => $centre_id])->get();
    }

    public function facultyMappings(Scheduling $scheduling)
    {
        $index = 0;
        $mapped_ids = [];
        $faculties = Faculty::all();
        $config_id = $scheduling->test_config_id;
        $mappings = FacultyScheduleMapping::where(['scheduling_id' => $scheduling->id])->get();
        foreach ($mappings as $mapping)
            $mapped_ids[] = $mapping->faculty_id;

        foreach ($faculties as $faculty) {
            if ($index < count($mappings))
                $faculty->mapped = in_array($faculty->id, $mapped_ids);
        }

        return view('pages.author.test.config.ajax.faculty-mappings', compact('faculties', 'config_id'));
    }

    public function batchCapacity(Venue $venue)
    {
        return $venue;
    }

    public function testConfig($year, $type, $code)
    {
        $configs = TestConfig::with(['test_type', 'test_code'])
            ->select(['id', 'session', 'semester', 'test_type_id', 'test_code_id'])
            ->orderBy('session', 'desc')
            ->where(['session' => $year, 'test_type_id' => $type, 'test_code_id' => $code])
            ->get();

        return view('pages.admin.reports.ajax.tests', compact('configs'));
    }

}

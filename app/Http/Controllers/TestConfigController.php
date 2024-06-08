<?php

namespace App\Http\Controllers;

use App\Models\ExamsDate;
use App\Models\Scheduling;
use App\Models\TestConfig;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestConfigController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $user = Auth::user();
        return view('pages.author.test.config.index');
    }

    public function view(TestConfig $config)
    {
        return view('pages.author.test.config.view', compact('config'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            $config = new TestConfig();
            $config->fill($request->all());
            $config->initiated_by = $user->id;
            $config->date_initiated = now();
            $config->total_mark = 0.0;
            if ($config->save())
                return back()->with(['success' => true, 'message' => 'Test successfully created']);

            return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function basics(TestConfig $config): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('pages.author.test.config.basics', compact('config'));
    }

    public function storeBasics(Request $request): RedirectResponse
    {
        try {
            $config = TestConfig::find($request->id);
            if ($config) {
                $config->duration = $request->duration;
                $config->pass_key = $request->pass_key;
                $config->allow_calc = $request->allow_calc;
                $config->endorsement = $request->endorsement;
                $config->time_padding = $request->time_padding;
                $config->display_mode = $request->display_mode;
                $config->starting_mode = $request->starting_mode;
                $config->option_administration = $request->option_administration;
                $config->question_administration = $request->question_administration;
                if ($config->save())
                    return back()->with(['success' => true, 'message' => 'Test Configurations successfully saved']);
            }
            return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function dates($config_id): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $dates = $this->testDatesBy($config_id);
        return view('pages.author.test.config.dates', compact('config_id', 'dates'));
    }

    public function storeDate(Request $request)
    {
        $date = new ExamsDate();
        $date->test_config_id = $request->test_config_id;
        $date->date = $request->date;
        $date->save();

        $dates = $this->testDatesBy($request->test_config_id);
        return view('pages.author.test.config.ajax.test-dates', compact('dates'));
    }

    public function deleteDate(ExamsDate $date)
    {
        $config_id = $date->test_config_id;
        $date->delete();

        $dates = $this->testDatesBy($config_id);
        return view('pages.author.test.config.ajax.test-dates', compact('dates'));
    }

    private function testDatesBy($config_id)
    {
        return ExamsDate::where(['test_config_id' => $config_id])->get();
    }

    public function schedules($config_id): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $schedules = Scheduling::where(['test_config_id' => $config_id])->get();
        return view('pages.author.test.config.schedules', compact('schedules', 'config_id'));
    }

    public function storeSchedule(Request $request): RedirectResponse
    {
        try {
            $schedule = new Scheduling();
            $schedule->fill($request->all());
            if ($schedule->save())
                return back()->with(['success' => true, 'message' => 'Test Schedule successfully saved']);
            return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
        } catch (\Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\ExamsDate;
use App\Models\FacultyScheduleMapping;
use App\Models\QuestionBank;
use App\Models\Scheduling;
use App\Models\Subject;
use App\Models\TestConfig;
use App\Models\TestQuestion;
use App\Models\TestSection;
use App\Models\TestSubject;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    public function view(TestConfig $config): Factory|\Illuminate\Foundation\Application|View|Application
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
        Session::put('config', $config);
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

    public function storeDate(Request $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $date = new ExamsDate();
        $date->test_config_id = $request->test_config_id;
        $date->date = $request->date;
        $date->save();

        $dates = $this->testDatesBy($request->test_config_id);
        return view('pages.author.test.config.ajax.test-dates', compact('dates'));
    }

    public function deleteDate(ExamsDate $date): Factory|\Illuminate\Foundation\Application|View|Application
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
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function mappings($config_id)
    {
        $schedules = Scheduling::select(['schedulings.id', 'date', 'daily_start_time', 'centres.name as centre', 'venues.name as venue'])
            ->join('venues', 'venues.id', '=', 'schedulings.venue_id')
            ->join('centres', 'centres.id', '=', 'venues.centre_id')
            ->where(['schedulings.test_config_id' => $config_id])
            ->get();

        return view('pages.author.test.config.mapping', compact('config_id', 'schedules'));
    }

    public function storeMappings(Request $request)
    {
        try {
            $mapped_ids = [];
            $existingMappings = FacultyScheduleMapping::where(['scheduling_id' => $request->scheduling_id]);
            foreach ($existingMappings->get() as $mapping) {
                $mapped_ids[] = $mapping->faculty_id;
                if (!in_array($mapping->faculty_id, $request->mapped))
                    $mapping->delete();
            }

            foreach ($request->mapped as $faculty_id) {
                if (!in_array($faculty_id, $mapped_ids)) {
                    $fm = new FacultyScheduleMapping();
                    $fm->scheduling_id = $request->scheduling_id;
                    $fm->faculty_id = $faculty_id;
                    $fm->save();
                }
            }
            return back()->with(['success' => true, 'message' => 'Test Mappings successfully saved']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function subjects($config_id)
    {
        return view('pages.author.test.config.subjects', compact('config_id'));
    }

    public function subjectsAjax($config_id): Factory|\Illuminate\Foundation\Application|View|Application
    {

        $ids = $this->registeredSubjects($config_id)->pluck('subject_id');

        $subjects = Subject::select('id', 'name', 'subject_code')
            ->whereNotIn('id', $ids)
            ->orderBy('subject_code')
            ->get();

        return view('pages.author.test.config.ajax.subjects', compact('subjects'));
    }

    public function registeredSubjectsAjax($config_id): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $subjects = $this->registeredSubjects($config_id)->get();
        return view('pages.author.test.config.ajax.registered-subjects', compact('subjects'));
    }

    public function registerSubject(Request $request)
    {
        $testSubject = new TestSubject();
        $testSubject->subject_id = $request->subject_id;
        $testSubject->test_config_id = $request->test_config_id;
        $testSubject->save();
    }

    public function removeSubject(TestSubject $testSubject)
    {
        $testSubject->delete();
    }

    private function registeredSubjects($config_id): Builder
    {
        return TestSubject::with('subject')
            ->select(['id', 'subject_id'])
            ->where(['test_config_id' => $config_id]);
    }

    public function composition($config_id)
    {
        $subjects = $this->registeredSubjects($config_id)->get();
        return view('pages.author.test.config.composition', compact('config_id', 'subjects'));
    }

    public function compose(TestSubject $testSubject): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $sections = TestSection::where(['test_subject_id' => $testSubject->id])->get();
        return view('pages.author.test.config.compose', compact('sections', 'testSubject'));
    }

    public function storeSection(Request $request)
    {
        try {
            if (isset($request->id))
                $section = TestSection::find($request->id);
            else
                $section = new TestSection();
            $section->fill($request->all());
            $section->test_subject_id = $request->test_subject_id;
            if ($section->save())
                return back()->with(['success' => true, 'message' => 'Test Section successfully saved']);
            return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
        } catch (\Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function questions(TestSection $testSection)
    {
        $topics = $testSection->test_subject->subject->topics;
        return view('pages.author.test.config.compose-questions', compact('testSection', 'topics'));
    }

    public function loadQuestions(Request $request)
    {
        try {
            $where = [];
            $where[] = ['subject_id', '=', $request->subject_id];

            if ($request->difficulty_level != '%')
                $where[] = ['difficulty_level', '=', $request->difficulty_level];

            if ($request->topic_id != '%')
                $where[] = ['topic_id', '=', $request->topic_id];

            if ($request->author == 'me')
                $where[] = ['author', '=', Auth::user()->id];
            else if ($request->author == 'others')
                $where[] = ['author', '!=', Auth::user()->id];

            if (isset($request->phrase))
                $where[] = ['title', 'like', '%' . $request->phrase . '%'];

            $questions = QuestionBank::with('answer_options')->where($where)->get();

            $easy = 0;
            $moderate = 0;
            $difficult = 0;

            foreach ($questions as $question) {
                if ($question->difficulty_level == 'simple') $easy++;
                else if ($question->difficulty_level == 'moderate') $moderate++;
                else if ($question->difficulty_level == 'difficult') $difficult++;
            }

            $statistics['easy'] = $easy;
            $statistics['moderate'] = $moderate;
            $statistics['difficult'] = $difficult;
            $statistics['count'] = count($questions);

            $collection = collect($questions);
            $currentPage = $request->input('page', 1);
            $perPage = 40;
            $offset = ($currentPage - 1) * $perPage;
            $currentPageItems = $collection->slice($offset, $perPage)->values();

            $ids = [];
            $index = 0;
            $registered = TestQuestion::where(['test_section_id' => $request->test_section_id])->get();
            foreach ($registered as $qtn)
                $ids[] = $qtn->question_bank_id;

            foreach ($currentPageItems as $item) {
                if ($index < count($registered))
                    $item->checked = in_array($item->id, $ids);
            }

            $paginator = new LengthAwarePaginator(
                $currentPageItems,
                $collection->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url()]
            );

            return view('pages.author.test.config.ajax.questions',
                ['questions' => $paginator, 'statistics' => $statistics, 'page' => $currentPage, 'pageSize' => $perPage]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeQuestions(Request $request)
    {
        try {
            $section_id = $request->test_section_id;
            $selected_ids = $request->bank_ids;
            foreach ($selected_ids as $id) {
                $question = TestQuestion::where(['question_bank_id' => $id])->first();
                if ($question)
                    continue;
                $question = new TestQuestion();
                $question->question_bank_id = $id;
                $question->test_section_id = $section_id;
                $question->save();
            }
        } catch (\Exception $e) {
        }
    }

    public function removeQuestion($section_id, $bank_id)
    {
        $question = TestQuestion::where(['question_bank_id' => $bank_id, 'test_section_id' => $section_id])->first();
        $question->delete();
    }

}

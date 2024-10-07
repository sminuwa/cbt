<?php

namespace App\Http\Controllers;

use App\Imports\Upload;
use App\Models\Candidate;
use App\Models\CandidateSubject;
use App\Models\ExamsDate;
use App\Models\FacultyScheduleMapping;
use App\Models\QuestionBank;
use App\Models\QuestionPreviewer;
use App\Models\ScheduledCandidate;
use App\Models\Scheduling;
use App\Models\Subject;
use App\Models\TestCompositor;
use App\Models\TestConfig;
use App\Models\TestInvigilator;
use App\Models\TestQuestion;
use App\Models\TestSection;
use App\Models\TestSubject;
use App\Models\TestCode;
use App\Models\ExamType;
use App\Models\User;
use App\Models\Centre;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class TestConfigController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $user = Auth::user();
        $configs = TestConfig::with(['test_type', 'test_code','test_subjects'])
                // ->select(['id', 'session', 'semester', 'test_type_id', 'test_code_id'])
                ->orderBy('session', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
        $exam_types = ExamType::all();
        return view('pages.author.test.config.index', compact('configs','exam_types'));
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
                $config->status = $request->availability;
                $config->allow_calc = $request->allow_calc;
                $config->endorsement = $request->endorsement;
                $config->time_padding = $request->time_padding;
                $config->display_mode = $request->display_mode;
                $config->starting_mode = $request->starting_mode;
                $config->option_administration = $request->option_administration;
                $config->question_administration = $request->question_administration;
                $config->status = $request->availability;
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
            if (isset($request->id))
                $schedule = Scheduling::find($request->id);
            else
                $schedule = new Scheduling();
            $schedule->fill($request->all());
            if ($schedule->save())
                return back()->with(['success' => true, 'message' => 'Test Schedule successfully saved']);
            return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deleteSchedule(Scheduling $scheduling)
    {
        $candidates = $scheduling->candidate_students()->distinct('scheduled_candidate_id')->count();
        if ($candidates > 0)
            return view('pages.author.test.config.displacement-options', compact('candidates', 'scheduling'));
        else
            if ($scheduling->delete())
                return back()->with(['success' => true, 'message' => 'Test Schedule successfully deleted']);

        return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
    }

    public function removeAndDeleteSchedule(Scheduling $scheduling)
    {
        $config = $scheduling->test_config;
        $remove = CandidateSubject::where(['schedule_id' => $scheduling->id])->delete();
        if ($remove) {
            if ($scheduling->delete())
                return redirect(route('admin.test.config.schedules', [$config->id]))->with(['success' => true, 'message' => 'Affected Candidate(s) removed and Test Schedule successfully deleted']);
        }

        return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
    }

    public function otherSchedules(Scheduling $scheduling, $size)
    {
        $schedule_id = $scheduling->id;
        $others = Scheduling::with('venue')
            ->where(['test_config_id' => $scheduling->test_config_id])
            ->whereNot('id', $scheduling->id)
            ->get();

        $candidates = CandidateSubject::select(['schedule_id', 'scheduled_candidate_id', 'venues.id as venue_id'])
            ->join('schedulings', 'schedulings.id', '=', 'candidate_students.schedule_id')
            ->join('venues', 'venues.id', '=', 'schedulings.venue_id')
            ->where('schedule_id', '!=', $scheduling->id)
            ->distinct()
            ->get();

        foreach ($others as $other) {
            foreach ($candidates as $candidate) {
                if ($candidate->schedule_id == $other->id && $candidate->venue_id == $other->venue->id)
                    $other->venue->capacity -= 1;
            }
        }
        $schedules = $others;

        return view('pages.author.test.config.ajax.schedules', compact('schedules', 'size', 'schedule_id'));
    }

    public function reschedule(Request $request)
    {
        try {
            $candidates = CandidateSubject::where(['schedule_id' => $request->from]);
            $size = count($candidates->get());
            if ($candidates->update(['schedule_id' => $request->to])) {
                $schedule = Scheduling::find($request->from);
                $config = $schedule->test_config_id;

                if ($schedule->delete())
                    return [
                        'success' => true,
                        'url' => route('admin.test.config.schedules', [$config]),
                        'message' => $size . ' candidate(s) successfully rescheduled and the old schedule deleted'
                    ];
            }

            return [
                'success' => false,
                'url' => route('admin.test.config.schedules', [$config]),
                'message' => 'Oops! Look like something went wrong'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'url' => route('admin.test.config.schedules', [$config]),
                'message' => $e->getMessage()
            ];
        }
    }

    public function uploadOptions($config_id)
    {
        $schedules = Scheduling::with('venue')->where(['test_config_id' => $config_id])->get();
        return view('pages.author.test.config.upload-options', compact('config_id', 'schedules'));
    }
    
    public function bulkUpload(Request $request)
    {
        $candidate_papers = [];
        $schedule_id = $request->schedule_id;
        $test_config_id = $request->test_config_id;
        $test = TestConfig::exam()->where('test_configs.id', $test_config_id)->first();
        $schedule = Scheduling::where('id', $schedule_id)->first();
        // return $test->exam_type_id;
        $file = $request->file;
        $sheets =  Excel::toArray(\App\Models\Upload::class, $file);
        $exam_papers = Subject::select('id', 'subject_code as code')->orderBy('subject_code', 'asc')->get()->toArray();
        $codes = $scheduled_candidates = $candidates = $candidate_ids = $candidate_papers = $uploaded_papers = $errors = [];
        foreach($sheets as $rows) {
            if(empty($rows[0])) // if the sheet doesn't start at row 10 it means the sheet is empty
                continue;
            $title = $rows[0];
            $indexing = searchIndex($title, 'indexing');
            $papers = searchIndex($title, 'paper');
            
            // get unique candidate indexing
            foreach ($rows as $key => $value) {
                if ($key < 1)
                    continue;
                $index_numbers[] = str_replace(' ', '', trim($value[$indexing]));
            }
            $index_numbers = array_filter($index_numbers);
            $all_candidates = Candidate::select('candidates.id', 'candidates.indexing')
            ->whereIn('candidates.indexing', $index_numbers)
            ->get()->toArray();
            
            
            foreach ($rows as $key => $value) {
                if ($key < 1) // skip first row which is considered a title row for the uploaded Excel file.
                    continue;
                if(empty($value[$indexing]))
                    continue;
                
                $cdd = searchForId($value[$indexing], $all_candidates);
                if (!$cdd) //skip if institution code is not found in the institution table
                    continue;
                $candidate_ids[] = $cdd->id;
                $uploaded_papers[trim($cdd->id)] = trim($value[$papers]);
                $scheduled_candidates[] = [
                    'exam_type_id' => $test->exam_type_id,
                    'schedule_id' => $schedule->id,
                    'candidate_id' => $cdd->id,
                ];

            }

            

        }

        // return $candidate_papers;
        
        DB::beginTransaction();
        $err = [];
        foreach(array_chunk($scheduled_candidates, 500) as $key => $scheduled_candidate) {
            if(!ScheduledCandidate::upsert($scheduled_candidate, ['candidate_id', 'exam_type_id'])) {
                reset_auto_increment('scheduled_candidates');
                $err[] = 'Something went wrong. [Scheduled candidates chunk upload] '.$key;
            }
        }

        if(count($err) == 0){
            reset_auto_increment('scheduled_candidates');
            $get_schedules = ScheduledCandidate::whereIn('candidate_id', $candidate_ids)->where(['schedule_id'=> $schedule->id])->get();
            
            foreach($get_schedules as $get_schedule){
                $p =  explode(',',$uploaded_papers[$get_schedule->candidate_id]);
                foreach($p as $exam_paper){
                    if(!$ep = searchForId($exam_paper, $exam_papers))
                        continue;
                    $candidate_papers[] = [
                        'schedule_id'=>$schedule->id,
                        'scheduled_candidate_id' => $get_schedule->id,
                        'subject_id' => $ep->id,
                        'add_index'=>null,
                        'enabled'=>1
                    ];
                }

            }
            // return $candidate_papers;
            //                return $graduand_papers;
            $err = [];
            foreach(array_chunk($candidate_papers, 500) as $key => $candidate_paper) {
                if(!CandidateSubject::upsert($candidate_paper, ['subject_id', 'scheduled_candidate_id','subject_id'])) {
                    reset_auto_increment('candidate_subjects');
                    $err[] = 'Something went wrong. [Graduands chunk upload]';
                }
            }
            if(count($err) == 0){
                reset_auto_increment('scheduled_candidates');
            }else{
                $errors[] = 'Something went wrong while updating papers records for candidates.';
            }
        }else {
            $errors[] = 'Something went wrong while inserting candidate records.';
        }
        $success = count($scheduled_candidates);
        $scheduled = $success;
        $missing = [];
        
        if(empty($errors)){
            // DB::commit();
            return view('pages.author.test.config.upload-report', compact('success', 'scheduled', 'missing'));
        }else{
            // DB::rollback();
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }

    }

    private function updateBatches($schedule_id)
    {
        $schedule = Scheduling::with('venue')->find($schedule_id);
        $venueCap = $schedule->venue->capacity;
        $candidates = $schedule->candidate_students()->distinct('scheduled_candidate_id')->count();
        $batches = ceil($candidates / $venueCap);

        $schedule->maximum_batch = $batches;
        if ($schedule->save())
            return back()->with(['success' => true, 'message' => 'Candidate(s) successfully scheduled for this test']);

        return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
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
        return TestSubject::with(['subject', 'test_sections'])
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
        } catch (Exception $e) {
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
            $where[] = ['question_banks.subject_id', '=', $request->subject_id];

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

            $others_ids = TestSection::where('test_subject_id', $request->test_subject_id)->where('id', '<>', $request->test_section_id)->pluck('id')->toArray();
            $nots_ids = TestQuestion::whereIn('test_section_id', $others_ids)->pluck('question_bank_id')->toArray();
            $questions = QuestionBank::with('answer_options')->where($where)->whereNotIn('id', $nots_ids)->get();

            $easy = 0;
            $moderate = 0;
            $difficult = 0;

            foreach ($questions as $question) {
                if ($question->difficulty_level == 'simple')
                    $easy++;
                else if ($question->difficulty_level == 'moderate')
                    $moderate++;
                else if ($question->difficulty_level == 'difficult')
                    $difficult++;
            }

            $statistics['easy'] = $easy;
            $statistics['moderate'] = $moderate;
            $statistics['difficult'] = $difficult;
            $statistics['count'] = count($questions);

            $collection = collect($questions);
            $currentPage = $request->input('page', 1);
            $perPage = $request->page_count;
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

            return view(
                'pages.author.test.config.ajax.questions',
                ['questions' => $paginator, 'statistics' => $statistics, 'page' => $currentPage, 'pageSize' => $perPage]
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeQuestions(Request $request)
    {
        try {
            $selected_ids = $request->bank_ids;
            $section_id = $request->test_section_id;
            $allLevels = ['simple', 'moderate', 'difficult'];
            $section = TestSection::where('id', $section_id)->first();

            $query = QuestionBank::join('test_questions', 'test_questions.question_bank_id', '=', 'question_banks.id')
                ->select('difficulty_level', DB::raw('count(*) as total_questions'))
                ->where('test_section_id', $section_id)
                ->groupBy('difficulty_level');

            $counts = collect($allLevels)->mapWithKeys(function ($level) use ($query) {
                return [$level => $query->clone()->where('difficulty_level', $level)->value('total_questions') ?? 0];
            })->toArray();

            if ($section->num_to_answer > ($counts['simple'] + $counts['moderate'] + $counts['difficult'])) {
                $simples = [];
                $moderates = [];
                $difficults = [];
                $questions = QuestionBank::whereIn('id', $selected_ids)->get();
                foreach ($questions as $question) {
                    if ($question->difficulty_level == 'simple' && $section->num_of_easy > (count($simples) + $counts['simple']))
                        $simples[] = $question;
                    else if ($question->difficulty_level == 'moderate' && $section->num_of_moderate > (count($moderates) + $counts['moderate']))
                        $moderates[] = $question;
                    else if ($question->difficulty_level == 'difficult' && $section->num_of_difficult > (count($difficults) + $counts['difficult']))
                        $difficults[] = $question;
                }

                $questions = array_merge($simples, $moderates, $difficults);

                foreach ($questions as $q) {
                    $question = TestQuestion::where(['question_bank_id' => $q->id, 'test_section_id' => $section_id])->first();
                    if ($question)
                        continue;

                    $question = new TestQuestion();
                    $question->question_bank_id = $q->id;
                    $question->test_section_id = $section_id;
                    $question->save();
                }

                return ['title' => 'Compostion Update', 'message' => '(' . count($simples) . ') simple , (' . count($moderates) . ') moderate and (' . count($difficults) . ') difficult question(s) were composed. Please make SURE the questions counts do match the counts specified in the section (' . $section->title . ') definition.'];
            } else {
                return [
                    'title' => 'Test Composition Completed',
                    'message' => '(' . $counts['simple'] . ') simple , (' . $counts['moderate'] . ') moderate and (' . $counts['difficult'] . ') difficult question(s) were already composed as specified in the section (' . $section->title . ') definition'
                ];
            }
        } catch (Exception $e) {
            return [
                'title' => 'Oops!',
                'message' => $e->getMessage()
            ];
        }
    }

    public function removeQuestion($section_id, $bank_id)
    {
        $question = TestQuestion::where(['question_bank_id' => $bank_id, 'test_section_id' => $section_id])->first();
        $question->delete();
    }

    public function previewQuestions($config_id)
    {
        $subjects = $this->registeredSubjects($config_id)->get();
        return view('pages.author.test.config.composition-previews', compact('config_id', 'subjects'));
    }

    public function preview(TestSubject $testSubject)
    {
        return view('pages.author.test.config.composition-preview-questions', compact('testSubject'));
    }

    public function manageUsers(TestConfig $config)
    {
        $config_id = $config->id;
        $compIds = TestCompositor::where('test_config_id', $config_id)
            ->distinct('user_id')
            ->pluck('user_id');

        $invIds = TestInvigilator::where('test_config_id', $config_id)
            ->distinct('user_id')
            ->pluck('user_id');

        $preIds = QuestionPreviewer::where('test_config_id', $config_id)
            ->distinct('user_id')
            ->pluck('user_id');

        $userIds = $compIds->merge($invIds)->unique();
        $userIds = $userIds->merge($preIds)->unique();

        $users = User::select(['id', 'personnel_no as number', 'display_name as name'])
            ->whereIn('id', $userIds)
            ->get();

        $users->load([
            'compositor_subjects' => function ($query) use ($config_id) {
                $query->select(['subjects.subject_code', 'subjects.name'])
                    ->where('test_compositors.test_config_id', $config_id);
            },
            'previewer_subjects' => function ($query) use ($config_id) {
                $query->select(['subjects.subject_code', 'subjects.name'])
                    ->where('question_previewers.test_config_id', $config_id);
            },
            'test_invigilators'
        ]);

        return view('pages.author.test.config.manage-users', compact('config', 'users'));
    }

    public function searchCompositor(Request $request)
    {
        $user = User::where(['personnel_no' => $request->user_number])->first();
        $subjects = TestSubject::with('subject')
            ->select(['subject_id'])
            ->where(['test_config_id' => $request->config_id])
            ->get();

        return view('pages.author.test.config.ajax.compositor', compact('user', 'subjects'));
    }

    public function addCompositor(Request $request)
    {
        try {
            $compositors = [];
            $ids = $request->subjects;
            $user_id = $request->user_id;
            $test_config = $request->test_config_id;

            foreach ($ids as $subject_id) {
                $compositors[] = [
                    'user_id' => $user_id,
                    'test_config_id' => $test_config,
                    'subject_id' => $subject_id
                ];
            }

            if (TestCompositor::upsert($compositors, []))
                return back()->with(['success' => true, 'message' => 'User successfully added as a compositor for the selected subject(s)']);

            return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function removeCompositor($config, $user_id)
    {
        try {
            TestCompositor::where(['test_config_id' => $config, 'user_id' => $user_id])->delete();
            return back()->with(['success' => true, 'message' => 'User successfully removed as a compositor for the selected subject(s)']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function addInvigilator(Request $request)
    {
        try {
            $user = User::where('personnel_no', $request->staff)->first();
            if (isset($user)) {
                $user_id = $user->id;
                $scheduling_id = $request->scheduling_id;
                $test_config_id = $request->test_config_id;
                $invigilator = TestInvigilator::where(['user_id' => $user_id, 'scheduling_id' => $scheduling_id, 'test_config_id' => $test_config_id])->first();
                if (isset($invigilator))
                    return back()->with(['success' => true, 'message' => 'User was already added as an invigilator for this test schedule)']);

                $invigilator[] = [
                    'user_id' => $user_id,
                    'scheduling_id' => $scheduling_id,
                    'test_config_id' => $test_config_id,
                    'pass_key' => $request->pass_key
                ];
                if (TestInvigilator::upsert($invigilator, []))
                    return back()->with(['success' => true, 'message' => 'User successfully added as an invigilator for this test schedule)']);

            }
            return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function removeInvigilator($config_id, $user_id)
    {
        try {
            TestInvigilator::where(['test_config_id' => $config_id, 'user_id' => $user_id])->delete();
            return back()->with(['success' => true, 'message' => 'User successfully removed as an invigilator for this test']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function addPreviewer(Request $request)
    {
        try {
            $previewers = [];
            $ids = $request->subjects;
            $user_id = $request->user_id;
            $test_config = $request->test_config_id;

            foreach ($ids as $subject_id) {
                $previewers[] = [
                    'user_id' => $user_id,
                    'test_config_id' => $test_config,
                    'subject_id' => $subject_id
                ];
            }

            if (QuestionPreviewer::upsert($previewers, []))
                return back()->with(['success' => true, 'message' => 'User successfully added as a questions previewer for the selected subject(s)']);

            return back()->with(['success' => false, 'message' => 'Oops! Look like something went wrong']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function removePreviewer($config, $user_id)
    {
        try {
            QuestionPreviewer::where(['test_config_id' => $config, 'user_id' => $user_id])->delete();
            return back()->with(['success' => true, 'message' => 'User successfully removed as a questions previewer for the selected schedule(s)']);
        } catch (Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function uploadAllCandidates(Request $request){
        $exam_type_id = $request->exam_type_id ?? 1;
        $candidate_papers = [];
        // $schedule_id = $request->schedule_id;
        // $test_config_id = $request->test_config_id;
        // $test = TestConfig::exam()->where('test_configs.id', $test_config_id)->first();
        // $schedule = Scheduling::where('id', $schedule_id)->first();
        // return $test->exam_type_id;
        $file = $request->file;
        $sheets =  Excel::toArray(Upload::class, $file);
        // return $centres;
        $exam_papers = Subject::select('id', 'subject_code as code')->orderBy('subject_code', 'asc')->get()->toArray();
        // $all_candidates = Candidate::select('id', 'index')->get()->toArray();
        $codes = $scheduled_candidates = $candidates = $candidate_ids = $candidate_papers = $uploaded_papers = $errors = [];
        foreach($sheets as $rows) {
            if(empty($rows[0])) // if the sheet doesn't start at row 10 it means the sheet is empty
                continue;
            $title = $rows[0];
            $institution_code = searchIndex($title, 'institution');
            $indexing = searchIndex($title, 'indexing');
            $papers = searchIndex($title, 'paper');
            $cadre = searchIndex($title, 'cadre');
            $remark = searchIndex($title, 'remark');
            // return $title;
            // get unique candidate indexing
            foreach ($rows as $key => $value) {
                if ($key < 1)
                    continue;
                $code = str_replace("'", '', $value[$institution_code]);
                if (!in_array($code, $codes))
                    $codes[] = $code;
                $index_numbers[] = str_replace(' ', '', trim($value[$indexing]));
                $uploaded_papers[] = [
                    'indexing'=>$value[$indexing],
                    'papers'=>trim($value[$papers])
                ];
            }
            
            $index_numbers = array_filter($index_numbers);
            $codes = array_filter($codes);
            $venues = Centre::select('venues.id', 'venues.code','centres.name')
            ->join('venues','venues.centre_id', 'centres.id')
            ->whereIn('centres.code', $codes)
            ->get()->toArray();
            $all_candidates = Candidate::select('candidates.id', 'candidates.indexing')
            ->whereIn('candidates.indexing', $index_numbers)
            ->get()->toArray();
            $all_subjects = Subject::select('id', 'subject_code as code')->get()->toArray();
            $test_codes = TestCode::select('id', 'name')->get()->toArray();
            // $tests = TestConfig::select('id', 'name')->get()->toArray();
            // return $venues;
            // return $test_codes;
            
            // return $codes;
            // get cadres of each centres

            //generate distinct centres for each cadre
            $jchew = $chew = $cho = $bchs = $centre_cadres = [];
            foreach ($rows as $key => $value) {
                if ($key < 1)
                    continue;
                $code = str_replace("'", '', $value[$institution_code]);
                $cad = $value[$cadre];
                if($cad == 'JCHEW'){
                    if (!in_array($code, $jchew))
                        $jchew[] = $code;
                }
                if($cad == 'CHEW'){
                    if (!in_array($code, $chew))
                        $chew[] = $code;
                }
                if($cad == 'CHO'){
                    if (!in_array($code, $cho))
                        $cho[] = $code;
                }
                if($cad == 'BCHS'){
                    if (!in_array($code, $bchs))
                        $bchs[] = $code;
                }
                // return $centre_cadres;
            }
            $centre_cadres = [
                'JCHEW'=>$jchew,
                'CHEW'=>$chew,
                'CHO'=>$cho,
                'BCHS'=>$bchs
            ];

            //creating test schedules for all the institutions
            // return $centre_cadres;
            $new_codes = [];
            $exam_schedules = $schedule_params = $centre_candidates = $centre_candidate_papers = [];
            foreach($centre_cadres as $key=>$centre_cadre){
                $test_code = searchForId($key, $test_codes);
                foreach($centre_cadre as $centre){
                    //get candidates records per centre
                    foreach ($rows as $key => $value) {
                        if ($key < 1)
                            continue;
                        // if($centre_candidates[$code])
                        //     continue;
                        $code = str_replace("'", '', $value[$institution_code]);
                        if($code == $centre){
                            $centre_candidates[$code][] = $value[$indexing];
                        }
                    }
                    
                    // $test_configs = TestConfig::
                    // select('exams_dates.date as date', 'test_configs.id')
                    // ->join('exams_dates','exams_dates.test_config_id', 'test_configs.id')
                    // ->where('test_code_id', $test_code->id)->get();
                    // $venue = searchForId($centre, $venues);
                    // // return $test_configs;
                    // foreach($test_configs as $config){
                    //     $exam_schedules[] = [
                    //         'test_config_id'=>$config->id,
                    //         'venue_id'=>$venue->id,
                    //         'date'=> $config->date,
                    //         'maximum_batch'=>4,
                    //         'no_per_schedule'=>250,
                    //         'daily_start_time'=>'08:00',
                    //         'daily_end_time'=>'20:00',
                    //     ];
                    // }
                }
            }
            
        
            
            // $exam_schedules = removeDuplicates($exam_schedules);
            
            $err = [];
            // foreach(array_chunk($exam_schedules, 500) as $key => $exam_schedule) {
            //     if(!Scheduling::upsert($exam_schedule, ['test_config_id', 'venue_id','date'])) {
            //         reset_auto_increment('schedulings');
            //         $err[] = 'Something went wrong. [Scheduling upload] '.$key;
            //     }
            // }

            // return $exam_schedules;
            foreach($centre_candidates as $k=>$centre_candidate){
                $p1 = $p2 = $p3 = $pe = [];
                $centre_candidates[$k] = array_unique($centre_candidate);
                foreach($centre_candidates[$k] as $candidate){
                    $pp = searchForId($candidate, $uploaded_papers);
                    $all_papers = array_flip(explode(',', $pp->papers));
                    // if(in_array('PA',$all_papers))
                    //     unset($all_papers[array_search('PA', $all_papers)]);
                    if(isset($all_papers['P1'])) $p1[] = $candidate;
                    if(isset($all_papers['P2'])) $p2[] = $candidate;
                    if(isset($all_papers['P3'])) $p3[] = $candidate;
                    if(isset($all_papers['PE'])) $pe[] = $candidate;
                }
                $centre_candidate_papers[$k][] = [
                    'P1' => $p1,
                    'P2' => $p2,
                    'P3' => $p3,
                    'PE' => $pe,
                ];
            }

            // $centre_candidate_papers = array_filter($centre_candidate_papers);
            // return $centre_candidate_papers;
            // uploading the schedules
            

            if(count($err) == 0){
                reset_auto_increment('schedulings');
                $get_schedules = Scheduling::
                select('schedulings.id', 'schedulings.test_config_id', 'venue_id', 'schedulings.date','subjects.subject_code as code', 'test_subjects.id as test_subject_id','test_subjects.subject_id')
                ->join('test_configs', 'test_configs.id', 'schedulings.test_config_id')
                ->join('test_subjects', 'test_subjects.test_config_id', 'test_configs.id')
                ->join('subjects', 'subjects.id', 'test_subjects.subject_id')
                ->get()->toArray();
                // return $get_schedules;
                // return $centre_candidate_papers;
                ini_set('memory_limit', '256M');
                foreach($centre_candidate_papers as $code=>$centre_candidate_paper){
                    $v = searchForId($code, $venues);
                    if(!$v) // skip if center not available.
                        continue;
                    foreach($centre_candidate_paper as $candidate_paper){
                        foreach($candidate_paper as $p=>$paper){
                            $s = searchForId($p, $all_subjects);
                            foreach($paper as $indexing){
                                $candidate = SearchForId($indexing, $all_candidates);
                                if(!$candidate)
                                    continue;
                                $test_subject_id = 15;
                                $search_items = ['subject_id'=>$s->id,'test_subject_id'=>$test_subject_id, "venue_id" => $v->id];
                                $filtered_schedules = search_multiple_param($search_items, $get_schedules);
                                // return $filtered_schedules;
                                foreach($filtered_schedules as $schedule){
                                    $schedule_ids[]=$schedule->id;
                                    $candidate_ids[]=$candidate->id;
                                    $scheduled_candidates[] = [
                                        'exam_type_id' => $exam_type_id,
                                        'schedule_id' => $schedule->id,
                                        'candidate_id' => $candidate->id,
                                    ];
                                    $candidate_subjects[] = [
                                        'schedule_id'=>$schedule->id,
                                        'subject_id' => $s->id,
                                        'candidate_id'=> $candidate->id,
                                        'test_subject_id'=> $test_subject_id,
                                        'exam_type_id'=>$exam_type_id
                                    ];
                                }
                            }
                        }
                    }
                }

                $scheduled_candidates = removeDuplicatesCandidateSchedule($scheduled_candidates);
                foreach(array_chunk($scheduled_candidates, 500) as $key => $scheduled_candidate) {
                    if(!ScheduledCandidate::upsert($scheduled_candidate, ['schedule_id','candidate_id', 'exam_type_id'])) {
                        reset_auto_increment('scheduled_candidates');
                        $err[] = 'Something went wrong. [Scheduled candidates chunk upload] '.$key;
                    }
                }

                // return $scheduled_candidates;
                $all_scheduled_candidates = ScheduledCandidate::
                select('id', 'schedule_id', 'candidate_id')
                ->get()->toArray();
                //preparing the candidate_subjects
                $candidate_subject_array = [];
                foreach($candidate_subjects as $candidate_subject){
                    $array = [
                        'schedule_id'=>$candidate_subject['schedule_id'],
                         'candidate_id'=>$candidate_subject['candidate_id']
                    ];
                    $schedule_candy = ScheduledCandidate::where([
                        'schedule_id'=>$candidate_subject['schedule_id'],
                        'candidate_id'=>$candidate_subject['candidate_id']
                    ])->first();

                    $candidate_papers[] = [
                        'schedule_id'=>$candidate_subject['schedule_id'],
                        'scheduled_candidate_id' => $schedule_candy->id,
                        'subject_id' => $candidate_subject['subject_id'],
                        'add_index'=>null,
                        'enabled'=>1
                    ];
                }

                foreach(array_chunk($candidate_papers, 500) as $key => $candidate_paper) {
                    if(!CandidateSubject::upsert($candidate_paper, ['schedule_id', 'scheduled_candidate_id','subject_id'])) {
                        reset_auto_increment('candidate_subjects');
                        $err[] = 'Something went wrong. [Graduands chunk upload]';
                    }
                }

                return $candidate_papers;



                // return $candidate_subjects;
                return $all_scheduled_candidates;

                return $scheduled_candidates;

                // return $centre_candidate_paper;
                foreach($get_schedules as $get_schedule){
                    $p =  explode(',',$uploaded_papers[$get_schedule->candidate_id]);
                    foreach($p as $exam_paper){
                        if(!$ep = searchForId($exam_paper, $exam_papers))
                            continue;
                        $candidate_papers[] = [
                            'schedule_id'=>$schedule->id,
                            'scheduled_candidate_id' => $get_schedule->id,
                            'subject_id' => $ep->id,
                            'add_index'=>null,
                            'enabled'=>1
                        ];
                    }
    
                }
                // return $candidate_papers;
                //                return $graduand_papers;
                $err = [];
                
                if(count($err) == 0){
                    reset_auto_increment('scheduled_candidates');
                }else{
                    $errors[] = 'Something went wrong while updating papers records for candidates.';
                }
            }else {
                $errors[] = 'Something went wrong while inserting candidate records.';
            }
            
            

            // preparing for candidate schedules
            foreach($centre_candidates as $c=>$centre_candidate){
                foreach($centre_candidate as $candidate){
                    $cdd = searchForId($candidate, $all_candidates);
                    $pp = searchForId($candidate, $uploaded_papers);
                    $scheduled_candidates[] = [
                        'exam_type_id' => $exam_type_id,
                        'schedule_id' => 1,
                        'candidate_id' => $cdd->id,
                    ];
                }
                
            }

            return $scheduled_candidates;
            
            foreach ($rows as $key => $value) {
                if ($key < 1) // skip first row which is considered a title row for the uploaded Excel file.
                    continue;
                if(empty($value[$indexing]))
                    continue;
                $cdd = searchForId($value[$indexing], $all_candidates);
                $pp = searchForId($value[$indexing], $uploaded_papers);
                
                if (!$cdd) //skip if institution code is not found in the institution table
                    continue;
                return $cdd;
                $candidate_ids[] = $cdd->id;
                $uploaded_papers[trim($cdd->id)] = trim($value[$papers]);
                $scheduled_candidates[] = [
                    'exam_type_id' => $test->exam_type_id,
                    'schedule_id' => $schedule->id,
                    'candidate_id' => $cdd->id,
                ];

            }

            

        }

        // return $candidate_papers;
        
        DB::beginTransaction();
        $err = [];
        foreach(array_chunk($scheduled_candidates, 500) as $key => $scheduled_candidate) {
            if(!ScheduledCandidate::upsert($scheduled_candidate, ['candidate_id', 'exam_type_id'])) {
                reset_auto_increment('scheduled_candidates');
                $err[] = 'Something went wrong. [Scheduled candidates chunk upload] '.$key;
            }
        }

        if(count($err) == 0){
            reset_auto_increment('scheduled_candidates');
            $get_schedules = ScheduledCandidate::whereIn('candidate_id', $candidate_ids)->where(['schedule_id'=> $schedule->id])->get();
            
            foreach($get_schedules as $get_schedule){
                $p =  explode(',',$uploaded_papers[$get_schedule->candidate_id]);
                foreach($p as $exam_paper){
                    if(!$ep = searchForId($exam_paper, $exam_papers))
                        continue;
                    $candidate_papers[] = [
                        'schedule_id'=>$schedule->id,
                        'scheduled_candidate_id' => $get_schedule->id,
                        'subject_id' => $ep->id,
                        'add_index'=>null,
                        'enabled'=>1
                    ];
                }

            }
            // return $candidate_papers;
            //                return $graduand_papers;
            $err = [];
            foreach(array_chunk($candidate_papers, 500) as $key => $candidate_paper) {
                if(!CandidateSubject::upsert($candidate_paper, ['subject_id', 'scheduled_candidate_id','subject_id'])) {
                    reset_auto_increment('candidate_subjects');
                    $err[] = 'Something went wrong. [Graduands chunk upload]';
                }
            }
            if(count($err) == 0){
                reset_auto_increment('scheduled_candidates');
            }else{
                $errors[] = 'Something went wrong while updating papers records for candidates.';
            }
        }else {
            $errors[] = 'Something went wrong while inserting candidate records.';
        }
        $success = count($scheduled_candidates);
        $scheduled = $success;
        $missing = [];
        
        if(empty($errors)){
            // DB::commit();
            return view('pages.author.test.config.upload-report', compact('success', 'scheduled', 'missing'));
        }else{
            // DB::rollback();
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    
}

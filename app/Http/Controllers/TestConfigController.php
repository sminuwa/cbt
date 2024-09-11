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
use App\Models\User;
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
                
        return view('pages.author.test.config.index', compact('configs'));
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
    //    public function uploadSingle(Request $request)
//    {
//        try {
//            $schedule_id = $request->schedule_id;
//            $candidates = Candidate::select(['id', 'indexing'])->whereIn('indexing', '873r')->get();
//            $subjects = TestSubject::where(['test_config_id' => $request->test_config_id])->pluck('subject_id');
//            $schedules = CandidateSubject::where(['schedule_id' => $schedule_id])
//                ->whereIn('scheduled_candidate_id', $candidates->pluck('id')->toArray())
//                ->whereIn('subject_id', $subjects)
//                ->get();
//
//            if (count($schedules))
//                return back()->with(['success' => false, 'message' => 'Oops! Candidate(s) with this number: '
//                    . $request->candidate_number . ' was already scheduled for this test']);
//
//            if (count($candidates) == 0)
//                return back()->with(['success' => false, 'message' => 'Oops! Candidate(s) record(s) not found!']);
//
//            $records = [];
//            $scheduled = [];
//            $exam_type_id = Subject::find($subjects[0])->exam_type_id;
//
//            foreach ($candidates as $candidate) {
//                foreach ($subjects as $subject_id) {
//                    $records[] = [
//                        'scheduled_candidate_id' => $candidate->id,
//                        'schedule_id' => $request->schedule_id,
//                        'subject_id' => $subject_id
//                    ];
//                }
//            }
//            CandidateSubject::upsert($records, ['scheduled_candidate_id', 'schedule_id', 'subject_id']);
//
//            return $this->updateBatches($schedule_id);
//        } catch (Exception $e) {
//            return back()->with(['success' => false, 'message' => $e->getMessage()]);
//        }
//    }
    public function bulkUpload(Request $request)
    {
//         $candidate_papers = [];
//         $schedule_id = $request->schedule_id;
//         $test_config_id = $request->test_config_id;

//         $file = $request->file;
//         /*if(!$this->fileUploaded($file, time().'.xlsx'))
//             return jResponse(false, 'File can not be uploaded to the disk.');*/
//         // $rows = $this->getRecordFromExcel(Upload::class, $file);
// //        return $rows;
//         $sheets =  Excel::toArray(\App\Models\Upload::class, $file);
        

// //        $rows = Excel::toArray(new Upload::class, $file)[0];
//         $codes = $candidates = $indexings = $indexes = $graduands = $graduand_papers = $uploaded_papers = $errors = [];
//         foreach($sheets as $rows) {
//             if(empty($rows[0])) // if the sheet doesn't start at row 10 it means the sheet is empty
//                 continue;
//             $title = $rows[0];
//             $indexing = searchIndex($title, 'indexing');
//             $papers = searchIndex($title, 'paper');
            
//             // get unique candidate indexing
//             foreach ($rows as $key => $value) {
//                 if ($key < 1)
//                     continue;
//                 $index_numbers[] = str_replace(' ', '', trim($value[$indexing]));
//             }

//             $index_numbers = array_filter($index_numbers);
//             $candidates = Candidate::select('candidates.id', 'candidates.indexing')
//             ->whereIn('candidates.indexing', $index_numbers)
//             ->get()->toArray();
            
            
//             foreach ($rows as $key => $value) {
//                 if ($key < 1) // skip first row which is considered a title row for the uploaded Excel file.
//                     continue;
//                 if(empty($value[$indexing]))
//                     continue;
                
//                 $candidate = searchForId($value[$indexing], $institutions);
//                 if (!$candidate) //skip if institution code is not found in the institution table
//                     continue;

        
//                 $candidates[] = [
//                     'institution_id' => $inst->id,
//                     'number' => $number,
//                     'indexing' => trim($value[$indexing]),
//                     'surname' => trim($value[$surname]),
//                     'firstname' => trim($value[$firstname]),
//                     'othernames' => (trim($value[$othernames]) ?? null),
//                     'gender' => (trim($value[$gender]) == 'F' ? 'Female' : 'Male'),
//                     'cadre_id' => $cadre->id,
//                     'year' => $year,
//                     'type' => empty($value[$type]) ? 'fresh' : 'retrainee',
//                     'status' => STATUS_INDEXED,
//                 ];

//             }

//             return $candidates;

//         }


//         DB::beginTransaction();
//         $err = [];
//         foreach(array_chunk($candidates, 1000) as $key => $smallerArray) {
//             if(!Candidate::upsert($smallerArray, ['indexing'])) {
//                 reset_auto_increment('candidates');
//                 $err[] = 'Something went wrong. [Candidate chunk upload] '.$key;
//             }
//         }

//         if(empty($errors)){
//             DB::commit();
//             return jResponse(
//                 true,
//                 'Indexing backlog has been uploaded successfully'
//             );
//         }else{
//             DB::rollback();
//             return back()->with(['success' => false, 'message' => $e->getMessage()]);
//         }










        try {
            $candidate_papers = [];
            $schedule_id = $request->schedule_id;
            $test_config_id = $request->test_config_id;
            if (isset($request->file)) {
                //  $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
                $file = $request->file;
                $rows = $this->getRecordFromExcel(Upload::class, $file);
                array_shift($rows);


                $tmp = array_column($rows, 1);
                $rows = array_column($rows, 0);

                $i = 0;
                foreach ($rows as $row)
                    $candidate_papers[$row] = explode(',', $tmp[$i++]);

            } else {
                $rows = explode(',', $request->candidate_number);
            }

            $candidates = Candidate::select(['id', 'indexing'])->whereIn('indexing', $rows)->get();
            $numbers = $candidates->pluck('indexing')->toArray();

            

            $missing = array_values(array_diff($rows, $numbers));

            $papers = [];
            $pps = Subject::select(['id', 'subject_code as code'])->get();
            foreach ($pps as $p) {
                $papers[$p->code] = $p->id;
            }


            $subjects = TestSubject::where(['test_config_id' => $test_config_id])->pluck('subject_id');

            $schedules = CandidateSubject::with('candidate')->where(['schedule_id' => $schedule_id])
                ->whereIn('scheduled_candidate_id', $candidates->pluck('id')->toArray())
                ->whereIn('subject_id', $subjects)
                ->delete();
            // ->get();

            // $size = count($candidates);
            // if ($size != 0 && $size == count($schedules) / count($subjects))
            //     return back()->with(['success' => false, 'message' => 'Oops! All of the candidates were already scheduled for this test']);
            // else {
            $scheduled_ids = [];
            // foreach ($schedules as $schedule) {
            //     if ($schedule->subject_id == $subjects[0]) {
            //         $scheduled_ids[] = $schedule->candidate->id;
            //     }
            // }

            $scheduled = count($scheduled_ids);
            $tmp = array_values(array_diff($candidates->toArray(), $scheduled_ids));
            $candidates = $tmp;
            // }

            foreach ($candidates as $k => $candidate) {
                foreach ($candidate_papers as $key => $value) {
                    if ($key == $candidate['indexing']) {
                        $paper_ids = [];
                        foreach ($papers as $i => $v)
                            if (in_array($i, $value))
                                $paper_ids[] = $v;

                        $candidates[$k]['papers'] = $paper_ids;
                    }
                }
            }

            $chunks = array_chunk($candidates, 1000);

            $scs = [];
            $records = [];
            $exam_type_id = Subject::find($subjects[0])->exam_type_id;

            foreach ($chunks as $chunk) {
                foreach ($chunk as $candidate) {
                    $scs[] = [
                        'exam_type_id' => $exam_type_id,
                        'candidate_id' => $candidate['id'],
                        //                        'reg_number' => $candidate['indexing'],
                    ];
                    ScheduledCandidate::upsert($scs, ['candidate_id', 'exam_type_id']);
                    foreach ($subjects as $subject_id) {
                        if (in_array($subject_id, $candidate['papers']))
                            $records[] = [
                                'scheduled_candidate_id' => ScheduledCandidate::where('candidate_id',$candidate['id'])->first()->id,
                                'schedule_id' => $schedule_id,
                                'subject_id' => $subject_id,
                                'enabled' => 1
                            ];
                    }
                    
                }
                CandidateSubject::upsert($records, ['scheduled_candidate_id', 'schedule_id', 'subject_id'], ['scheduled_candidate_id', 'schedule_id', 'subject_id']);
                
                
                $records = [];
            }

            $success = count($candidates);

            $this->updateBatches($schedule_id);

            return view('pages.author.test.config.upload-report', compact('success', 'scheduled', 'missing'));
        } catch (Exception $e) {
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
}

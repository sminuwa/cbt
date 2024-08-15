<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAnswerOption;
use App\Models\AdminCandidate;
use App\Models\AdminCandidateSubject;
use App\Models\AdminCentre;
use App\Models\AdminExamType;
use App\Models\AdminQuestionBank;
use App\Models\AdminScheduledCandidate;
use App\Models\AdminSubject;
use App\Models\AdminTestCode;
use App\Models\AdminTestCompositor;
use App\Models\AdminTestConfig;
use App\Models\AdminTestInvigilator;
use App\Models\AdminTestQuestion;
use App\Models\AdminTestSection;
use App\Models\AdminTestSubject;
use App\Models\AdminTestType;
use App\Models\AdminUser;
use App\Models\AdminVenue;
use App\Models\PullStatus;
use App\Services\BackupAndTruncateService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use ZipArchive;

class SetupController extends Controller
{
    //
    protected $backupService;

    public function __construct(BackupAndTruncateService $backupService)
    {
        $this->backupService = $backupService;
    }

    public function index(Request $request)
    {
        $statuses = PullStatus::whereDate('pull_date','=',today())->get();//basic-data
        $results = $statuses->pluck('id', 'resource')->map(function ($id, $resource) {
            return true;
        })->toArray();
        return view("pages.admin.setup.index",compact('results'));
    }

    public function pullBasicResource(Request $request)
    {
        $tables = ['admin_exam_types', 'admin_test_types', 'admin_centres','admin_venues']; // Replace with your table names
        $this->backupService->backupAndTruncate($tables);
        $apiUrl = $this->apiUrl('resource/basic');

        // Define headers if necessary
        $headers = [
            'Authorization' => 'Bearer your-token-here',
            'Accept' => 'application/json',
            'Custom-Header' => 'custom-value'
        ];

        // Fetch data from the API
        $response = $this->post($apiUrl, [], $headers);

//        return $response['status'];
        if ($response['status']==1) {
            // Get the data from the response
            $data = $response['data'];

            foreach ($data['centres'] as &$centre) {
                $centre['created_at'] = Carbon::parse($centre['created_at'])->format('Y-m-d H:i:s');
                $centre['updated_at'] = Carbon::parse($centre['updated_at'])->format('Y-m-d H:i:s');
            }

            foreach ($data['test_codes'] as &$centre) {
                $centre['created_at'] = Carbon::parse($centre['created_at'])->format('Y-m-d H:i:s');
                $centre['updated_at'] = Carbon::parse($centre['updated_at'])->format('Y-m-d H:i:s');
            }

            foreach ($data['exam_types'] as &$examType) {
                $examType['created_at'] = Carbon::parse($examType['created_at'])->format('Y-m-d H:i:s');
                $examType['updated_at'] = Carbon::parse($examType['updated_at'])->format('Y-m-d H:i:s');
            }

            foreach ($data['test_types'] as &$testType) {
                $testType['created_at'] = Carbon::parse($testType['created_at'])->format('Y-m-d H:i:s');
                $testType['updated_at'] = Carbon::parse($testType['updated_at'])->format('Y-m-d H:i:s');
            }

            foreach ($data['venues'] as &$testType) {
                $testType['created_at'] = Carbon::parse($testType['created_at'])->format('Y-m-d H:i:s');
                $testType['updated_at'] = Carbon::parse($testType['updated_at'])->format('Y-m-d H:i:s');
            }
            // Start a transaction

            try {


                DB::transaction(function () use ($data) {

                    AdminCentre::query()->delete();
                    AdminExamType::query()->delete();
                    AdminTestType::query()->delete();
                    AdminVenue::query()->delete();
                    AdminTestCode::query()->delete();
                    // Insert new data
                    AdminCentre::insert($data['centres']);
                    AdminExamType::insert($data['exam_types']);
                    AdminTestType::insert($data['test_types']);
                    AdminVenue::insert($data['venues']);
                    AdminTestCode::insert($data['test_codes']);
                    // Log the pull
                    PullStatus::create([
                        'resource' => 'basic-data',
                        'pull_date' => now(),
                        'status' => 'SUCCESS',
                        'message' => 'Data pulled and inserted successfully'
                    ]);
                    // Commit the transaction
                });

                return response()->json(['success' => true, 'message' => 'Data pulled and inserted successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to pull and insert data', 'error' => $e->getMessage()], 200);
            }
        } else {
            // Log the failure
            PullStatus::create([
                'resource' => 'basic-data',
                'pull_date' => now()->toDateString(),
                'status' => 'FAILURE',
                'message' => 'Failed to fetch data from API'
            ]);

            return response()->json(['success' => false, 'message' => 'Failed to fetch data from API'], 200);
        }

    }

    public function pullTestResource(Request $request)
    {
        $tables = ['admin_exam_types', 'admin_test_types', 'admin_centres','admin_venues']; // Replace with your table names
        $this->backupService->backupAndTruncate($tables);
        $apiUrl = $this->apiUrl('resource/test');

        // Define headers if necessary
        $headers = [
            'Accept' => 'application/json',
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];

        // Fetch data from the API
        $response = $this->post($apiUrl, [], $headers);

//        return $response['status'];
        if ($response['status']==1) {
            // Get the data from the response
            $data = $response['data']['data'];
            $indexes = [
                'schedules','test_configs','test_compositors','users',
                'test_subjects','subjects','test_sections','test_questions',
                'question_banks','exams_dates','answer_options'
            ];

            foreach ($indexes as $index){
                foreach ($data[$index] as &$obj) {
                    $obj['created_at'] = Carbon::parse($obj['created_at'])->format('Y-m-d H:i:s');
                    $obj['updated_at'] = Carbon::parse($obj['updated_at'])->format('Y-m-d H:i:s');
                    if(isset($obj['date'])){
                        $obj['date'] = Carbon::parse($obj['date'])->format('Y-m-d H:i:s');
                    }
                    if(isset($obj['date_initiated'])){
                        $obj['date_initiated'] = Carbon::parse($obj['date_initiated'])->format('Y-m-d H:i:s');
                    }
                }
            }
//            return $data;

            // Start a transaction

            try {


                DB::transaction(function () use ($data) {

                    AdminCandidate::query()->delete();
                    AdminCandidateSubject::query()->delete();
                    AdminScheduledCandidate::query()->delete();
                    AdminSubject::query()->delete();
                    AdminTestCompositor::query()->delete();
                    AdminTestConfig::query()->delete();
                    AdminTestInvigilator::query()->delete();
                    AdminTestQuestion::query()->delete();
                    AdminTestSection::query()->delete();
                    AdminTestSubject::query()->delete();
                    AdminAnswerOption::query()->delete();
                    AdminUser::where('id','>',4)->delete();
                    AdminCandidateSubject::query()->delete();
                    AdminQuestionBank::query()->delete();
                    // Insert new data

//                    AdminCandidate::insert($data['']);
//                    AdminCandidateSubject::insert($data['']);
//                    AdminScheduledCandidate::insert($data['']);
                    AdminAnswerOption::insert($data['answer_options']);
                    AdminSubject::insert($data['subjects']);
                    AdminTestCompositor::insert($data['test_compositors']);
                    AdminTestConfig::insert($data['test_configs']);
                    AdminTestInvigilator::insert($data['test_invigilators']);
                    AdminTestQuestion::insert($data['test_questions']);
                    AdminTestSection::insert($data['test_sections']);
                    AdminTestSubject::insert($data['test_subjects']);
                    AdminUser::insert($data['users']);
                    AdminQuestionBank::insert($data['question_banks']);
                    // Log the pull
                    PullStatus::create([
                        'resource' => 'test-data',
                        'pull_date' => now(),
                        'status' => 'SUCCESS',
                        'message' => 'Data pulled and inserted successfully'
                    ]);
                    // Commit the transaction
                });

                return response()->json(['success' => true, 'message' => 'Data pulled and inserted successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to pull and insert data', 'error' => $e->getMessage()], 200);
            }
        } else {
            // Log the failure

            return response()->json(['success' => false, 'message' => 'Failed to fetch data from API'], 200);
        }

    }

    public function pullCandidateResource(Request $request) {
        $tables = ['admin_candidates', 'admin_candidate_subjects']; // Replace with your table names
        $this->backupService->backupAndTruncate($tables);
        $apiUrl = $this->apiUrl('resource/candidate');

        // Define headers if necessary
        $headers = [
            'Accept' => 'application/json',
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];

        // Fetch data from the API
        $response = $this->post($apiUrl, [], $headers);

//        return $response['status'];
        if ($response['status']==1) {
            // Get the data from the response
            $data = $response['data']['data'];
            $indexes = [
                'candidates','candidate_subjects','scheduled_candidates'
            ];

            foreach ($indexes as $index){
                foreach ($data[$index] as &$obj) {
                    $obj['created_at'] = null;//Carbon::parse($obj['created_at'])->format('Y-m-d H:i:s');
                    $obj['updated_at'] = null;//Carbon::parse($obj['updated_at'])->format('Y-m-d H:i:s');
                    if(isset($obj['date'])){
                        $obj['date'] = Carbon::parse($obj['date'])->format('Y-m-d H:i:s');
                    }
                    if(isset($obj['date_initiated'])){
                        $obj['date_initiated'] = Carbon::parse($obj['date_initiated'])->format('Y-m-d H:i:s');
                    }
                }
            }
//            return $data;

            // Start a transaction

            try {


                DB::transaction(function () use ($data) {

                    AdminCandidate::query()->delete();
                    AdminCandidateSubject::query()->delete();
                    AdminScheduledCandidate::query()->delete();
                    // Insert new data

                    AdminCandidate::insert($data['candidates']);
                    AdminCandidateSubject::insert($data['candidate_subjects']);
                    AdminScheduledCandidate::insert($data['scheduled_candidates']);
                    // Log the pull
                    PullStatus::create([
                        'resource' => 'candidate-data',
                        'pull_date' => now(),
                        'status' => 'SUCCESS',
                        'message' => 'Data pulled and inserted successfully'
                    ]);
                    // Commit the transaction
                });

                return response()->json(['success' => true, 'message' => 'Data pulled and inserted successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to pull and insert data', 'error' => $e->getMessage()], 200);
            }
        } else {
            // Log the failure

            return response()->json(['success' => false, 'message' => 'Failed to fetch data from API'], 200);
        }

    }
    public function pullCandidatePictures(Request $request)
    {
//        $tables = ['admin_candidates', 'admin_candidate_subjects']; // Replace with your table names
//        $this->backupService->backupAndTruncate($tables);
        $apiUrl = $this->apiUrl('resource/candidate/picture');

        // Define headers if necessary
        $headers = [
            'Accept' => 'application/json',
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];

        // Fetch data from the API
        $response = Http::withHeaders($headers)->post($apiUrl, []);

//        return $response['status'];
        if ($response->successful()) {
            $zipFilePath = public_path('user_images.zip');
            file_put_contents($zipFilePath, $response->body());

            $zip = new ZipArchive;
            if ($zip->open($zipFilePath) === TRUE) {
                $zip->extractTo(public_path(candidate_passport_path()));
                $zip->close();
                unlink($zipFilePath); // Delete the zip file after extraction
                PullStatus::create([
                    'resource' => 'candidate-pictures',
                    'pull_date' => now(),
                    'status' => 'SUCCESS',
                    'message' => 'Data pulled and inserted successfully'
                ]);
                return response()->json(['success' => true, 'message' => 'Download Successful'], 200);
            }
            return response()->json(['success' => false, 'message' => 'Invalid Download File'], 200);
        } else {
            // Log the failure

            return response()->json(['success' => false, 'message' => 'Failed to fetch data from API'], 200);
        }

    }

    private function post($url, $postData, $headers = [])
    {

        $response = Http::withHeaders($headers)->post($url, $postData);

        // Check if the request was successful
        if ($response->successful()) {
            // Get the response body
            $data = $response->json();
            // Return the data or process it as needed
            return ['status' => 1, 'data' => $data];
        } else {
            // Handle the error
            return ['status' => 0, 'error' => 'Failed to post data to API'];
        }
    }

    private function apiUrl($url){
        return env("CHPRBN_SERV_ADDR").$url;
    }
}

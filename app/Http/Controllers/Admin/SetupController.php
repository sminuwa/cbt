<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminCentre;
use App\Models\AdminExamType;
use App\Models\AdminTestCode;
use App\Models\AdminTestType;
use App\Models\AdminVenue;
use App\Models\PullStatus;
use App\Services\BackupAndTruncateService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

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
            'api_key'=>config("user_data.api_key"),
            'secret_key'=>config("user_data.secret_key")
        ];

        // Fetch data from the API
        $response = $this->post($apiUrl, [], $headers);

//        return $response['status'];
        if ($response['status']==1) {
            // Get the data from the response
            $data = $response['data'];
            $indexes = [
                'schedules','test_configs','test_compositors','users',
                'test_subjects','subjects','test_sections','test_questions',
                'question_banks','exams_dates'
            ];

            foreach ($indexes as $index){
                foreach ($data[$index] as &$obj) {
                    $obj['created_at'] = Carbon::parse($obj['created_at'])->format('Y-m-d H:i:s');
                    $obj['updated_at'] = Carbon::parse($obj['updated_at'])->format('Y-m-d H:i:s');
                }
            }

            // Start a transaction

            try {


                DB::transaction(function () use ($data) {

                    AdminCentre::query()->delete();
                    AdminExamType::query()->delete();
                    AdminTestType::query()->delete();
                    AdminVenue::query()->delete();
                    // Insert new data
                    AdminCentre::insert($data['centres']);
                    AdminExamType::insert($data['exam_types']);
                    AdminTestType::insert($data['test_types']);
                    AdminVenue::insert($data['venues']);
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
        return config('user_data.server_address').$url;
    }
}

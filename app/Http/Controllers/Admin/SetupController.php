<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnswerOption;
use App\Models\Candidate;
use App\Models\CandidateSubject;
use App\Models\Centre;
use App\Models\ExamType;
use App\Models\QuestionBank;
use App\Models\ScheduledCandidate;
use App\Models\Scheduling;
use App\Models\Subject;
use App\Models\TestCode;
use App\Models\TestCompositor;
use App\Models\TestConfig;
use App\Models\TestInvigilator;
use App\Models\TestQuestion;
use App\Models\TestSection;
use App\Models\TestSubject;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\TestType;
use App\Models\User;
use App\Models\Venue;
use App\Models\Role;
use App\Models\Topic;
use App\Models\UserRole;
use App\Models\TimeControl;
use App\Models\Presentation;
use App\Models\Score;
use App\Models\PullStatus;
use App\Services\BackupAndTruncateService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use ZipArchive;

class SetupController extends Controller
{
    //
    protected $backupService;

    public function __construct(BackupAndTruncateService $backupService)
    {
        $this->backupService = $backupService;
        $this->middleware("auth:admin");
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
        
        $tables = ['exam_types', 'test_types','test_codes', 'topics','centres','venues']; // Replace with your table names
        $this->backupService->backupAndTruncate($tables);
        $apiUrl = $this->apiUrl('resource/basic');

        // return $apiUrl;
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

            // foreach ($data['topics'] as &$testType) {
            //     $testType['created_at'] = Carbon::parse($testType['created_at'])->format('Y-m-d H:i:s');
            //     $testType['updated_at'] = Carbon::parse($testType['updated_at'])->format('Y-m-d H:i:s');
            // }
            // Start a transaction

            try {


                DB::transaction(function () use ($data) {

                    Centre::query()->delete();
                    ExamType::query()->delete();
                    TestType::query()->delete();
                    Venue::query()->delete();
                    TestCode::query()->delete();
                    Topic::query()->delete();
                    // Insert new data
                    Centre::insert($data['centres']);
                    ExamType::insert($data['exam_types']);
                    TestType::insert($data['test_types']);
                    Venue::insert($data['venues']);
                    TestCode::insert($data['test_codes']);
                    Topic::insert($data['topics']);
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
        // return $request;
        // return env("CHPRBN_CBT_API_KEY");
        $tables = ['exam_types', 'test_types', 'centres','venues']; // Replace with your table names
        $this->backupService->backupAndTruncate($tables);
        $apiUrl = $this->apiUrl('resource/test');

        // Define headers if necessary
        $headers = [
            'Accept' => 'application/json',
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];

        $body = [
            'api_key'=>env("CHPRBN_CBT_API_KEY",'ichtk149'),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY",'149ichtk')
        ];

        // return $body;
        // Fetch data from the API
        $response = $this->post($apiUrl, $body, $headers);
        // return $response;

        // return $response;
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

                    Candidate::query()->delete();
                    CandidateSubject::query()->delete();
                    Scheduling::query()->delete();
                    ScheduledCandidate::query()->delete();
                    Subject::query()->delete();
                    TestCompositor::query()->delete();
                    TestConfig::query()->delete();
                    TestInvigilator::query()->delete();
                    TestQuestion::query()->delete();
                    TestSection::query()->delete();
                    TestSubject::query()->delete();
                    AnswerOption::query()->delete();
                    User::where('id','>',4)->delete();
                    CandidateSubject::query()->delete();
                    QuestionBank::query()->delete();
                    // Insert new data

//                    AdminCandidate::insert($data['']);
//                    AdminCandidateSubject::insert($data['']);
//                    AdminScheduledCandidate::insert($data['']);
                    AnswerOption::insert($data['answer_options']);
                    Scheduling::insert($data['schedules']);
                    Subject::insert($data['subjects']);
                    TestCompositor::insert($data['test_compositors']);
                    TestConfig::insert($data['test_configs']);
                    TestInvigilator::insert($data['test_invigilators']);
                    TestQuestion::insert($data['test_questions']);
                    TestSection::insert($data['test_sections']);
                    TestSubject::insert($data['test_subjects']);
                    User::insert($data['users']);
                    QuestionBank::insert($data['question_banks']);
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
        $tables = ['candidates', 'candidate_subjects', 'scheduled_candidates']; // Replace with your table names
        $this->backupService->backupAndTruncate($tables);
        $apiUrl = $this->apiUrl('resource/candidate');

        // Define headers if necessary
        $headers = [
            'Accept' => 'application/json',
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];

        $body = [
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];

        // Fetch data from the API
        $response = $this->post($apiUrl, $body, $headers);

        // return $response;
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

                    Candidate::query()->delete();
                    CandidateSubject::query()->delete();
                    ScheduledCandidate::query()->delete();
                    // Insert new data

                    Candidate::insert($data['candidates']);
                    // CandidateSubject::insert($data['candidate_subjects']);
                    foreach(array_chunk($data['candidate_subjects'], 500) as  $smallerArray) {
                        // return $smallerArray;
                         CandidateSubject::insert($smallerArray);
                    }
                    ScheduledCandidate::insert($data['scheduled_candidates']);
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

        // return 'hello';
        // $year = date('Y');
        // $candidate_pictures = Candidate::candidateWithoutPassport($year);
        // $candidate_ids = $candidate_pictures['candidate_ids'];
        
        // // $candidate_ids = array_slice($candidate_ids, 0, 10, true);
        // $headers = [
        //     'Authorization' => 'Bearer your-token-here',
        //     'Accept' => 'application/json',
        //     'Custom-Header' => 'custom-value'
        // ];
        // $response = Http::withHeaders($headers)->post('https://cbt.chprbn.gov.ng/pull-picture',['indexings'=>$candidate_ids]);
        // $response = json_decode($response);
        // return $response;
        // foreach($response as $candidate){
        //     // $imageName = str_replace('/', '_', $candidate->indexing).'.jpg';
        //     $location = candidate_passport_path().'/'.str_replace('/', '_', $candidate->indexing).'.jpg';
        //     $imageData = base64_decode($candidate->photo);
        //     $source = imagecreatefromstring($imageData);
        //     $imageSave = imagejpeg($source, $location, 80);
        //     imagedestroy($source);
        // }
        // return response()->json(['success' => true, 'message' => 'Download Successful'], 200);
//        $tables = ['admin_candidates', 'admin_candidate_subjects']; // Replace with your table names
//        $this->backupService->backupAndTruncate($tables);
        $apiUrl = $this->apiUrl('resource/candidate/picture');

        // Define headers if necessary
        $headers = [
            'Accept' => 'application/json',
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];
        $body = [
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];

        // Fetch data from the API
        // $response = $this->post($apiUrl, $body, $headers);
        // Fetch data from the API
        $response = $this->post($apiUrl, $body, $headers);
        // $response = Http::withHeaders($headers)->post($apiUrl, $body);

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
        return env("CHPRBN_SERV_ADDR",'https://cbt.chprbn.gov.ng/api/v1/').$url;
    }


    public function pushExams(Request $request){
        $counts = TimeControl::where('pushed',0)->count();
        return view("pages.admin.setup.push",compact('counts'));
    }

    public function pullExamToServer(Request $request){
        $times = TimeControl::where('pushed',0)->select(['test_config_id','scheduled_candidate_id','completed','start_time','current_time','elapsed','ip','pushed'])->get();
        $presentations = Presentation::where('pushed',0)->select(['scheduled_candidate_id','test_config_id','test_section_id','question_bank_id','answer_option_id','pushed'])->get();
        $scores = Score::where('pushed',0)->select(['scheduled_candidate_id','test_config_id','question_bank_id','answer_option_id','time_elapse','scoring_mode','point_scored','pushed'])->get();


        $apiUrl = $this->apiUrl('resource/push');

        // Define headers if necessary
        $headers = [
            'Accept' => 'application/json',
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];

        $body = [
            'api_key'=>env("CHPRBN_CBT_API_KEY"),
            'secret_key'=>env("CHPRBN_CBT_SECRET_KEY")
        ];

        // Fetch data from the API
        $response = Http::withHeaders($headers)->post($apiUrl, compact('times','presentations','scores','body'));
        // return $response;
//        return $response['status'];
        if ($response->successful()) {
            TimeControl::where('pushed',0)->update(['pushed'=>1]);
            Presentation::where('pushed',0)->update(['pushed'=>1]);
            Score::where('pushed',0)->update(['pushed'=>1]);
            return response()->json(['success' => true, 'message' => 'Download Successful'], 200);
        }



        // return ;
    }


    protected function validateAndCorrectTime($timeString)
    {
        try {
            // Use Carbon to attempt parsing the time
            $time = \Carbon\Carbon::createFromFormat('H:i:s', $timeString);

            // If the hour is greater than 23, reset it to 23:59:59
            if ($time->hour > 23) {
                $time->hour = 23;
                $time->minute = 59;
                $time->second = 59;
            }

            return $time->format('H:i:s');
        } catch (\Exception $e) {
            // Handle the error - set to a default time or null
            return '00:00:00';  // or handle it as necessary
        }
    }

    public function roleIndex(Request $request){
        $roles = Role::get();
        $users = User::get();

        return view("pages.admin.authorization.role",compact('roles','users'));
    }

    public function roleSave(Request $request){
        $role = new Role();
        $role->name = $request->role;
        $role->description = $request->description;
        $role->save();
        return back()->with('success', "New role {$request->role} created.");

    }

    public function userSave(Request $request){
        $user = new User();
        $user->username = $request->username;
        $user->display_name = $request->display_name;
        $user->email = $request->email;
        $user->enabled = $request->enabled;
        $user->password = bcrypt("Chprbn@2024");
        $user->save();
        return back()->with('success', "New user {$request->username} created.");

    }

    public function userEdit(Request $request){
        $user = User::find($request->user_id);
        if($user){
            $user->username = $request->username;
            $user->display_name = $request->display_name;
            $user->email = $request->email;
            $user->enabled = $request->enabled;
            $user->save();
            return back()->with('success', "New user {$request->username} created.");
        }
        return back()->with('failure', "Invalid User.");
    }

    public function permissionSave(Request $request){

        // return $request;
        $permission = new Permission();
        $permission->name = $request->permission;
        $permission->description = $request->description;
        $permission->save();
        return back()->with('success', "New permission {$request->permission} created.");

    }

    public function rolePermissions(Request $request){
        $permissions = Permission::get();
        $rolePermissions = RolePermission::where('role_id',$request->role_id)->pluck('permission_id')->toArray();
        return view("pages.admin.authorization.roleperm",compact('permissions','rolePermissions'));

    }


    public function roleUsers(Request $request){
        $role_id = $request->role_id;
        $userRoles = UserRole::where('role_id',$request->role_id)->pluck('user_id')->toArray();
        $roleUsers = User::whereIn('id',$userRoles)->get();
        return view("pages.admin.authorization.userRole",compact('roleUsers','userRoles','role_id'));

    }

    public function rolePermissionSave(Request $request){
        // return $request;
        // ?role_id,permission_id
        $role = Role::find($request->role_id);
        if($role){
            foreach($request->permissions as $permission){
                $rolePerm = RolePermission::where(['role_id'=>$request->role_id,"permission_id"=>$permission])->first();
                if(!$rolePerm){
                    $rolePerm = new RolePermission;
                    $rolePerm->role_id = $request->role_id;
                    $rolePerm->permission_id = $permission;
                    $rolePerm->save();
                }


            }
            return back()->with('success', "Permissions add to role {$role->name} created.");
        }
        return back()->with('failure', "Invalid Role");


    }

    public function roleUserSave(Request $request){
        // return $request;
        $role = Role::find($request->role_id);
        if($role){
            foreach($request->user_ids as $user_id){
                $rolePerm = UserRole::where(['role_id'=>$request->role_id,"user_id"=>$user_id])->first();
                if(!$rolePerm){
                    $rolePerm = new UserRole;
                    $rolePerm->role_id = $request->role_id;
                    $rolePerm->user_id = $user_id;
                    $rolePerm->save();
                }

            }

            return back()->with('success', "User added to role {$role->name} created.");
        }
        return back()->with('failure', "Invalid Role");
    }

    public function roleUserDetach(Request $request){
        // return $request;
        $role = Role::find($request->role_id);
        if($role){
            $rolePerm = UserRole::where(['role_id'=>$request->role_id,"user_id"=>$request->user_id])->delete();
            return response()->json(['success'=>1]);
        }
        return response()->json(['success'=>0]);
    }

    public function users(Request $request){
        $users = User::get();
        $roles = Role::get();

        return view("pages.admin.authorization.users",compact("users","roles"));

    }
}

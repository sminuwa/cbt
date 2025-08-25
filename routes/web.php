<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Questions\QuestionController;
use App\Http\Controllers\Admin\Authoring\AuthorController;
use App\Http\Controllers\Admin\Toolbox\ToolboxController;
use App\Http\Controllers\Admin\Reports\ReportController;
use App\Http\Controllers\Admin\System\SetupController;
use App\Http\Controllers\Api\V1\APIV1Controller;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Student\Dashboard\CandidateUploadController;
use App\Http\Controllers\Admin\System\CentreController;
use App\Http\Controllers\Admin\Tests\ExamTypeController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\Admin\System\SubjectsController;
use App\Http\Controllers\Admin\Tests\TestConfigController;
use App\Http\Controllers\Admin\System\TopicController;
use App\Http\Controllers\Admin\System\TestCodeController;
use App\Http\Controllers\Admin\System\TestTypeController;
use App\Http\Controllers\Admin\System\VenueController;
use App\Http\Controllers\Admin\Tests\TestConfigControllerOptimized;
use App\Http\Controllers\Student\Dashboard\CandidateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Web\CBTApiController;

Route::get('/', function () {
    return redirect()->route('candidate.auth.page');
});

Route::name('admin.auth.')->prefix('admin/auth')->group(function () {
    Route::get('/', [UserLoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('/', [UserLoginController::class, 'login'])->name('login.proc');
    Route::get('/logout', [UserLoginController::class, 'logout'])->name('logout');

//    Route::name('candidate.')->prefix('/')->group(function () {
//        Route::get('login', [CandidateLoginController::class, 'showLoginForm'])->name('login');
//        Route::post('login', [CandidateLoginController::class, 'login'])->name('login.proc');
//        Route::get('logout', [CandidateLoginController::class, 'logout'])->name('logout');
//    });
});


Route::middleware('auth:admin')->name('admin.')->prefix('admin')->group(function () {
    Route::match(['GET','POST'],'/configuration', [App\Http\Controllers\MiscController::class, 'configuration'])->name('configuration');
    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
    
    // Dashboard API Routes for AJAX loading
    Route::name('api.dashboard.')->prefix('api/dashboard')->group(function () {
        Route::get('/scheduled-centres', [App\Http\Controllers\Api\DashboardApiController::class, 'scheduledCentresPerPaper'])->name('scheduled.centres');
        Route::get('/centres-pull', [App\Http\Controllers\Api\DashboardApiController::class, 'centresPullStats'])->name('centres.pull');
        Route::get('/centres-push', [App\Http\Controllers\Api\DashboardApiController::class, 'centresPushStats'])->name('centres.push');
        Route::get('/candidates-attended', [App\Http\Controllers\Api\DashboardApiController::class, 'candidatesAttendedPerPaper'])->name('candidates.attended');
        Route::get('/attendance-stats', [App\Http\Controllers\Api\DashboardApiController::class, 'attendanceStats'])->name('attendance.stats');
        Route::get('/centre-performance', [App\Http\Controllers\Api\DashboardApiController::class, 'centrePerformance'])->name('centre.performance');
        Route::get('/daily-activity', [App\Http\Controllers\Api\DashboardApiController::class, 'dailyActivity'])->name('daily.activity');
        Route::get('/subject-performance', [App\Http\Controllers\Api\DashboardApiController::class, 'subjectPerformance'])->name('subject.performance');
        Route::get('/capacity-utilization', [App\Http\Controllers\Api\DashboardApiController::class, 'centreCapacityUtilization'])->name('capacity.utilization');
        Route::get('/exam-status', [App\Http\Controllers\Api\DashboardApiController::class, 'examStatus'])->name('exam.status');
        Route::get('/test-programme', [App\Http\Controllers\Api\DashboardApiController::class, 'testProgrammePerformance'])->name('test.programme');
        Route::get('/top-scorers', [App\Http\Controllers\Api\DashboardApiController::class, 'topScorers'])->name('top.scorers');
    });

    Route::name('test.')->prefix('test')->group(function () {
        Route::name('config.')->prefix('config')->group(function () {
            Route::get('/', [TestConfigController::class, 'index'])->name('index');
            Route::get('/{config}/view', [TestConfigController::class, 'view'])->name('view');
            Route::post('/store', [TestConfigController::class, 'store'])->name('store');
            Route::delete('/{config}', [TestConfigController::class, 'destroy'])->name('delete');
            Route::get('/{config}/basics', [TestConfigController::class, 'basics'])->name('basics');
            Route::post('/basics/store', [TestConfigController::class, 'storeBasics'])->name('basics.store');

            Route::get('/{config}/dates', [TestConfigController::class, 'dates'])->name('dates');
            Route::post('/dates/store', [TestConfigController::class, 'storeDate'])->name('dates.store');
            Route::get('/dates/delete/{date}', [TestConfigController::class, 'deleteDate'])->name('dates.delete');

            Route::get('/{config}/schedules', [TestConfigController::class, 'schedules'])->name('schedules');
            Route::post('/schedules/store', [TestConfigController::class, 'storeSchedule'])->name('schedules.store');
            Route::post('/schedules/{config}/schedule-all', [TestConfigController::class, 'scheduleAllCenters'])->name('schedules.schedule-all');
            Route::post('/schedules/{config}/batch-reschedule', [TestConfigController::class, 'batchReschedule'])->name('schedules.batch-reschedule');
            Route::post('/schedules/{config}/batch-schedule-candidates', [TestConfigController::class, 'batchScheduleCandidates'])->name('batch-schedule-candidates');
            Route::post('/schedules/{config}/transfer-schedule', [TestConfigController::class, 'transferScheduleToCentre'])->name('transfer-schedule');
            Route::get('/schedules/{config}/debug-venue/{venue_id}', [TestConfigController::class, 'debugVenue'])->name('debug-venue');
            Route::post('/schedules/{config}/transfer-candidates', [TestConfigController::class, 'transferCandidates'])->name('transfer-candidates');
            Route::get('/schedules/{schedule}/candidates', [TestConfigController::class, 'getScheduleCandidates'])->name('schedules.candidates');
            Route::get('/schedules/{scheduling}/displacement', [TestConfigController::class, 'deleteSchedule'])->name('schedules.delete');
            Route::get('/schedules/{scheduling}/remove/delete', [TestConfigController::class, 'removeAndDeleteSchedule'])->name('schedules.remove.delete');
            Route::get('/schedules/{scheduling}/others/{size}', [TestConfigController::class, 'otherSchedules'])->name('schedules.others');
            Route::post('/schedules/reschedule', [TestConfigController::class, 'reschedule'])->name('schedules.reschedule');

            Route::get('/{config}/upload-candidates/options', [TestConfigController::class, 'uploadOptions'])->name('upload.options');
            //  Route::post('/upload-candidates/single', [TestConfigController::class, 'uploadSingle'])->name('upload.single');
            Route::post('/upload-candidates/list', [TestConfigController::class, 'bulkUpload'])->name('upload.list');

            Route::get('/{config}/mappings', [TestConfigController::class, 'mappings'])->name('mappings');
            Route::post('/mappings/store', [TestConfigController::class, 'storeMappings'])->name('mappings.store');

            Route::get('/{config}/subjects', [TestConfigController::class, 'subjects'])->name('subjects');
            Route::get('/{config}/subjects/ajax', [TestConfigController::class, 'subjectsAjax'])->name('subjects.ajax');
            Route::get('/{config}/registered/subjects', [TestConfigController::class, 'registeredSubjectsAjax'])->name('registered.subjects');
            Route::post('/register/subject', [TestConfigController::class, 'registerSubject'])->name('subject.register');
            Route::get('/remove/{testSubject}', [TestConfigController::class, 'removeSubject'])->name('subject.remove');

            Route::get('/{config}/composition', [TestConfigController::class, 'composition'])->name('composition');
            Route::get('/{testSubject}/composition/compose', [TestConfigController::class, 'compose'])->name('composition.compose');
            Route::post('/composition/compose/store', [TestConfigController::class, 'storeSection'])->name('composition.compose.store');
            Route::delete('/composition/section/{testSection}', [TestConfigController::class, 'deleteSection'])->name('composition.section.delete');
            Route::get('/{testSection}/composition/compose/questions', [TestConfigController::class, 'questions'])->name('composition.compose.questions');
            Route::get('/composition/load/questions', [TestConfigController::class, 'loadQuestions'])->name('compose.questions.load');
            Route::post('/composition/questions/store', [TestConfigController::class, 'storeQuestions'])->name('compose.questions.store');
            Route::get('/composition/questions/remove/{sid}/{qid}', [TestConfigController::class, 'removeQuestion'])->name('compose.questions.remove');

            Route::get('/{config}/compose/preview', [TestConfigController::class, 'previewQuestions'])->name('composition.preview');
            Route::get('/{testSubject}/compose/preview/questions', [TestConfigController::class, 'preview'])->name('composition.preview.questions');

            Route::get('/{config}/manage/users', [TestConfigController::class, 'manageUsers'])->name('manage.users');
            Route::post('/manage/users/search/compositor', [TestConfigController::class, 'searchCompositor'])->name('manage.users.search.compositor');
            Route::post('/manage/users/add/compositor', [TestConfigController::class, 'addCompositor'])->name('manage.users.add.compositor');
            Route::get('/{config}/manage/users/remove/compositor/{id}', [TestConfigController::class, 'removeCompositor'])->name('manage.users.remove.compositor');
            Route::post('/manage/users/add/invigilator', [TestConfigController::class, 'addInvigilator'])->name('manage.users.add.invigilator');
            Route::get('/{config}/manage/users/remove/invigilator/{id}', [TestConfigController::class, 'removeInvigilator'])->name('manage.users.remove.invigilator');
            Route::post('/manage/users/add/previewer', [TestConfigController::class, 'addPreviewer'])->name('manage.users.add.previewer');
            Route::get('/{config}/manage/users/remove/previewer/{id}', [TestConfigController::class, 'removePreviewer'])->name('manage.users.remove.previewer');
            Route::POST('/upload-all-candidates',[TestConfigController::class,'uploadAllCandidates'])->name('upload.all.candidate');
        });
    });

    Route::name('questions.')->prefix('questions')->group(function () {
        Route::get('/', [QuestionController::class, 'questions'])->name('index');
    });

    Route::name('authoring.')->prefix('authoring')->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('index');
        Route::post('/store', [AuthorController::class, 'store'])->name('store');
        Route::get('/review/{subject}/{topic}', [AuthorController::class, 'review'])->name('review');
        Route::post('/submit', [AuthorController::class, 'submit'])->name('submit');
        Route::get('/completed/{duplicates}', [AuthorController::class, 'completed'])->name('completed');
        Route::get('/preview', [AuthorController::class, 'preview'])->name('preview');
        Route::post('/preview/load', [AuthorController::class, 'loadPreview'])->name('load.preview');
        Route::get('/edit/questions', [AuthorController::class, 'editQuestions'])->name('edit.questions');
        Route::post('/load/questions/improved', [AuthorController::class, 'loadQuestionsImproved'])->name('load.questions.improved');
        Route::get('/get/question/{question}', [AuthorController::class, 'getQuestion'])->name('get.question');
        Route::post('/delete/question', [AuthorController::class, 'deleteQuestion'])->name('delete.question');
        Route::post('/bulk/edit', [AuthorController::class, 'bulkEditQuestions'])->name('bulk.edit');
        Route::post('/bulk/delete', [AuthorController::class, 'bulkDeleteQuestions'])->name('bulk.delete');
        Route::get('/export/questions', [AuthorController::class, 'exportQuestions'])->name('export.questions');
        Route::get('/export/questions/docx', [AuthorController::class, 'exportQuestionsDocx'])->name('export.questions.docx');
        Route::get('/edit/{question}', [AuthorController::class, 'editQuestion'])->name('edit.question');
        Route::post('/update/question', [AuthorController::class, 'updateQuestion'])->name('update.question');

        Route::get('/move/questions', [AuthorController::class, 'moveQuestions'])->name('move.questions');
        Route::post('/load/questions', [AuthorController::class, 'loadQuestions'])->name('load.questions');
        Route::post('/relocate/questions', [AuthorController::class, 'relocateQuestions'])->name('relocate.questions');

        Route::get('topics/{subject}', [TopicController::class, 'topicBy'])->name('topics');
        Route::post('topics/add', [TopicController::class, 'storeTopic'])->name('topics.add');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::name('reports.')->prefix('reports')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::name('test.')->prefix('test')->group(function () {
                Route::get('/report', 'testReports')->name('index');
                Route::post('generate', 'generateDaily')->name('generate');
            });

            Route::name('summary.')->prefix('summary')->group(function () {
                Route::get('/report', 'reportSummary')->name('reports');
                Route::match(['GET','POST'],'/report/generate', 'generateReport')->name('generate.report');

                Route::get('/question', 'questionSummary')->name('question');
                Route::post('/question/generate', 'generateQuestionSummary')->name('generate.question');

                Route::get('/presentation', 'presentationSummary')->name('presentation');
                Route::post('/presentation', 'generatePresentationSummary')->name('generate.presentation');
            });

            Route::name('active.')->prefix('active')->group(function () {
                Route::get('/candidates', 'activeCandidates')->name('index');
                Route::post('generate', 'generateActiveCandidates')->name('generate');
            });
        });
    });

    Route::name('misc.')->prefix('misc')->group(function () {
        Route::get('/{centre}/venues', [MiscController::class, 'venues'])->name('venues');
        Route::get('/{scheduling}/faculty/mappings', [MiscController::class, 'facultyMappings'])->name('faculty.mappings');

            Route::get('/{venue}/batches/capacity', [MiscController::class, 'batchCapacity'])->name('batches.capacity');
        Route::get('test/config/{year}/{type}/{code}', [MiscController::class, 'testConfig'])->name('test.config');

        Route::get('test/{config}/subjects', [MiscController::class, 'testSubjects'])->name('test.subjects');
        Route::get('test/{config}/candidates', [MiscController::class, 'testCandidates'])->name('test.candidates');
        Route::get('/schedules/{schedule}/candidates', [MiscController::class, 'scheduleCandidates'])->name('schedule.candidates');
        Route::get('/centre/{centre}/schedules', [MiscController::class, 'centreSchedules'])->name('centre.schedules');
    });

    Route::name('exams.setup.')->prefix('exams/setup')->group(function () {
        Route::get('/', [SetupController::class, 'index'])->name('index');
        Route::get('/push', [SetupController::class, 'pushExams'])->name('push');
        Route::post('pull/basic', [SetupController::class, 'pullBasicResource'])->name('pull.basic');
        Route::post('pull/test', [SetupController::class, 'pullTestResource'])->name('pull.test');
        Route::post('pull/candidate', [SetupController::class, 'pullCandidateResource'])->name('pull.candidate');
        Route::post('pull/candidate/picture', [SetupController::class, 'pullCandidatePictures'])->name('pull.candidate.pictures');
        Route::get('push/finished', [SetupController::class, 'pullExamToServer'])->name('push.finished');
    });

    Route::name('authorization.')->prefix('authorization/')->group(function () {
        Route::get('/users', [SetupController::class, 'users'])->name('users.index');
        Route::post('/user/save', [SetupController::class, 'userSave'])->name('user.save');
        Route::post('/user/edit', [SetupController::class, 'userEdit'])->name('user.edit');
        Route::get('/role', [SetupController::class, 'roleIndex'])->name('role.index');
        Route::post('/role/save', [SetupController::class, 'roleSave'])->name('role.save');
        Route::post('/permission/save', [SetupController::class, 'permissionSave'])->name('permission.save');
        Route::get('/role/permissions', [SetupController::class, 'rolePermissions'])->name('role.permission');
        Route::get('/role/users', [SetupController::class, 'roleUsers'])->name('role.users');
        Route::post('/role/permission/save', [SetupController::class, 'rolePermissionSave'])->name('role.permission.save');
        Route::post('/role/user/save', [SetupController::class, 'roleUserSave'])->name('role.user.save');
        Route::any('/role/user/detach', [SetupController::class, 'roleUserDetach'])->name('role.user.detach');
    });

    Route::name('candidates.')->prefix('candidates')->group(function () {
        Route::name('manage.')->prefix('manage')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'index'])->name('index');
            Route::get('/data', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'getData'])->name('data');
            Route::post('/upload-excel', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'uploadExcel'])->name('upload.excel');
            Route::post('/pull', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'pullCandidates'])->name('pull');
            Route::get('/{id}', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'show'])->name('show');
            Route::put('/{id}', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'destroy'])->name('delete');
            
            // Image management routes
            Route::name('image.')->prefix('image')->group(function () {
                Route::get('/stats', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'getImageStats'])->name('stats');
                Route::post('/generate', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'generateImages'])->name('generate');
                Route::post('/pull', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'pullImages'])->name('pull');
                Route::post('/upload', [App\Http\Controllers\Admin\Candidate\CandidateController::class, 'uploadImages'])->name('upload');
            });
        });
    });

    Route::name('centres.')->prefix('centres')->group(function () {
        Route::name('manage.')->prefix('manage')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Centre\CentreController::class, 'index'])->name('index');
            Route::get('/data', [App\Http\Controllers\Admin\Centre\CentreController::class, 'getData'])->name('data');
            Route::get('/available', [App\Http\Controllers\Admin\Centre\CentreController::class, 'getAvailableCentres'])->name('available');
            Route::post('/', [App\Http\Controllers\Admin\Centre\CentreController::class, 'store'])->name('store');
            Route::get('/{id}', [App\Http\Controllers\Admin\Centre\CentreController::class, 'show'])->name('show');
            Route::put('/{id}', [App\Http\Controllers\Admin\Centre\CentreController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\Admin\Centre\CentreController::class, 'destroy'])->name('destroy');
            Route::post('/venue', [App\Http\Controllers\Admin\Centre\VenueController::class, 'store'])->name('venue.store');
            Route::delete('/venue/{id}', [App\Http\Controllers\Admin\Centre\VenueController::class, 'destroy'])->name('venue.destroy');
            Route::post('/candidate/delete', [App\Http\Controllers\Admin\Centre\CentreController::class, 'deleteCandidate'])->name('candidate.delete');
            Route::post('/candidate/reschedule', [App\Http\Controllers\Admin\Centre\CentreController::class, 'rescheduleCandidate'])->name('candidate.reschedule');
        });
    });

    Route::name('toolbox.')->prefix('toolbox')->group(function () {
        Route::name('center_venue.')->prefix('center-venue')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Centre\CentreController::class, 'index'])->name('home');
            Route::post('/center/store', [App\Http\Controllers\Admin\Centre\CentreController::class, 'store'])->name('center.store');
            Route::put('/center/{id}', [App\Http\Controllers\Admin\Centre\CentreController::class, 'update'])->name('center.edit');
            Route::delete('/center/{id}', [App\Http\Controllers\Admin\Centre\CentreController::class, 'destroy'])->name('center.destroy');
            Route::post('/venue/store', [App\Http\Controllers\Admin\Centre\VenueController::class, 'store'])->name('venue.store');
            Route::delete('/venue/{id}', [App\Http\Controllers\Admin\Centre\VenueController::class, 'destroy'])->name('venue.delete');
        });
        Route::name('candidate-types.')->prefix('candidate-types')->group(function () {
            Route::get('/', [ExamTypeController::class, 'index'])->name('index');
            Route::post('etype/store', [ExamTypeController::class, 'store'])->name('store');
            Route::get('etype/delete/{examType}', [ExamTypeController::class, 'destroy'])->name('delete');
        });
        Route::name('subject.')->prefix('subjects')->group(function () {
            Route::get('/', [SubjectsController::class, 'index'])->name('home');
            Route::post('sub/store', [SubjectsController::class, 'create'])->name('store');
            Route::get('sub/delete/{subject}', [SubjectsController::class, 'destroy'])->name('delete');
        });

        Route::name('topics.')->prefix('topics')->group(function () {
            Route::get('/', [TopicController::class, 'index'])->name('index');
            Route::post('/store', [TopicController::class, 'store'])->name('store');
            Route::get('/delete/{topic}', [TopicController::class, 'destroy'])->name('delete');
        });

        Route::name('test-codes.')->prefix('test-codes')->group(function () {
            Route::get('/', [TestCodeController::class, 'index'])->name('index');
            Route::post('/store', [TestCodeController::class, 'store'])->name('store');
            Route::get('/delete/{testCode}', [TestCodeController::class, 'destroy'])->name('delete');
        });

        Route::name('test-types.')->prefix('test-types')->group(function () {
            Route::get('/', [TestTypeController::class, 'index'])->name('index');
            Route::post('/store', [TestTypeController::class, 'store'])->name('store');
            Route::get('/delete/{testType}', [TestTypeController::class, 'destroy'])->name('delete');
        });

        Route::name('candidate_upload.')->prefix('candidate_upload')->group(function () {
            Route::get('upload-cand', [CandidateUploadController::class, 'index'])->name('upload.candidate');
            Route::post('upload-candidate-data', [CandidateUploadController::class, 'upload'])->name('upload.candidate.data');

        });

        Route::name('candidate_image_upload.')->prefix('candidate_image_upload')->group(function () {
            Route::get('upload-candidate', [CandidateUploadController::class, 'imageIndex'])->name('upload.images');
            Route::post('upload-candidate-image', [CandidateUploadController::class, 'imageUpload'])->name('upload.image.data');
            //Route::get('invigilator', [CandidateUploadController::class, 'invigilator'])->name('invigilator');

        });

        Route::name('invigilator.')->prefix('invigilator')->group(function () {
            Route::get('invigilator', [CandidateUploadController::class, 'invigilator'])->name('index');
            Route::post('/increase-time', [CandidateUploadController::class, 'viewCandidateTime'])->name('increase-time.view');
            Route::post('/save-time', [CandidateUploadController::class, 'saveTimeAdjustment'])->name('save-time.adjust');
            Route::post('/reset_password', [CandidateUploadController::class, 'resetCandidatePassword'])->name('reset.password');
            Route::post('/load-profile', [CandidateUploadController::class, 'loadProfile'])->name('candidate.loadProfile');
        });

    });
});

Route::name('exam.')->prefix('exams')->group(function(){
    Route::post('/restore', [CandidateController::class, 'restoreCandidate'])->name('candidate.restore');
    Route::post('/end/exams', [CandidateController::class, 'endCandidateExam'])->name('candidate.endexam');
    Route::post('/adjust/time', [CandidateController::class, 'adjustCandidateTime'])->name('candidate.adjusttime');
    Route::post('/reset-password', [CandidateController::class, 'resetPassword'])->name('candidate.reset-password');
});

Route::name('api.v1.')->prefix('api/v1/')->group(function () {
    Route::name('resource.')->prefix('resource/')->group(function () {
        Route::post('basic/', [APIV1Controller::class, 'basicData'])->name('basic');
        Route::post('test/', [APIV1Controller::class, 'testData'])->name('test');
        Route::post('candidate/', [APIV1Controller::class, 'candidateData'])->name('candidate');
        Route::post('candidate/picture', [APIV1Controller::class, 'candidatePictures'])->name('candidate.picture');
        Route::post('push', [APIV1Controller::class, 'pushExams'])->name('exams.push');
    });

})->middleware('api-auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::match(['GET','POST'],'generate-candidate-picture', [CBTApiController::class, 'generateCandidatePicture'])->name('generate-candidate-picture');
Route::match(['GET','POST'],'client-pull-picture', [CBTApiController::class, 'pullCandidatePictures'])->name('client.pull.picture');
Route::match(['GET','POST'],'pull-picture', [APIV1Controller::class, 'candidatePictures'])->name('pull.picture');
Route::match(['GET','POST'],'pull-candidate', [App\Http\Controllers\Api\Web\CBTApiController::class, 'pullCandidate']);


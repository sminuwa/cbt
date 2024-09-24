<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SetupController;
use App\Http\Controllers\Api\V1\APIV1Controller;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\CandidateUploadController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\ExamTypeController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\TestConfigController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Web\CBTApiController;

Route::get('/', function () {
    return redirect()->route('candidate.auth.page');
});

Route::name('auth.')->prefix('auth/')->group(function () {
    Route::name('admin.')->prefix('adm/')->group(function () {
        Route::get('login', [UserLoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
        Route::post('login', [UserLoginController::class, 'login'])->name('login.proc');
        Route::get('logout', [UserLoginController::class, 'logout'])->name('logout');
    });

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

    Route::name('test.')->prefix('test')->group(function () {
        Route::name('config.')->prefix('config')->group(function () {
            Route::get('/', [TestConfigController::class, 'index'])->name('index');
            Route::get('/{config}/view', [TestConfigController::class, 'view'])->name('view');
            Route::post('/store', [TestConfigController::class, 'store'])->name('store');
            Route::get('/{config}/basics', [TestConfigController::class, 'basics'])->name('basics');
            Route::post('/basics/store', [TestConfigController::class, 'storeBasics'])->name('basics.store');

            Route::get('/{config}/dates', [TestConfigController::class, 'dates'])->name('dates');
            Route::post('/dates/store', [TestConfigController::class, 'storeDate'])->name('dates.store');
            Route::get('/dates/delete/{date}', [TestConfigController::class, 'deleteDate'])->name('dates.delete');

            Route::get('/{config}/schedules', [TestConfigController::class, 'schedules'])->name('schedules');
            Route::post('/schedules/store', [TestConfigController::class, 'storeSchedule'])->name('schedules.store');
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
        });
    });

    Route::name('questions.')->prefix('questions')->group(function () {
        Route::name('authoring.')->prefix('authoring')->group(function () {
            Route::get('/', [QuestionController::class, 'index'])->name('index');
            Route::get('/author', [QuestionController::class, 'author'])->name('author');
            Route::post('/author', [QuestionController::class, 'authorPost'])->name('post');
            Route::get('/review/{subject}/{topic}', [QuestionController::class, 'review'])->name('review');
            Route::post('/store', [QuestionController::class, 'store'])->name('store');
            Route::get('/completed/{duplicates}', [QuestionController::class, 'completed'])->name('completed');
            Route::get('/preview', [QuestionController::class, 'preview'])->name('preview');
            Route::post('/preview/load', [QuestionController::class, 'loadPreview'])->name('load.preview');
            Route::get('/edit/questions', [QuestionController::class, 'editQuestions'])->name('edit.questions');
            Route::get('/edit/{question}', [QuestionController::class, 'editQuestion'])->name('edit.question');
            Route::post('/store/question', [QuestionController::class, 'storeQuestion'])->name('store.question');

            Route::get('/move/questions', [QuestionController::class, 'moveQuestions'])->name('move.questions');
            Route::post('/load/questions', [QuestionController::class, 'loadQuestions'])->name('load.questions');
            Route::post('/relocate/questions', [QuestionController::class, 'relocateQuestions'])->name('relocate.questions');

            Route::get('topics/{subject}', [TopicController::class, 'topicBy'])->name('topics');
            Route::post('topics/add', [TopicController::class, 'storeTopic'])->name('topics.add');
        });
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
                Route::post('/report/generate', 'generateReport')->name('generate.report');

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
    });

    Route::name('exams.setup.')->prefix('exams/setup')->group(function () {
        Route::get('/', [SetupController::class, 'index'])->name('index');
        Route::get('/push', [SetupController::class, 'pushExams'])->name('push');
        Route::post('pull/basic', [SetupController::class, 'pullBasicResource'])->name('pull.basic');
        Route::post('pull/test', [SetupController::class, 'pullTestResource'])->name('pull.test');
        Route::post('pull/candidate', [SetupController::class, 'pullCandidateResource'])->name('pull.candidate');
        Route::post('pull/candidate/picture', [SetupController::class, 'pullCandidatePictures'])->name('pull.candidate.pictures');
    });
});

Route::name('toolbox.')->prefix('toolbox')->group(function () {
    Route::name('candidate-types.')->prefix('candidate-types')->group(function () {
        Route::get('/', [ExamTypeController::class, 'index'])->name('index');
        Route::post('etype/store', [ExamTypeController::class, 'store'])->name('store');
        Route::get('etype/delete/{examType}', [ExamTypeController::class, 'destroy'])->name('delete');
    });
    Route::name('center_venue.')->prefix('center_venue')->group(function () {
        Route::get('/', [CentreController::class, 'index'])->name('home');
        Route::post('centre/store', [CentreController::class, 'store'])->name('center.store');
        Route::post('centre/edit/{id}', [CentreController::class, 'edit'])->name('center.edit');
        Route::post('centre/delete', [CentreController::class, 'destroy'])->name('center.destroy');
        Route::post('venue/store', [VenueController::class, 'store'])->name('venue.store');
        Route::get('venue/delete/{venue}', [VenueController::class, 'destroy'])->name('venue.delete');
    });
    Route::name('subject.')->prefix('subjects')->group(function () {
        Route::get('/', [SubjectsController::class, 'index'])->name('home');
        Route::post('sub/store', [SubjectsController::class, 'create'])->name('store');
        Route::get('sub/delete/{subject}', [SubjectsController::class, 'destroy'])->name('delete');
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

    Route::name('exams.setup.')->prefix('exams/setup')->group(function () {
        Route::get('/', [SetupController::class, 'index'])->name('index');
        Route::post('pull/basic', [SetupController::class, 'pullBasicResource'])->name('pull.basic');
        Route::post('pull/test', [SetupController::class, 'pullTestResource'])->name('pull.test');
        Route::get('push/finished', [SetupController::class, 'pullExamToServer'])->name('push.finished');
    });
});

Route::name('exam.')->prefix('exams')->group(function(){
    Route::post('/restore', [CandidateUploadController::class, 'restoreCandidate'])->name('candidate.restore');
    Route::post('/end/exams', [CandidateUploadController::class, 'endCandidateExam'])->name('candidate.endexam');
    Route::post('/adjust/time', [CandidateUploadController::class, 'adjustCandidateTime'])->name('candidate.adjusttime');
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
Route::match(['GET','POST'],'pull-picture', [APIV1Controller::class, 'candidatePictures'])->name('pull.picture');


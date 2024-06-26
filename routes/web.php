<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\CandidateLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\TestConfigController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('pages.admin.dashboard.index');
});


Route::name('auth.')->prefix('auth/')->group(function () {
    Route::name('admin.')->prefix('adm/')->group(function () {
        Route::get('login', [UserLoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
        Route::post('login', [UserLoginController::class, 'login'])->name('login.proc');
        Route::get('logout', [UserLoginController::class, 'logout'])->name('logout');
    });
    Route::name('candidate.')->prefix('/')->group(function () {
        Route::get('login', [CandidateLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [CandidateLoginController::class, 'login'])->name('login.proc');
        Route::get('logout', [CandidateLoginController::class, 'logout'])->name('logout');
    });
});


Route::name('admin.')->prefix('adm')->group(function () {

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
            Route::get('/completed', [QuestionController::class, 'completed'])->name('completed');
            Route::get('/preview', [QuestionController::class, 'preview'])->name('preview');
            Route::post('/preview/load', [QuestionController::class, 'loadPreview'])->name('load.preview');
            Route::get('/edit/questions', [QuestionController::class, 'editQuestions'])->name('edit.questions');
            Route::get('/edit/{question}', [QuestionController::class, 'editQuestion'])->name('edit.question');
            Route::post('/store/question', [QuestionController::class, 'storeQuestion'])->name('store.question');

            Route::get('topics/{subject}', [TopicController::class, 'topicBy'])->name('topics');
        });
    });

    Route::name('reports.')->prefix('reports')->group(function () {
        Route::name('testcode.')->prefix('by-test-code')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::post('generate', [ReportController::class, 'generateByCode'])->name('generate');
        });

        Route::name('daily.')->prefix('daily')->group(function () {
            Route::get('/', [ReportController::class, 'daily'])->name('index');
            Route::post('generate', [ReportController::class, 'generateDaily'])->name('generate');
        });
    });

    Route::name('misc.')->prefix('misc')->group(function () {
        Route::get('/{centre}/venues', [MiscController::class, 'venues'])->name('venues');
        Route::get('/{scheduling}/faculty/mappings', [MiscController::class, 'facultyMappings'])->name('faculty.mappings');

        Route::get('/{venue}/batches/capacity', [MiscController::class, 'batchCapacity'])->name('batches.capacity');
    });
});

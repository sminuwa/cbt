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

            Route::get('/{config}/mappings', [TestConfigController::class, 'mappings'])->name('mappings');
            Route::post('/mappings/store', [TestConfigController::class, 'storeMappings'])->name('mappings.store');
        });
    });

    Route::prefix('questions')->group(function () {
        Route::get('authoring', [QuestionController::class, 'author'])->name('questions.authoring');
        Route::post('authoring', [QuestionController::class, 'authorPost'])->name('questions.authoring.post');
        Route::get('authoring/questions/review/{subject}/{topic}', [QuestionController::class, 'review'])->name('questions.authoring.review');
        Route::post('authoring/store', [QuestionController::class, 'store'])->name('questions.authoring.store');
        Route::get('authoring/completed', [QuestionController::class, 'completed'])->name('questions.authoring.completed');
        Route::get('preview', [QuestionController::class, 'preview'])->name('questions.authoring.preview');
        Route::post('preview/load', [QuestionController::class, 'loadPreview'])->name('questions.authoring.load.preview');
        Route::get('edit/{question}', [QuestionController::class, 'editQuestion'])->name('questions.authoring.edit.question');
        Route::post('store/question', [QuestionController::class, 'storeQuestion'])->name('questions.authoring.store.question');

        Route::get('topics/{subject}', [TopicController::class, 'topicBy'])->name('questions.topics');
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
    });

});

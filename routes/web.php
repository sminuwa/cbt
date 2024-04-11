<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\CandidateLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('pages.admin.dashboard.index');
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
});

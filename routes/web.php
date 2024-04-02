<?php

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

    Route::get('topics/{subject}', [TopicController::class, 'topicBy'])->name('questions.topics');
});

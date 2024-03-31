<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    str_replace('j',);
    return view('pages.admin.dashboard.index');
});

Route::get('/form', [QuestionController::class, 'author'])->name('author');
Route::post('/form', [QuestionController::class, 'authorPost'])->name('author.post');

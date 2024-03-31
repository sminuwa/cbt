<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/form', [QuestionController::class, 'author'])->name('author');
Route::post('/form', [QuestionController::class, 'authorPost'])->name('author.post');

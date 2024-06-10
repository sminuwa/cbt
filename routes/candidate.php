<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Auth\CandidateLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Candidate\Auth\AuthController;
use App\Http\Controllers\Candidate\MiscController;
use App\Http\Controllers\Candidate\TestController;
use App\Http\Controllers\TestConfigController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;


Route::name('auth.')->prefix('auth')->group(function(){
    Route::get('/', [AuthController::class,'index'])->name('login');
});


Route::name('test.')->prefix('test')->group(function(){
//    Route::get('/',[TestController::class,'start'])->name('start');
    Route::get('/instruction',[MiscController::class,'instruction'])->name('instruction');
    Route::get('/question{start?}',[TestController::class,'question'])->name('question');
});
Route::view('test','pages.candidate.test.instruction');

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


Route::controller(AuthController::class)->name('auth.')->prefix('auth')->group(function(){
    Route::get('/', 'index')->name('page');
    Route::post('/login','login')->name('login');
});


Route::middleware('auth:web')->name('test.')->prefix('test')->group(function(){
//    Route::get('/',[TestController::class,'start'])->name('start');
    Route::get('/instruction',[MiscController::class,'instruction'])->name('instruction');
    Route::match(['GET','POST'],'/question{start?}',[TestController::class,'question'])->name('question');
    Route::get('/nativation/{question}/{subject}/{}',[TestController::class,'question'])->name('navitation');
    Route::get('/answering',[TestController::class,'answering'])->name('answering');
    Route::get('/time_control',[TestController::class,'time_control'])->name('time_control');
    Route::get('/submit_test',[TestController::class,'submit_test'])->name('submit_test');
    Route::get('/goto-paper',[TestController::class,'goto_paper'])->name('goto_paper');
});
Route::view('test','pages.candidate.test.instruction');

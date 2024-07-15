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
    Route::get('/', 'index');
    Route::post('/login','login')->name('login');
});


Route::middleware('auth:web')->name('test.')->prefix('test')->group(function(){
//    Route::get('/',[TestController::class,'start'])->name('start');
    Route::get('/instruction',[MiscController::class,'instruction'])->name('instruction');
    Route::get('/question{start?}',[TestController::class,'question'])->name('question');
    Route::get('/nativation/{question}/{subject}/{}',[TestController::class,'question'])->name('navitation');
});
Route::view('test','pages.candidate.test.instruction');

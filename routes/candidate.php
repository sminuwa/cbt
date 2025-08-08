<?php

use App\Http\Controllers\Student\Auth\AuthController;
use App\Http\Controllers\Student\Dashboard\MiscController;
use App\Http\Controllers\Student\Exam\TestController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->name('auth.')->prefix('auth')->group(function(){
    Route::get('/', 'index')->name('page');
    Route::post('/login','login')->name('login');
});


Route::middleware('auth:candidate')->name('test.')->prefix('test')->group(function(){
//    Route::get('/',[TestController::class,'start'])->name('start');
    Route::get('/instruction',[MiscController::class,'instruction'])->name('instruction');
    Route::match(['GET','POST'],'/question{start?}',[TestController::class,'question'])->name('question');
    Route::get('/nativation/{question}/{subject}/{}',[TestController::class,'question'])->name('navitation');
    Route::get('/answering',[TestController::class,'answering'])->name('answering');
    Route::get('/time_control',[TestController::class,'time_control'])->name('time_control');
    Route::get('/submit_test',[TestController::class,'submit_test'])->name('submit_test');
    Route::get('/goto-paper',[TestController::class,'goto_paper'])->name('goto_paper');
    Route::get('/submitted',[TestController::class,'submitted'])->name('submitted');

    Route::view('test','pages.candidate.test.instruction');
});


<?php
use Illuminate\Support\Facades\Route;


Route::post('login', [\App\Http\Controllers\Api\V1\Mobile\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function (){
    Route::get('user', [\App\Http\Controllers\Api\V1\Mobile\UserController::class, 'index']);
    Route::get('/institutions', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'institutions']);
    Route::get('/institution/{id}', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'institution']);
    Route::get('/cadres', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'cadres']);
    Route::get('/cadre/{id}', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'cadre']);
    Route::get('/papers', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'papers']);
    Route::get('/paper/{code}', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'paper']);
    Route::get('/attendance-remarks', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'attendanceRemark']);
    Route::get('/assessment-forms', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'assessmentForms']);
    Route::get('/assessment-areas', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'assessmentAreas']);
    Route::get('/assessment-categories', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'assessmentCategories']);
    Route::get('/assessment-items', [\App\Http\Controllers\Api\V1\Mobile\MiscController::class,'assessmentItems']);

    Route::prefix('attendance')->group(function(){
        Route::match(['GET', 'POST'],'fetch-record', [\App\Http\Controllers\Api\V1\Mobile\AttendanceController::class, 'fetchRecord']);
        Route::match(['GET', 'POST'],'push-record', [\App\Http\Controllers\Api\V1\Mobile\AttendanceController::class, 'pushRecord']);
    });

    Route::prefix('project')->group(function(){
        Route::match(['GET', 'POST'],'push-record', [\App\Http\Controllers\Api\V1\Mobile\AttendanceController::class, 'pushProject']);
    });

    Route::prefix('practical')->group(function(){
        Route::match(['GET', 'POST'],'push-record', [\App\Http\Controllers\Api\V1\Mobile\AttendanceController::class, 'pushPractical']);
    });
    
});

Route::middleware('auth:sanctum')->group(function (){
    Route::get('centre', [\App\Http\Controllers\Api\V1\Mobile\CentreController::class, 'index']);
});
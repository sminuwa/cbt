<?php
use Illuminate\Support\Facades\Route;

Route::name('api.v1.')->prefix('api/v1/')->group(function () {
    Route::name('resource.')->prefix('resource/')->group(function () {
        Route::post('basic/', [SetupController::class, 'pullBasic'])->name('basic');
    });

})->middleware('api-auth');

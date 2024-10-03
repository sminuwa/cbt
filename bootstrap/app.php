<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('candidate')
                ->name('candidate.')
                ->group(base_path('routes/candidate.php'));
            Route::middleware('api')
                ->prefix('api/v1/mobile')
                ->name('api.v1.mobile.')
                ->group(base_path('routes/apiV1Mobile.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {

        //
//        if(!Auth::guard('admin')->check())
//            $middleware->redirectGuestsTo('auth/adm/login');
//        else
        // $middleware->add('centre', \App\Http\Middleware\CentreGuard::class);
        $middleware->alias([
            'centre' => \App\Http\Middleware\CentreGuard::class,
        ]);
        $middleware->redirectGuestsTo('candidate/auth');
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            'candidate/auth/login',
            'candidate/test/question',
            'toolbox/candidate_image_upload/generate',
            'pull-picture',
            'pull-candidate',
            'api/*'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

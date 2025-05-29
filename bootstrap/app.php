<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
// use Throwable; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e, Request $request) {
            $genericDbErrorMessage = 'An error occurred while processing data. Please try again later or contact support.';
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Server'], 500);
            }
           
            Log::error("Unhandled exception caught by renderable: " . $e->getMessage());
            Alert::error('Error', $genericDbErrorMessage);
    
            return redirect()->route('login');
        });
    })->create();

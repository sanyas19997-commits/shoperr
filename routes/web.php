<?php

use Illuminate\Support\Facades\Route;

// Sanctum CSRF cookie endpoint
Route::get('/sanctum/csrf-cookie', [\Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show']);

// Serve the Vue SPA for all non-API routes
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '^(?!api|storage|sanctum).*$');

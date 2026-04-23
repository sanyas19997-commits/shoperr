<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Sanctum CSRF cookie endpoint
Route::get('/sanctum/csrf-cookie', [\Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show']);

// Serve uploaded files from the `public` disk.
//
// On a normal Laravel deploy this is handled by the `public/storage` symlink
// created by `php artisan storage:link`. Shared hosts (InfinityFree) don't
// support creating that symlink over FTP, so we proxy the request through
// Laravel instead. `.htaccess` already routes non-existent files through
// index.php, so this route only fires when Apache can't find the file
// directly. `->where('path', '.+')` allows nested paths like
// `products/abc.png`.
Route::get('/storage/{path}', function (string $path) {
    if (str_contains($path, '..')) {
        abort(404);
    }
    $disk = Storage::disk('public');
    if (!$disk->exists($path)) {
        abort(404);
    }
    return $disk->response($path);
})->where('path', '.+');

// Serve the Vue SPA for all non-API routes
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '^(?!api|storage|sanctum).*$');

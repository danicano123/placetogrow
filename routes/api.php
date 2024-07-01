<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MicrositeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/microsites/active', [MicrositeController::class, 'getActiveMicrosites']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(JwtMiddleware::class)->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('', [UserController::class, 'index'])->middleware(Authorize::using('read users'));
            Route::get('{id}', [UserController::class, 'show'])->middleware(Authorize::using('read users'));
            Route::patch('{id}', [UserController::class, 'update'])->middleware(Authorize::using('edit users'));
            Route::post('{userId}/assign-role', [UserController::class, 'assignRole'])->middleware(Authorize::using('edit users'));
            Route::post('{userId}/remove-role', [UserController::class, 'removeRole'])->middleware(Authorize::using('edit users'));
        });
        Route::prefix('microsites')->group(function () {
            Route::get('', [MicrositeController::class, 'index'])->middleware(Authorize::using('read microsites'));
            Route::get('{id}', [MicrositeController::class, 'show'])->middleware(Authorize::using('read microsites'));
            Route::post('', [MicrositeController::class, 'store'])->middleware(Authorize::using('create microsites'));
            Route::patch('{id}', [MicrositeController::class, 'update'])->middleware(Authorize::using('edit microsites'));
            Route::patch('{id}/is-active', [MicrositeController::class, 'toggleIsActive'])->middleware(Authorize::using('edit microsites'));
        });
    });
});

<?php

use App\Domain\Users\Controllers\AuthController;
use App\Domain\Microsites\Controllers\MicrositeController;
use App\Domain\Users\Controllers\UserController;
use App\Application\Middleware\JwtMiddleware;
use App\Domain\Forms\Controllers\FormController;
use App\Domain\Forms\Controllers\FormFieldController;
use App\Domain\Forms\Controllers\FormFieldOptionController;
use App\Domain\Payments\Controllers\PaymentController;
use App\Domain\Payments\Controllers\PaymentFieldController;
use Illuminate\Auth\Middleware\Authorize;
// use Illuminate\Http\Request;
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
        Route::prefix('forms')->group(function () {
            Route::get('{id}/full', [FormController::class, 'show']);
            Route::post('', [FormController::class, 'store'])->middleware(Authorize::using('create microsites'));
            Route::patch('{id}', [FormController::class, 'update'])->middleware(Authorize::using('edit microsites'));
            Route::delete('{id}', [FormController::class, 'destroy'])->middleware(Authorize::using('delete microsites'));
        });
        Route::prefix('form-fields')->group(function () {
            Route::get('{id}', [FormFieldController::class, 'show'])->middleware(Authorize::using('read microsites'));
            Route::post('', [FormFieldController::class, 'store'])->middleware(Authorize::using('create microsites'));
            Route::patch('{id}', [FormFieldController::class, 'update'])->middleware(Authorize::using('edit microsites'));
            Route::delete('{id}', [FormFieldController::class, 'destroy'])->middleware(Authorize::using('delete microsites'));
        });
        Route::prefix('form-field-options')->group(function () {
            Route::get('{id}', [FormFieldOptionController::class, 'show'])->middleware(Authorize::using('read microsites'));
            Route::get('form-field/{formFieldId}', [FormFieldOptionController::class, 'showByFormFieldId'])->middleware(Authorize::using('edit microsites'));
            Route::post('', [FormFieldOptionController::class, 'store'])->middleware(Authorize::using('create microsites'));
            Route::patch('{id}', [FormFieldOptionController::class, 'update'])->middleware(Authorize::using('edit microsites'));
            Route::delete('{id}', [FormFieldOptionController::class, 'destroy'])->middleware(Authorize::using('delete microsites'));
        });
        Route::prefix('payments')->group(function () {
            Route::get('{id}', [PaymentController::class, 'show']);
            Route::get('user/{document}', [PaymentController::class, 'getPaymentsByDocument']);
            Route::get('microsite/{micrositeId}', [PaymentController::class, 'getPaymentsByMicrosite'])->middleware(Authorize::using('read microsites'));
            Route::post('', [PaymentController::class, 'store']);
            Route::delete('{id}', [PaymentController::class, 'destroy'])->middleware(Authorize::using('delete microsites'));
        });
        Route::prefix('payment-fields')->group(function () {
            Route::post('', [PaymentFieldController::class, 'store']);
        });
    });
});

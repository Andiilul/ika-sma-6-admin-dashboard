<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])
        ->middleware('throttle:auth-login');

    Route::middleware(['auth:sanctum', 'token.idle'])->group(function () {
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::post('auth/logout-all', [AuthController::class, 'logoutAll']);
    });

});

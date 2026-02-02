<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\AlumniController;
use App\Http\Controllers\Api\v1\ActivityController;


Route::prefix('v1')->group(function () {

    Route::post('auth/login', [AuthController::class, 'login'])
        ->middleware('throttle:auth-login');

    Route::middleware(['auth:sanctum', 'token.idle'])->group(function () {
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::post('auth/logout-all', [AuthController::class, 'logoutAll']);
    });

    // PUBLIC
    Route::get('alumni', [AlumniController::class, 'index']);
    Route::get('alumni/{alumni}', [AlumniController::class, 'show']);
    // PUBLIC
    Route::get('activity', [ActivityController::class, 'index']);
    Route::get('activity/{activity}', [ActivityController::class, 'show']);
});

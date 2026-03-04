<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AlumniController;
use App\Http\Controllers\Api\V1\ActivityController;
use App\Http\Controllers\Api\V1\FundTransactionController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\KoperasiMemberController;
use App\Http\Controllers\Api\V1\KoperasiMitraController;

Route::prefix('v1')->group(function () {

    // =========================
    // AUTH
    // =========================
    Route::post('auth/login', [AuthController::class, 'login'])
        ->middleware('throttle:auth-login');

    Route::middleware(['auth:sanctum', 'token.idle'])->group(function () {
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::post('auth/logout-all', [AuthController::class, 'logoutAll']);
    });

    // =========================
    // PUBLIC: FUNDS (SUMMARY)
    // =========================
    Route::get('funds/summary', [FundTransactionController::class, 'summary']);

    // =========================
    // PUBLIC: NEWS (published only)
    // =========================
    Route::get('news', [NewsController::class, 'index']);
    Route::get('news/{slug}', [NewsController::class, 'show'])
        ->where('slug', '[A-Za-z0-9\-]+');

    // =========================
    // PUBLIC: ALUMNI
    // =========================
    Route::get('alumni', [AlumniController::class, 'index']);
    Route::get('alumni/{alumni}', [AlumniController::class, 'show']);

    // =========================
    // PUBLIC: ACTIVITY
    // =========================
    Route::get('activity', [ActivityController::class, 'index']);
    Route::get('activity/{activity}', [ActivityController::class, 'show']);

    // =========================
    // PUBLIC: KOPERASI
    // =========================
    Route::get('members', [KoperasiMemberController::class, 'index']);
    Route::get('members/{member}', [KoperasiMemberController::class, 'show'])
        ->whereUuid('member');

    Route::get('mitra', [KoperasiMitraController::class, 'index']);
    Route::get('mitra/{slug}', [KoperasiMitraController::class, 'show'])
        ->where('slug', '[A-Za-z0-9\-]+');
});
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('usersResources', UserController::class);
    });

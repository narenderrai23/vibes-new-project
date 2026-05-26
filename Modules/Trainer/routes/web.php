<?php

use Illuminate\Support\Facades\Route;
use Modules\Trainer\Http\Controllers\Auth\LoginController;
use Modules\Trainer\Http\Controllers\Backend\TrainersController;

/*
|--------------------------------------------------------------------------
| Trainer Module Routes
|--------------------------------------------------------------------------
*/

Route::prefix('trainer')->name('trainer.')->middleware('web')->group(function () {

    // ── Guest-only ────────────────────────────────────────────────────────
    Route::middleware('auth.guest:trainer')->group(function () {
        Route::get('login',  [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    });

    // ── Authenticated trainer routes ──────────────────────────────────────
    Route::middleware('auth.guard:trainer')->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('dashboard', fn () => view('trainer::portal.dashboard'))->name('dashboard');
    });
});

// ── Admin backend — manage trainers ──────────────────────────────────────────
Route::prefix('admin')->name('backend.')->middleware(['web', 'auth', 'can:view_backend'])->group(function () {
    $module = 'trainers';
    Route::get("{$module}/index_data",  [TrainersController::class, 'index_data'])->name("{$module}.index_data");
    Route::get("{$module}/index_list",  [TrainersController::class, 'index_list'])->name("{$module}.index_list");
    Route::get("{$module}/trashed",     [TrainersController::class, 'trashed'])->name("{$module}.trashed");
    Route::patch("{$module}/{id}/restore", [TrainersController::class, 'restore'])->name("{$module}.restore");
    Route::resource($module, TrainersController::class);
});

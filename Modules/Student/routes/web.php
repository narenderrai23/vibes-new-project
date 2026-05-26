<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\Auth\LoginController;
use Modules\Student\Http\Controllers\Backend\StudentsController;

/*
|--------------------------------------------------------------------------
| Student Module Routes
|--------------------------------------------------------------------------
*/

Route::prefix('student')->name('student.')->middleware('web')->group(function () {

    // ── Guest-only (redirect away if already logged in) ──────────────────
    Route::middleware('auth.guest:student')->group(function () {
        Route::get('login',  [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    });

    // ── Authenticated student routes ──────────────────────────────────────
    Route::middleware('auth.guard:student')->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('dashboard', fn () => view('student::portal.dashboard'))->name('dashboard');
    });
});

// ── Admin backend — manage students (web guard + view_backend) ────────────────
Route::prefix('admin')->name('backend.')->middleware(['web', 'auth', 'can:view_backend'])->group(function () {
    $module = 'students';
    Route::get("{$module}/index_data",  [StudentsController::class, 'index_data'])->name("{$module}.index_data");
    Route::get("{$module}/index_list",  [StudentsController::class, 'index_list'])->name("{$module}.index_list");
    Route::get("{$module}/trashed",     [StudentsController::class, 'trashed'])->name("{$module}.trashed");
    Route::patch("{$module}/{id}/restore", [StudentsController::class, 'restore'])->name("{$module}.restore");
    Route::resource($module, StudentsController::class);
});

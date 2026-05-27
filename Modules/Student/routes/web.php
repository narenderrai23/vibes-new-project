<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\Backend\StudentsController;

/*
|--------------------------------------------------------------------------
| Student Module Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

// ── Authenticated student routes ──────────────────────────────────────
Route::prefix('student')->name('student.')->middleware(['web', 'auth.guard:student'])->group(function () {
    Route::get('dashboard', fn () => view('student::portal.dashboard'))->name('dashboard');
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

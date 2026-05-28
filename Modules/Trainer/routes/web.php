<?php

use Illuminate\Support\Facades\Route;
use Modules\Trainer\Http\Controllers\Backend\TrainersController;

/*
|--------------------------------------------------------------------------
| Trainer Module Web Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

// ── Authenticated trainer routes ──────────────────────────────────────
Route::prefix('trainer')->name('trainer.')->middleware(['web', 'auth.guard:trainer'])->group(function () {
    Route::get('dashboard', fn () => view('trainer::portal.dashboard'))->name('dashboard');
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

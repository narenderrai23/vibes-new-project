<?php

use Illuminate\Support\Facades\Route;
use Modules\Trainer\Http\Controllers\Auth\LoginController;
use Modules\Trainer\Http\Controllers\Auth\LogoutController;

Route::prefix('trainer')->name('trainer.')->middleware('web')->group(function () {

    Route::middleware('auth.guest:trainer')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store']);
    });

    Route::middleware('auth.guard:trainer')->group(function () {
        Route::post('logout', LogoutController::class)->name('logout');
    });
});

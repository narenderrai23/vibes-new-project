<?php

use Illuminate\Support\Facades\Route;
use Modules\Center\Http\Controllers\Auth\LoginController;
use Modules\Center\Http\Controllers\Auth\LogoutController;

Route::prefix('center')->name('center.')->middleware('web')->group(function () {

    Route::middleware('auth.guest:center')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store']);
    });

    Route::middleware('auth.guard:center')->group(function () {
        Route::post('logout', LogoutController::class)->name('logout');
    });
});

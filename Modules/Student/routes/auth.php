<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\Auth\LoginController;
use Modules\Student\Http\Controllers\Auth\LogoutController;

Route::prefix('student')->name('student.')->middleware('web')->group(function () {

    Route::middleware('guest:student')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store']);
    });

    Route::middleware('auth.guard:student')->group(function () {
        Route::post('logout', LogoutController::class)->name('logout');
    });
});

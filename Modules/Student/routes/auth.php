<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\Auth\LoginController;
use Modules\Student\Http\Controllers\Auth\LogoutController;

Route::prefix('student')->name('student.')->middleware('web')->group(function () {

    Route::middleware('auth.guest:student')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store']);

        Route::get('login/otp', [LoginController::class, 'showOtpRequestForm'])->name('login.otp.request');
        Route::post('login/otp', [LoginController::class, 'sendOtp'])->name('login.otp.send');
        Route::get('login/otp/verify', [LoginController::class, 'showOtpVerifyForm'])->name('login.otp.verify');
        Route::post('login/otp/verify', [LoginController::class, 'verifyOtp'])->name('login.otp.authenticate');
    });

    Route::middleware('auth.guard:student')->group(function () {
        Route::post('logout', LogoutController::class)->name('logout');
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Modules\Center\Http\Controllers\Auth\LoginController;
use Modules\Center\Http\Controllers\Auth\LogoutController;

Route::prefix('center')->name('center.')->middleware('web')->group(function () {

    Route::middleware('auth.guest:center')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store']);

        Route::get('login/otp', [LoginController::class, 'showOtpRequestForm'])->name('login.otp.request');
        Route::post('login/otp', [LoginController::class, 'sendOtp'])->name('login.otp.send');
        Route::get('login/otp/verify', [LoginController::class, 'showOtpVerifyForm'])->name('login.otp.verify');
        Route::post('login/otp/verify', [LoginController::class, 'verifyOtp'])->name('login.otp.authenticate');
    });

    Route::middleware('auth.guard:center')->group(function () {
        Route::post('logout', LogoutController::class)->name('logout');
    });
});

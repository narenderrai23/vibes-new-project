<?php

use Illuminate\Support\Facades\Route;
use Modules\Trainer\Http\Controllers\Auth\LoginController;
use Modules\Trainer\Http\Controllers\Auth\LogoutController;

Route::prefix('trainer')->name('trainer.')->middleware('web')->group(function () {

    Route::middleware('auth.guest:trainer')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store']);

        Route::get('login/otp', [LoginController::class, 'showOtpRequestForm'])->name('login.otp.request');
        Route::post('login/otp', [LoginController::class, 'sendOtp'])->name('login.otp.send');
        Route::get('login/otp/verify', [LoginController::class, 'showOtpVerifyForm'])->name('login.otp.verify');
        Route::post('login/otp/verify', [LoginController::class, 'verifyOtp'])->name('login.otp.authenticate');
    });

    Route::middleware('auth.guard:trainer')->group(function () {
        Route::post('logout', LogoutController::class)->name('logout');
    });
});

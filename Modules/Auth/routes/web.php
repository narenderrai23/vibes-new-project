<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Module Routes
|--------------------------------------------------------------------------
|
| This module owns only the shared middleware (AuthenticateGuard,
| RedirectIfAuthenticated) and the admin dashboard route.
|
| Each role portal (Student, Trainer, Clinic) registers its own
| login/logout/dashboard routes inside its own module.
|
*/

// Admin dashboard — protected by the standard web guard
Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
    Route::get('dashboard', fn () => view('auth::portals.admin.dashboard'))->name('dashboard');
});

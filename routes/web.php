<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Named 'home' — used by auth redirects, layouts, etc.
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Language Switch
Route::get('language/{language}', [LanguageController::class, 'switch'])->name('language.switch');

Route::group(['as' => 'frontend.'], function () {
    // Also accessible as home
    // Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::middleware('auth')->group(function () {
        $module_name = 'users';

        Route::get('profile/edit', [UserProfileController::class, 'editProfile'])->name("{$module_name}.profileEdit");
        Route::post('profile/edit', [UserProfileController::class, 'updateProfile'])->name("{$module_name}.profileUpdate");

        Route::get('profile/change-password', [UserProfileController::class, 'changePassword'])->name("{$module_name}.changePassword");
        Route::post('profile/change-password', [UserProfileController::class, 'updatePassword'])->name("{$module_name}.changePasswordUpdate");

        Route::post('profile/resend-email', [UserProfileController::class, 'resendEmailConfirmation'])->name("{$module_name}.resendEmailConfirmation");
        Route::post('profile/unlink-provider', [UserProfileController::class, 'unlinkProvider'])->name("{$module_name}.unlinkProvider");

        Route::get('profile/{username?}', [UserProfileController::class, 'profile'])->name("{$module_name}.profile");
    });
});

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth', 'can:view_backend']], function () {
    Route::get('/', [BackendController::class, 'index'])->name('home');
    Route::get('dashboard', [BackendController::class, 'index'])->name('dashboard');

    // Notifications
    $module_name = 'notifications';
    Route::get("{$module_name}", [NotificationsController::class, 'index'])->name("{$module_name}.index");
    Route::get("{$module_name}/markAllAsRead", [NotificationsController::class, 'markAllAsRead'])->name("{$module_name}.markAllAsRead");
    Route::delete("{$module_name}/deleteAll", [NotificationsController::class, 'deleteAll'])->name("{$module_name}.deleteAll");
    Route::get("{$module_name}/{id}", [NotificationsController::class, 'show'])->name("{$module_name}.show");

    // Roles
    $module_name = 'roles';
    Route::resource("{$module_name}", RolesController::class);

    // Users
    $module_name = 'users';
    Route::get("{$module_name}/{id}/resend-email-confirmation", [BackendUserController::class, 'emailConfirmationResend'])->name("{$module_name}.emailConfirmationResend");
    Route::delete("{$module_name}/user-provider-destroy", [BackendUserController::class, 'userProviderDestroy'])->name("{$module_name}.userProviderDestroy");
    Route::get("{$module_name}/{id}/change-password", [BackendUserController::class, 'changePassword'])->name("{$module_name}.changePassword");
    Route::patch("{$module_name}/{id}/change-password", [BackendUserController::class, 'changePasswordUpdate'])->name("{$module_name}.changePasswordUpdate");
    Route::get("{$module_name}/trashed", [BackendUserController::class, 'trashed'])->name("{$module_name}.trashed");
    Route::patch("{$module_name}/{id}/trashed", [BackendUserController::class, 'restore'])->name("{$module_name}.restore");
    Route::get("{$module_name}/index_data", [BackendUserController::class, 'index_data'])->name("{$module_name}.index_data");
    Route::get("{$module_name}/index_list", [BackendUserController::class, 'index_list'])->name("{$module_name}.index_list");
    Route::patch("{$module_name}/{id}/block", [BackendUserController::class, 'block'])->name("{$module_name}.block")->middleware('can:block_users');
    Route::patch("{$module_name}/{id}/unblock", [BackendUserController::class, 'unblock'])->name("{$module_name}.unblock")->middleware('can:block_users');
    Route::resource("{$module_name}", BackendUserController::class);
});

<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use Modules\Settings\Http\Controllers\SettingController;
=======
use Nasirkhan\ModuleManager\Modules\Settings\Http\Controllers\SettingController;
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Backend Routes
 * These routes need view-backend permission
 */
Route::group(['prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend']], function () {
    /*
     * Settings Routes
     */
    Route::group(['middleware' => ['can:edit_settings']], function () {
        $module_name = 'settings';
        Route::get("{$module_name}", [SettingController::class, 'index'])->name("{$module_name}.index");
        Route::post("{$module_name}", [SettingController::class, 'store'])->name("{$module_name}.store");
    });
});

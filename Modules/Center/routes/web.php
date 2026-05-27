<?php

use Illuminate\Support\Facades\Route;
use Modules\Center\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Center Module Web Routes
|--------------------------------------------------------------------------
*/

<<<<<<< HEAD
require __DIR__.'/auth.php';

// ── Authenticated center routes ──────────────────────────────────────
Route::prefix('center')->name('center.')->middleware(['web', 'auth.guard:center'])->group(function () {
    Route::get('dashboard', fn () => view('center::portal.dashboard'))->name('dashboard');
=======
// ── Center portal — dedicated 'center' guard ──────────────────────────────────
Route::prefix('center')->name('center.')->middleware('web')->group(function () {

    Route::middleware('auth.guest:center')->group(function () {
        Route::get('login',  [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth.guard:center')->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('dashboard', fn () => view('center::portal.dashboard'))->name('dashboard');
    });
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
});

/*
 * Frontend Routes
 */
Route::group([
    'namespace'  => '\Modules\Center\Http\Controllers\Frontend',
    'as'         => 'frontend.',
    'middleware' => 'web',
    'prefix'     => '',
], function () {

    $module_name     = 'centers';
    $controller_name = 'CentersController';
    Route::get("$module_name",              ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::get("$module_name/{id}/{slug?}", ['as' => "$module_name.show",  'uses' => "$controller_name@show"]);
});

/*
 * Backend Routes
 */
Route::group([
    'namespace'  => '\Modules\Center\Http\Controllers\Backend',
    'as'         => 'backend.',
    'middleware' => ['web', 'auth', 'can:view_backend'],
    'prefix'     => 'admin',
], function () {

    /*
     * Centers
     */
    $module_name     = 'centers';
    $controller_name = 'CentersController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed",    ['as' => "$module_name.trashed",    'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::resource("$module_name", "$controller_name");

    /*
     * Countries
     */
    $module_name     = 'countries';
    $controller_name = 'CountriesController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed",    ['as' => "$module_name.trashed",    'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::resource("$module_name", "$controller_name");

    /*
     * States
     */
    $module_name     = 'states';
    $controller_name = 'StatesController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed",    ['as' => "$module_name.trashed",    'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::resource("$module_name", "$controller_name");

    /*
     * Regionals
     */
    $module_name     = 'regionals';
    $controller_name = 'RegionalsController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed",    ['as' => "$module_name.trashed",    'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::resource("$module_name", "$controller_name");

    /*
     * AJAX helpers — dependent dropdowns
     */
    Route::get('ajax/states-by-country/{country_id}', ['as' => 'ajax.states_by_country', 'uses' => 'AjaxController@statesByCountry']);
    Route::get('ajax/centers-by-regional/{regional_id}', ['as' => 'ajax.centers_by_regional', 'uses' => 'AjaxController@centersByRegional']);
});

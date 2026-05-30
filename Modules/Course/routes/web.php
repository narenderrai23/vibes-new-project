<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\Backend\CourseContentsController;
use Modules\Course\Http\Controllers\Backend\CourseModulesController;
use Modules\Course\Http\Controllers\Portal\ContentStreamController;
use Modules\Course\Http\Controllers\Portal\CoursesController;

// ── Student-facing course portal ──────────────────────────────────────
Route::prefix('student/portal')->name('student.portal.')->middleware(['web', 'auth.guard:student'])->group(function () {
    Route::get('courses', [CoursesController::class, 'index'])->name('courses.index');
    Route::get('courses/{course}', [CoursesController::class, 'show'])->name('courses.show');
    Route::get('courses/{course}/modules/{module}', [CoursesController::class, 'module'])->name('courses.module');
    Route::get('courses/{course}/modules/{module}/contents/{content}', [CoursesController::class, 'content'])->name('courses.content');

    Route::get('content/{content}/stream', [ContentStreamController::class, 'stream'])->name('content.stream');
});

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
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Course\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {
    /*
     *
     *  Frontend Courses Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'courses';
    $controller_name = 'CoursesController';
    Route::get("$module_name", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::get("$module_name/{id}/{slug?}", ['as' => "$module_name.show", 'uses' => "$controller_name@show"]);
});

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Course\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Courses Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'courses';
    $controller_name = 'CoursesController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::resource("$module_name", "$controller_name");

    /*
     *  Course Modules & Content (managed inline on the course show page)
     * ---------------------------------------------------------------------
     */
    Route::post('courses/{course}/modules', [CourseModulesController::class, 'store'])
        ->name('courses.modules.store');
    Route::delete('courses/{course}/modules/{module}', [CourseModulesController::class, 'destroy'])
        ->name('courses.modules.destroy');

    Route::post('courses/{course}/modules/{module}/contents', [CourseContentsController::class, 'store'])
        ->name('courses.modules.contents.store');
    Route::delete('courses/{course}/modules/{module}/contents/{content}', [CourseContentsController::class, 'destroy'])
        ->name('courses.modules.contents.destroy');
});

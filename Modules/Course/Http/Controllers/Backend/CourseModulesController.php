<?php

namespace Modules\Course\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseModule;

class CourseModulesController extends Controller
{
    /**
     * Store a new module under the given course.
     */
    public function store(Request $request, int $course): RedirectResponse
    {
        $courseModel = Course::findOrFail($course);

        $request->validate([
            'title'                     => ['required', 'string', 'max:255'],
            'summary'                   => ['nullable', 'string', 'max:1000'],
            'kind'                      => ['required', 'in:theory,practical,live,assessment'],
            'requires_trainer_approval' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Module title is required.',
            'kind.in'        => 'Please select a valid module kind.',
        ]);

        $module = DB::transaction(function () use ($courseModel, $request) {
            $nextPosition = (int) $courseModel->modules()->max('position') + 1;

            return $courseModel->modules()->create([
                'title'                     => $request->input('title'),
                'summary'                   => $request->input('summary'),
                'position'                  => $nextPosition,
                'kind'                      => $request->input('kind'),
                'requires_trainer_approval' => $request->boolean('requires_trainer_approval'),
            ]);
        });

        flash('Module added to course.')->success()->important();

        logUserAccess("Course Module Store | Course: {$courseModel->id} | Module: {$module->id}");

        return redirect()->route('backend.courses.show', $courseModel->id);
    }

    /**
     * Soft-delete a module (and its contents cascade via soft deletes).
     */
    public function destroy(int $course, int $module): RedirectResponse
    {
        $courseModel = Course::findOrFail($course);

        $courseModule = CourseModule::where('course_id', $courseModel->id)
            ->findOrFail($module);

        DB::transaction(function () use ($courseModule) {
            // Soft-delete child contents first, then the module.
            $courseModule->contents()->delete();
            $courseModule->delete();
        });

        flash('Module removed.')->success()->important();

        logUserAccess("Course Module Destroy | Course: {$courseModel->id} | Module: {$courseModule->id}");

        return redirect()->route('backend.courses.show', $courseModel->id);
    }
}

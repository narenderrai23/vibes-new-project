<?php

namespace Modules\Course\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Models\CourseContent;
use Modules\Course\Models\CourseEnrollment;
use Modules\Course\Models\CourseModule;

class CoursesController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        $enrollments = CourseEnrollment::with('course')
            ->where('student_id', $student->id)
            ->active()
            ->get();

        return view('course::portal.courses.index', compact('enrollments'));
    }

    public function show(int $courseId)
    {
        $student = Auth::guard('student')->user();

        $enrollment = CourseEnrollment::with(['course.modules'])
            ->where('student_id', $student->id)
            ->where('course_id', $courseId)
            ->active()
            ->firstOrFail();

        $modules = $enrollment->course->modules->map(function (CourseModule $m) use ($enrollment) {
            $m->unlocked = $enrollment->isModuleUnlocked($m);
            return $m;
        });

        return view('course::portal.courses.show', compact('enrollment', 'modules'));
    }

    public function module(int $courseId, int $moduleId)
    {
        $student = Auth::guard('student')->user();

        $enrollment = CourseEnrollment::with('course')
            ->where('student_id', $student->id)
            ->where('course_id', $courseId)
            ->active()
            ->firstOrFail();

        $module = CourseModule::with('contents')
            ->where('course_id', $courseId)
            ->findOrFail($moduleId);

        abort_unless($enrollment->isModuleUnlocked($module), 423, 'Module is locked.');

        $contents = $module->contents->map(function (CourseContent $c) use ($enrollment) {
            $c->released = $c->isReleasedFor($enrollment);
            return $c;
        });

        return view('course::portal.courses.module', compact('enrollment', 'module', 'contents'));
    }

    public function content(int $courseId, int $moduleId, int $contentId)
    {
        $student = Auth::guard('student')->user();

        $enrollment = CourseEnrollment::where('student_id', $student->id)
            ->where('course_id', $courseId)
            ->active()
            ->firstOrFail();

        $module = CourseModule::where('course_id', $courseId)->findOrFail($moduleId);
        abort_unless($enrollment->isModuleUnlocked($module), 423, 'Module is locked.');

        $content = CourseContent::where('course_module_id', $module->id)->findOrFail($contentId);
        abort_unless($content->isReleasedFor($enrollment), 425, 'Content not yet released.');

        return view('course::portal.courses.content', compact('enrollment', 'module', 'content'));
    }
}

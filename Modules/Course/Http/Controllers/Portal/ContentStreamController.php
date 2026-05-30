<?php

namespace Modules\Course\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Course\Models\ContentView;
use Modules\Course\Models\CourseContent;
use Modules\Course\Models\CourseEnrollment;
use Modules\Course\Models\CourseModule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContentStreamController extends Controller
{
    public function stream(Request $request, int $contentId): StreamedResponse
    {
        abort_unless($request->hasValidSignature(), 403, 'Invalid or expired stream link.');

        $student = Auth::guard('student')->user();
        abort_unless($student, 401);

        $content = CourseContent::findOrFail($contentId);
        $module = CourseModule::findOrFail($content->course_module_id);

        $enrollment = CourseEnrollment::where('student_id', $student->id)
            ->where('course_id', $module->course_id)
            ->active()
            ->firstOrFail();

        abort_unless($enrollment->isModuleUnlocked($module), 423);
        abort_unless($content->isReleasedFor($enrollment), 425);

        $disk = Storage::disk($content->storage_disk);
        abort_unless($disk->exists($content->storage_path), 404);

        $this->logView($enrollment, $content);

        $mime = $content->mime ?: $disk->mimeType($content->storage_path) ?: 'application/octet-stream';
        $size = $content->size_bytes ?: $disk->size($content->storage_path);

        $stream = $disk->readStream($content->storage_path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Content-Disposition' => 'inline; filename="protected"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, private, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Accept-Ranges' => 'none',
        ]);
    }

    public static function signedUrl(CourseContent $content, int $ttlSeconds = 300): string
    {
        return \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'student.portal.content.stream',
            Carbon::now()->addSeconds($ttlSeconds),
            ['content' => $content->id]
        );
    }

    private function logView(CourseEnrollment $enrollment, CourseContent $content): void
    {
        $view = ContentView::firstOrNew([
            'course_enrollment_id' => $enrollment->id,
            'course_content_id' => $content->id,
        ]);

        $now = now();
        if (! $view->exists) {
            $view->first_viewed_at = $now;
        }
        $view->last_viewed_at = $now;
        $view->save();
    }
}

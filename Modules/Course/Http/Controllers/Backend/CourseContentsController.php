<?php

namespace Modules\Course\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseContent;
use Modules\Course\Models\CourseModule;

class CourseContentsController extends Controller
{
    /**
     * Allowed content types and the upload validation rule applied to the file
     * for each. Files are kept on the private "local" disk and served only via
     * the signed-URL streamer (ContentStreamController).
     */
    private const TYPE_FILE_RULES = [
        'video'   => 'mimetypes:video/mp4,video/webm,video/quicktime',
        'reel'    => 'mimetypes:video/mp4,video/webm,video/quicktime',
        'audio'   => 'mimetypes:audio/mpeg,audio/mp4,audio/wav,audio/x-wav',
        'pdf'     => 'mimes:pdf',
        'ppt'     => 'mimes:ppt,pptx',
        'mindmap' => 'mimes:pdf,png,jpg,jpeg',
        'notes'   => 'mimes:pdf,png,jpg,jpeg',
    ];

    /**
     * Upload a piece of content (video, audio, pdf, ...) into a course module.
     */
    public function store(Request $request, int $course, int $module): RedirectResponse
    {
        $courseModel = Course::findOrFail($course);

        $courseModule = CourseModule::where('course_id', $courseModel->id)
            ->findOrFail($module);

        // Validate base fields first so we know the type/source before picking
        // the file rule (or skipping the file entirely for a Vimeo link).
        $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'type'         => ['required', 'in:'.implode(',', array_keys(self::TYPE_FILE_RULES))],
            'source'       => ['required', 'in:upload,vimeo'],
            'summary'      => ['nullable', 'string', 'max:1000'],
            'release_day'  => ['nullable', 'integer', 'min:1', 'max:3650'],
            'downloadable' => ['nullable', 'boolean'],
            'language'     => ['nullable', 'string', 'max:10'],
        ], [
            'title.required' => 'Content title is required.',
            'type.required'  => 'Content type is required.',
            'type.in'        => 'Please select a valid content type.',
            'source.in'      => 'Please select a valid content source.',
        ]);

        $source = $request->input('source');
        $isVimeo = $source === 'vimeo';
        $vimeoId = null;

        // Vimeo is only meaningful for playable video content.
        if ($isVimeo && ! in_array($request->input('type'), ['video', 'reel'], true)) {
            return back()
                ->withErrors(['source' => 'Vimeo links are only available for video or reel content.'])
                ->withInput();
        }

        if ($isVimeo) {
            $request->validate([
                'vimeo_url' => ['required', 'string', 'max:500'],
            ], [
                'vimeo_url.required' => 'Please paste a Vimeo video link.',
            ]);

            $vimeoId = CourseContent::parseVimeoId($request->input('vimeo_url'));

            if (! $vimeoId) {
                return back()
                    ->withErrors(['vimeo_url' => 'That does not look like a valid Vimeo link or id.'])
                    ->withInput();
            }
        } else {
            $fileRule = self::TYPE_FILE_RULES[$request->input('type')];

            // Up to ~500 MB. Note: PHP upload_max_filesize / post_max_size must allow this.
            $request->validate([
                'file' => ['required', 'file', 'max:512000', $fileRule],
            ], [
                'file.required'  => 'Please choose a file to upload.',
                'file.max'       => 'The file may not be larger than 500 MB.',
                'file.mimetypes' => 'The uploaded file type does not match the selected content type.',
                'file.mimes'     => 'The uploaded file type does not match the selected content type.',
            ]);
        }

        $content = DB::transaction(function () use ($request, $courseModel, $courseModule, $isVimeo, $vimeoId) {
            $nextPosition = (int) $courseModule->contents()->max('position') + 1;

            $attributes = [
                'title'        => $request->input('title'),
                'summary'      => $request->input('summary'),
                'type'         => $request->input('type'),
                'source'       => $isVimeo ? 'vimeo' : 'upload',
                'position'     => $nextPosition,
                'release_day'  => (int) ($request->input('release_day') ?: 1),
                'downloadable' => $isVimeo ? false : $request->boolean('downloadable'),
                'language'     => $request->input('language') ?: ($courseModel->language_default ?? 'en'),
            ];

            if ($isVimeo) {
                $attributes += [
                    'external_id'  => $vimeoId,
                    'external_url' => trim($request->input('vimeo_url')),
                    'storage_disk' => 'local',
                    'storage_path' => null,
                ];
            } else {
                $uploaded = $request->file('file');

                // Stored on the private "local" disk (storage/app/...), never web-served.
                $path = $uploaded->store("course-content/{$courseModel->id}", 'local');

                $attributes += [
                    'storage_disk' => 'local',
                    'storage_path' => $path,
                    'mime'         => $uploaded->getMimeType(),
                    'size_bytes'   => $uploaded->getSize(),
                ];
            }

            return $courseModule->contents()->create($attributes);
        });

        flash('Content uploaded.')->success()->important();

        logUserAccess("Course Content Store | Course: {$courseModel->id} | Module: {$courseModule->id} | Content: {$content->id}");

        return redirect()->route('backend.courses.show', $courseModel->id);
    }

    /**
     * Soft-delete a content row. The stored file is intentionally kept so the
     * record can be restored; file cleanup happens only on force-delete (not here).
     */
    public function destroy(int $course, int $module, int $content): RedirectResponse
    {
        $courseModel = Course::findOrFail($course);

        $courseModule = CourseModule::where('course_id', $courseModel->id)
            ->findOrFail($module);

        $courseContent = CourseContent::where('course_module_id', $courseModule->id)
            ->findOrFail($content);

        $courseContent->delete();

        flash('Content removed.')->success()->important();

        logUserAccess("Course Content Destroy | Course: {$courseModel->id} | Content: {$courseContent->id}");

        return redirect()->route('backend.courses.show', $courseModel->id);
    }
}

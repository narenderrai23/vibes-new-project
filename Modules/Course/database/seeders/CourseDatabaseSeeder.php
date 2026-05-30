<?php

namespace Modules\Course\database\seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Course\Models\ContentView;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseContent;
use Modules\Course\Models\CourseEnrollment;
use Modules\Course\Models\CourseModule;
use Modules\Course\Models\ModuleCompletion;
use Modules\Student\Models\Student;

class CourseDatabaseSeeder extends Seeder
{
    /**
     * Run command:
     * php artisan db:seed --class="Modules\\Course\\database\\seeders\\CourseDatabaseSeeder"
     *
     * Seeds every table owned by the Course module:
     *   courses → course_modules → course_contents
     *   course_enrollments → module_completions → content_views
     *
     * All inserts are idempotent (updateOrCreate / firstOrCreate) so the seeder
     * is safe to re-run. Enrollment-side data is only seeded when students exist
     * (a couple of demo students are created if the table is empty).
     */
    public function run(): void
    {
        $now = Carbon::now();

        $courses = $this->seedCourses($now);
        $this->seedModulesAndContent($courses);
        $this->seedEnrollments($now);

        if (! app()->runningUnitTests()) {
            $this->command?->info('  ✓ Course module seeded (courses, modules, content, enrollments, completions, views).');
        }
    }

    /**
     * Seed the course catalogue and return the persisted models keyed by slug.
     *
     * @return array<string, Course>
     */
    private function seedCourses(Carbon $now): array
    {
        $courses = [
            [
                'title'               => 'Foundations of Wellness',
                'summary'             => 'A beginner-friendly introduction to holistic wellness and healthy living.',
                'description'         => 'This course covers the core pillars of wellness — nutrition, movement, sleep, and stress management. Learners build sustainable daily habits through guided lessons and practical assignments.',
                'cover_image'         => null,
                'duration_weeks'      => 6,
                'fee_min'             => 4999.00,
                'fee_max'             => 7999.00,
                'language_default'    => 'en',
                'languages_supported' => ['en', 'hi'],
                'status'              => 1,
            ],
            [
                'title'               => 'Yoga & Mindfulness',
                'summary'             => 'Develop a consistent yoga and meditation practice for body and mind.',
                'description'         => 'From basic asanas to breathwork and guided meditation, this programme helps learners improve flexibility, focus, and emotional balance. Includes weekly live practice sessions.',
                'cover_image'         => null,
                'duration_weeks'      => 8,
                'fee_min'             => 5999.00,
                'fee_max'             => 9999.00,
                'language_default'    => 'en',
                'languages_supported' => ['en', 'hi'],
                'status'              => 1,
            ],
            [
                'title'               => 'Strength & Conditioning',
                'summary'             => 'Build strength, endurance, and functional fitness from the ground up.',
                'description'         => 'A structured strength-training programme covering progressive overload, mobility, and recovery. Suitable for learners with access to basic gym equipment.',
                'cover_image'         => null,
                'duration_weeks'      => 12,
                'fee_min'             => 8999.00,
                'fee_max'             => 14999.00,
                'language_default'    => 'en',
                'languages_supported' => ['en'],
                'status'              => 1,
            ],
            [
                'title'               => 'Nutrition Essentials',
                'summary'             => 'Understand balanced nutrition and plan everyday meals with confidence.',
                'description'         => 'Learn the fundamentals of macronutrients, portion control, and meal planning. The course includes downloadable meal templates and a practical assessment.',
                'cover_image'         => null,
                'duration_weeks'      => 4,
                'fee_min'             => 3499.00,
                'fee_max'             => 4999.00,
                'language_default'    => 'en',
                'languages_supported' => ['en', 'hi'],
                'status'              => 1,
            ],
            [
                'title'               => 'Advanced Personal Training',
                'summary'             => 'A professional pathway for aspiring certified personal trainers.',
                'description'         => 'Covers anatomy, programme design, client assessment, and coaching methodology. Includes practical modules that require trainer approval before progression.',
                'cover_image'         => null,
                'duration_weeks'      => 16,
                'fee_min'             => 19999.00,
                'fee_max'             => 29999.00,
                'language_default'    => 'en',
                'languages_supported' => ['en'],
                'status'              => 1,
            ],
            [
                'title'               => 'Stress Management & Recovery',
                'summary'             => 'Practical techniques to manage stress and support recovery (archived).',
                'description'         => 'An older programme focused on relaxation techniques, sleep hygiene, and active recovery. Kept inactive for reference.',
                'cover_image'         => null,
                'duration_weeks'      => 5,
                'fee_min'             => 2999.00,
                'fee_max'             => 3999.00,
                'language_default'    => 'en',
                'languages_supported' => ['en'],
                'status'              => 0,
            ],
        ];

        $persisted = [];

        foreach ($courses as $course) {
            $course['slug']       = Str::slug($course['title']);
            $course['created_at'] = $now;
            $course['updated_at'] = $now;

            $persisted[$course['slug']] = Course::query()->updateOrCreate(
                ['slug' => $course['slug']],
                $course
            );
        }

        return $persisted;
    }

    /**
     * Seed three modules per active course, each with a couple of content items.
     *
     * Videos are seeded as Vimeo links (source = vimeo) so no backing files are
     * required and the records play through the portal's Vimeo embed. Non-video
     * items are skipped here because the protected streamer needs a real file on
     * disk — those are added by admins through the upload form.
     *
     * @param array<string, Course> $courses
     */
    private function seedModulesAndContent(array $courses): void
    {
        // A small pool of public Vimeo sample videos to reference.
        $sampleVimeoIds = ['76979871', '22439234', '125095515', '174312494', '169599296'];

        foreach ($courses as $course) {
            if ((int) $course->status !== 1) {
                continue; // leave the archived course without modules
            }

            $modules = [
                ['title' => 'Module 1 · Introduction',  'kind' => 'theory',     'requires_trainer_approval' => false],
                ['title' => 'Module 2 · Core Practice', 'kind' => 'practical',  'requires_trainer_approval' => false],
                ['title' => 'Module 3 · Assessment',    'kind' => 'assessment', 'requires_trainer_approval' => true],
            ];

            foreach ($modules as $position => $moduleData) {
                $module = CourseModule::query()->updateOrCreate(
                    [
                        'course_id' => $course->id,
                        'position'  => $position + 1,
                    ],
                    [
                        'title'                     => $moduleData['title'],
                        'summary'                   => $moduleData['title'].' for '.$course->title.'.',
                        'kind'                      => $moduleData['kind'],
                        'requires_trainer_approval' => $moduleData['requires_trainer_approval'],
                    ]
                );

                // Two video lessons per module, sourced from Vimeo.
                for ($i = 1; $i <= 2; $i++) {
                    $vimeoId = $sampleVimeoIds[($position + $i) % count($sampleVimeoIds)];

                    CourseContent::query()->updateOrCreate(
                        [
                            'course_module_id' => $module->id,
                            'position'         => $i,
                        ],
                        [
                            'title'        => "Lesson {$i} — {$moduleData['title']}",
                            'summary'      => 'Sample lesson video for demo purposes.',
                            'type'         => 'video',
                            'source'       => 'vimeo',
                            'external_id'  => $vimeoId,
                            'external_url' => "https://vimeo.com/{$vimeoId}",
                            'storage_disk' => 'local',
                            'storage_path' => null,
                            'mime'         => null,
                            'size_bytes'   => null,
                            'release_day'  => ($position * 7) + $i,
                            'downloadable' => false,
                            'language'     => $course->language_default ?? 'en',
                        ]
                    );
                }
            }
        }
    }

    /**
     * Seed enrollments with realistic per-student progress: a couple of demo
     * students are enrolled into the first active courses, the first module is
     * marked complete, and the watched content gets a content_view row.
     */
    private function seedEnrollments(Carbon $now): void
    {
        $students = $this->resolveStudents();

        if ($students->isEmpty()) {
            if (! app()->runningUnitTests()) {
                $this->command?->warn('  • Skipped enrollments: no students available to enroll.');
            }

            return;
        }

        $activeCourses = Course::query()
            ->where('status', 1)
            ->orderBy('id')
            ->take(2)
            ->get();

        foreach ($students as $student) {
            foreach ($activeCourses as $course) {
                $startedAt = $now->copy()->subDays(14);

                $enrollment = CourseEnrollment::query()->updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'course_id'  => $course->id,
                    ],
                    [
                        'started_at' => $startedAt,
                        'expires_at' => $startedAt->copy()->addWeeks($course->duration_weeks),
                        'status'     => 1, // Active
                    ]
                );

                $firstModule = CourseModule::query()
                    ->where('course_id', $course->id)
                    ->orderBy('position')
                    ->first();

                if (! $firstModule) {
                    continue;
                }

                // Mark the first module complete so module 2 unlocks in the portal.
                ModuleCompletion::query()->updateOrCreate(
                    [
                        'course_enrollment_id' => $enrollment->id,
                        'course_module_id'     => $firstModule->id,
                    ],
                    [
                        'completed_at'     => $now->copy()->subDays(7),
                        'trainer_approved' => $firstModule->requires_trainer_approval,
                    ]
                );

                // Record a viewing entry for each content item in the first module.
                foreach ($firstModule->contents as $index => $content) {
                    ContentView::query()->updateOrCreate(
                        [
                            'course_enrollment_id' => $enrollment->id,
                            'course_content_id'    => $content->id,
                        ],
                        [
                            'watch_percent'   => 100,
                            'first_viewed_at' => $now->copy()->subDays(8),
                            'last_viewed_at'  => $now->copy()->subDays(7),
                        ]
                    );
                }
            }
        }
    }

    /**
     * Return students to enroll, creating two demo students if the table is empty
     * so the enrollment-side tables still get populated on a fresh database.
     */
    private function resolveStudents()
    {
        $existing = Student::query()->orderBy('id')->take(2)->get();

        if ($existing->isNotEmpty()) {
            return $existing;
        }

        $demos = [
            [
                'name'              => 'Demo Student One',
                'email'             => 'student.one@example.com',
                'mobile'            => '9000000001',
                'enrollment_number' => 'VIBES-DEMO-0001',
            ],
            [
                'name'              => 'Demo Student Two',
                'email'             => 'student.two@example.com',
                'mobile'            => '9000000002',
                'enrollment_number' => 'VIBES-DEMO-0002',
            ],
        ];

        $created = collect();

        foreach ($demos as $demo) {
            $student = Student::query()->firstOrCreate(
                ['email' => $demo['email']],
                [
                    // The 'password' attribute is cast to 'hashed', so a plain
                    // value is hashed automatically on save — no double hashing.
                    'name'              => $demo['name'],
                    'password'          => 'password',
                    'mobile'            => $demo['mobile'],
                    'enrollment_number' => $demo['enrollment_number'],
                    'status'            => 1,
                ]
            );

            // email_verified_at is not mass-assignable; set it directly.
            if ($student->wasRecentlyCreated && ! $student->email_verified_at) {
                $student->forceFill(['email_verified_at' => Carbon::now()])->save();
            }

            $created->push($student);
        }

        return $created;
    }
}

<?php

namespace Modules\Student\database\seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Student\Models\Student;

class StudentDatabaseSeeder extends Seeder
{
    /**
     * Run command:
     * php artisan db:seed --class="Modules\\Student\\database\\seeders\\StudentDatabaseSeeder"
     */
    public function run(): void
    {
        $now = Carbon::now();

        $students = [
            [
                'name'              => 'Demo Student',
                'email'             => 'student@student.com',
                'email_verified_at' => $now,
                'password'          => 'student',
                'mobile'            => '9000000001',
                'gender'            => 'female',
                'date_of_birth'     => '2001-04-12',
                'address'           => 'Demo student address',
                'enrollment_number' => 'STU100001',
                'course'            => 'Wellness Program',
                'batch'             => 'Batch A',
                'status'            => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Sample Student',
                'email'             => 'sample.student@example.com',
                'email_verified_at' => $now,
                'password'          => 'student',
                'mobile'            => '9000000002',
                'gender'            => 'male',
                'date_of_birth'     => '2000-08-20',
                'address'           => 'Sample student address',
                'enrollment_number' => 'STU100002',
                'course'            => 'Fitness Program',
                'batch'             => 'Batch B',
                'status'            => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Priya Sharma',
                'email'             => 'priya.sharma@example.com',
                'email_verified_at' => $now,
                'password'          => 'student',
                'mobile'            => '9000000003',
                'gender'            => 'female',
                'date_of_birth'     => '1999-11-05',
                'address'           => 'Mumbai, Maharashtra',
                'enrollment_number' => 'STU100003',
                'course'            => 'Yoga Program',
                'batch'             => 'Batch A',
                'status'            => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ];

        foreach ($students as $student) {
            Student::query()->updateOrCreate(
                ['email' => $student['email']],
                $student
            );
        }

        if (! app()->runningUnitTests()) {
            $this->command?->info('  ✓ Student accounts seeded (3 records).');
        }
    }
}

<?php

namespace Modules\Trainer\database\seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Trainer\Models\Trainer;

class TrainerDatabaseSeeder extends Seeder
{
    /**
     * Run command:
     * php artisan db:seed --class="Modules\\Trainer\\database\\seeders\\TrainerDatabaseSeeder"
     */
    public function run(): void
    {
        $now = Carbon::now();

        $trainers = [
            [
                'name'             => 'Demo Trainer',
                'email'            => 'trainer@trainer.com',
                'email_verified_at'=> $now,
                'password'         => 'trainer',
                'mobile'           => '9000000011',
                'gender'           => 'male',
                'date_of_birth'    => '1988-03-18',
                'address'          => 'Demo trainer address',
                'specialization'   => 'Wellness Coaching',
                'qualification'    => 'Certified Wellness Trainer',
                'experience_years' => 8,
                'bio'              => 'Demo trainer account for local testing.',
                'status'           => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'name'             => 'Sample Trainer',
                'email'            => 'sample.trainer@example.com',
                'email_verified_at'=> $now,
                'password'         => 'trainer',
                'mobile'           => '9000000012',
                'gender'           => 'female',
                'date_of_birth'    => '1990-09-10',
                'address'          => 'Sample trainer address',
                'specialization'   => 'Fitness Training',
                'qualification'    => 'Certified Fitness Trainer',
                'experience_years' => 6,
                'bio'              => 'Sample trainer account for local testing.',
                'status'           => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'name'             => 'Rahul Verma',
                'email'            => 'rahul.verma@example.com',
                'email_verified_at'=> $now,
                'password'         => 'trainer',
                'mobile'           => '9000000013',
                'gender'           => 'male',
                'date_of_birth'    => '1985-06-22',
                'address'          => 'Delhi, India',
                'specialization'   => 'Physiotherapy',
                'qualification'    => 'BPT, MPT',
                'experience_years' => 12,
                'bio'              => 'Senior physiotherapist with 12 years experience.',
                'status'           => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ];

        foreach ($trainers as $trainer) {
            Trainer::query()->updateOrCreate(
                ['email' => $trainer['email']],
                $trainer
            );
        }

        if (! app()->runningUnitTests()) {
            $this->command?->info('  ✓ Trainer accounts seeded (3 records).');
        }
    }
}

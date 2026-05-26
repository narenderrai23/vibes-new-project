<?php

namespace Modules\Center\database\seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Center\Models\Center;
use Modules\Center\Models\CenterUser;

class CenterUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Get first center for demo account
        $firstCenter = Center::first();

        $users = [
            [
                'center_id'         => $firstCenter?->id,
                'name'              => 'Demo Center Manager',
                'email'             => 'center@center.com',
                'email_verified_at' => $now,
                'password'          => 'center',
                'mobile'            => '9000000021',
                'role'              => 'manager',
                'status'            => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'center_id'         => $firstCenter?->id,
                'name'              => 'Demo Receptionist',
                'email'             => 'receptionist@center.com',
                'email_verified_at' => $now,
                'password'          => 'center',
                'mobile'            => '9000000022',
                'role'              => 'receptionist',
                'status'            => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'center_id'         => $firstCenter?->id,
                'name'              => 'Demo Staff',
                'email'             => 'staff@center.com',
                'email_verified_at' => $now,
                'password'          => 'center',
                'mobile'            => '9000000023',
                'role'              => 'staff',
                'status'            => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ];

        foreach ($users as $data) {
            CenterUser::query()->updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        if (! app()->runningUnitTests()) {
            $this->command?->info('Center user accounts seeded.');
        }
    }
}

<?php

namespace Database\Seeders\Auth;

use App\Events\Backend\UserCreated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 *
 * Run command:
 * php artisan db:seed --class="Database\\Seeders\\Auth\\UserTableSeeder"
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => '100001',
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => 'admin',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => '100002',
                'name' => 'Admin Istrator',
                'email' => 'admin@admin.com',
                'password' => 'admin',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => '100003',
                'name' => 'Manager User',
                'email' => 'manager@manager.com',
                'password' => 'admin',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => '100004',
                'name' => 'Executive User',
                'email' => 'executive@executive.com',
                'password' => 'admin',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => '100005',
                'name' => 'General User',
                'email' => 'user@user.com',
                'password' => 'admin',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($users as $user_data) {
            $user = User::query()->updateOrCreate(
                ['email' => $user_data['email']],
                $user_data
            );

            if ($user->wasRecentlyCreated) {
                event(new UserCreated($user));
            }
        }
    }
}

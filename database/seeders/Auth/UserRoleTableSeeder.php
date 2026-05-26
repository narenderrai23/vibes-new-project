<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class UserRoleTableSeeder.
 *
 * Run command:
 * php artisan db:seed --class="Database\\Seeders\\Auth\\UserRoleTableSeeder"
 */
class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        User::where('email', 'admin@gmail.com')->firstOrFail()->assignRole('super admin');
        User::where('email', 'admin@admin.com')->firstOrFail()->assignRole('administrator');
        User::where('email', 'manager@manager.com')->firstOrFail()->assignRole('manager');
        User::where('email', 'executive@executive.com')->firstOrFail()->assignRole('executive');
        User::where('email', 'user@user.com')->firstOrFail()->assignRole('user');

        Artisan::call('cache:clear');
    }
}

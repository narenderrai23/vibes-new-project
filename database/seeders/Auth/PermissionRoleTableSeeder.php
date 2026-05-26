<?php

namespace Database\Seeders\Auth;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class PermissionRoleTableSeeder.
 *
 * Run command:
 * php artisan db:seed --class="Database\\Seeders\\Auth\\PermissionRoleTableSeeder"
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->CreateDefaultPermissions();

        /**
         * Create Roles and Assign Permissions to Roles.
         */
        $super_admin = Role::query()->updateOrCreate(
            ['name' => 'super admin', 'guard_name' => 'web']
        );

        $admin = Role::query()->updateOrCreate(
            ['name' => 'administrator', 'guard_name' => 'web']
        );
        $admin->givePermissionTo(['view_backend', 'edit_settings']);

        $manager = Role::query()->updateOrCreate(
            ['name' => 'manager', 'guard_name' => 'web']
        );
        $manager->givePermissionTo('view_backend');

        $executive = Role::query()->updateOrCreate(
            ['name' => 'executive', 'guard_name' => 'web']
        );
        $executive->givePermissionTo('view_backend');

        $user = Role::query()->updateOrCreate(
            ['name' => 'user', 'guard_name' => 'web']
        );
    }

    public function CreateDefaultPermissions()
    {
        // Create Permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $permission) {
            Permission::query()->firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'web',
            ]);
        }

        Artisan::call('auth:permissions', [
            'name' => 'comments',
        ]);
        if (! app()->runningUnitTests()) {
            $this->command->info('_Comments_ Permissions Created.');
        }
    }
}

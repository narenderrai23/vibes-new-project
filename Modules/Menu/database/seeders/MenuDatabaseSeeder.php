<?php

<<<<<<< HEAD
namespace Modules\Menu\database\seeders;
=======
namespace Nasirkhan\ModuleManager\Modules\Menu\database\seeders;
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

use Illuminate\Database\Seeder;

class MenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CurrentMenuDataSeeder::class,
        ]);
    }
}

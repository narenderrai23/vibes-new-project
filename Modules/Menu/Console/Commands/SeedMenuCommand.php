<?php

<<<<<<< HEAD
namespace Modules\Menu\Console\Commands;

use Illuminate\Console\Command;
use Modules\Menu\database\seeders\MenuDatabaseSeeder;
=======
namespace Nasirkhan\ModuleManager\Modules\Menu\Console\Commands;

use Illuminate\Console\Command;
use Nasirkhan\ModuleManager\Modules\Menu\database\seeders\MenuDatabaseSeeder;
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

class SeedMenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the menu module data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding Menu module...');

        $seeder = new MenuDatabaseSeeder;
        $seeder->run();

        $this->info('Menu module seeded successfully!');

        return 0;
    }
}

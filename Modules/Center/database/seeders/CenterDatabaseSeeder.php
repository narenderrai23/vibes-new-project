<?php

namespace Modules\Center\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterDatabaseSeeder extends Seeder
{
    /**
     * Run command:
     * php artisan db:seed --class="Modules\\Center\\database\\seeders\\CenterDatabaseSeeder"
     */

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Seed countries first (states depend on countries)
        $this->call(CountrySeeder::class);
        echo " Insert: countries\n";

        // Seed states (depends on countries)
        $this->call(StateSeeder::class);
        echo " Insert: states\n";

        // Seed centers from public/center_master.csv
        $this->call(CenterMasterSeeder::class);
        echo " Insert: centers\n\n";

        // Seed center portal login accounts
        $this->call(CenterUserSeeder::class);
        echo " Insert: center users\n\n";

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

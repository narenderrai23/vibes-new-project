<?php

namespace Modules\Auth\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Models\Auth;

class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Auths Seed
         * ------------------
         */

        // DB::table('auths')->truncate();
        // echo "Truncate: auths \n";

        Auth::factory()->count(20)->create();
        $rows = Auth::all();
        echo " Insert: auths \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

<?php

namespace Modules\Center\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run command:
     * php artisan db:seed --class="Modules\\Center\\database\\seeders\\CountrySeeder"
     */

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            [
                'name'       => 'India',
                'iso2'       => 'IN',
                'iso3'       => 'IND',
                'phonecode'  => '91',
                'currency'   => 'INR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Bangladesh',
                'iso2'       => 'BD',
                'iso3'       => 'BGD',
                'phonecode'  => '880',
                'currency'   => 'BDT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'United States',
                'iso2'       => 'US',
                'iso3'       => 'USA',
                'phonecode'  => '1',
                'currency'   => 'USD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'United Kingdom',
                'iso2'       => 'GB',
                'iso3'       => 'GBR',
                'phonecode'  => '44',
                'currency'   => 'GBP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

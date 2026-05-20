<?php

namespace Modules\Center\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run command:
     * php artisan db:seed --class="Modules\\Center\\database\\seeders\\StateSeeder"
     */

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // India
        $indiaId = DB::table('countries')->where('iso2', 'IN')->value('id');

        $indiaStates = [
            ['name' => 'Andhra Pradesh',    'state_code' => 'AP'],
            ['name' => 'Arunachal Pradesh', 'state_code' => 'AR'],
            ['name' => 'Assam',             'state_code' => 'AS'],
            ['name' => 'Bihar',             'state_code' => 'BR'],
            ['name' => 'Chhattisgarh',      'state_code' => 'CG'],
            ['name' => 'Goa',               'state_code' => 'GA'],
            ['name' => 'Gujarat',           'state_code' => 'GJ'],
            ['name' => 'Haryana',           'state_code' => 'HR'],
            ['name' => 'Himachal Pradesh',  'state_code' => 'HP'],
            ['name' => 'Jharkhand',         'state_code' => 'JH'],
            ['name' => 'Karnataka',         'state_code' => 'KA'],
            ['name' => 'Kerala',            'state_code' => 'KL'],
            ['name' => 'Madhya Pradesh',    'state_code' => 'MP'],
            ['name' => 'Maharashtra',       'state_code' => 'MH'],
            ['name' => 'Odisha',            'state_code' => 'OD'],
            ['name' => 'Punjab',            'state_code' => 'PB'],
            ['name' => 'Rajasthan',         'state_code' => 'RJ'],
            ['name' => 'Tamil Nadu',        'state_code' => 'TN'],
            ['name' => 'Telangana',         'state_code' => 'TS'],
            ['name' => 'Uttar Pradesh',     'state_code' => 'UP'],
            ['name' => 'West Bengal',       'state_code' => 'WB'],
            ['name' => 'Delhi',             'state_code' => 'DL'],
        ];

        foreach ($indiaStates as $state) {
            DB::table('states')->insert([
                'country_id' => $indiaId,
                'name'       => $state['name'],
                'state_code' => $state['state_code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Bangladesh
        $bangladeshId = DB::table('countries')->where('iso2', 'BD')->value('id');

        $bangladeshStates = [
            ['name' => 'Dhaka',       'state_code' => 'DHA'],
            ['name' => 'Chattogram',  'state_code' => 'CTG'],
            ['name' => 'Rajshahi',    'state_code' => 'RAJ'],
            ['name' => 'Khulna',      'state_code' => 'KHU'],
            ['name' => 'Barishal',    'state_code' => 'BAR'],
            ['name' => 'Sylhet',      'state_code' => 'SYL'],
            ['name' => 'Rangpur',     'state_code' => 'RAN'],
            ['name' => 'Mymensingh',  'state_code' => 'MYM'],
        ];

        foreach ($bangladeshStates as $state) {
            DB::table('states')->insert([
                'country_id' => $bangladeshId,
                'name'       => $state['name'],
                'state_code' => $state['state_code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

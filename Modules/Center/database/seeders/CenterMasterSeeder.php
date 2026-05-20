<?php

namespace Modules\Center\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Center\Models\Center;
use Modules\Center\Models\Country;
use Modules\Center\Models\State;

class CenterMasterSeeder extends Seeder
{
    /**
     * Run command:
     * php artisan db:seed --class="Modules\\Center\\database\\seeders\\CenterMasterSeeder"
     *
     * Center Code format:
     *   1 char  of Country  (India       → I)
     *   2 chars of State    (Maharashtra → MA)
     *   2 chars of Center   (Kalyani Nagar → KA)
     *   Result: IMAKA
     */

    /** City → State name (from CSV cities) */
    private const CITY_STATE_MAP = [
        // India
        'Agra'        => 'Uttar Pradesh',
        'Bangalore'   => 'Karnataka',
        'Bhubaneswar' => 'Odisha',
        'Delhi / NCR' => 'Delhi',
        'Hyderabad'   => 'Telangana',
        'Jaipur'      => 'Rajasthan',
        'Kanpur'      => 'Uttar Pradesh',
        'Kolkata'     => 'West Bengal',
        'Lucknow'     => 'Uttar Pradesh',
        'Patna'       => 'Bihar',
        'Pune'        => 'Maharashtra',
        'Ranchi'      => 'Jharkhand',
        'Siliguri'    => 'West Bengal',
        // Bangladesh
        'Dhaka'       => 'Dhaka',
    ];

    public function run(): void
    {
        $path = public_path('center_master.csv');

        if (! is_readable($path)) {
            $this->command?->error("CSV not found at: {$path}");
            return;
        }

        $this->truncateCenters();

        // Pre-load lookups
        $countries = Country::pluck('id', 'name')->toArray();
        $states    = State::pluck('id', 'name')->toArray();

        $handle = fopen($path, 'rb');
        if ($handle === false) {
            $this->command?->error("Cannot open CSV.");
            return;
        }

        $headers  = fgetcsv($handle);
        $imported = 0;
        $skipped  = 0;
        $usedCodes = [];   // track generated codes for uniqueness

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($headers)) {
                continue;
            }

            $data = array_combine($headers, $row);

            $centerName = $this->clean($data['Center Name'] ?? '');
            if (empty($centerName)) {
                $skipped++;
                continue;
            }

            $city        = $this->clean($data['City'] ?? null);
            $stateName   = self::CITY_STATE_MAP[$city] ?? null;
            $countryName = ($city === 'Dhaka') ? 'Bangladesh' : 'India';

            $countryId = $countries[$countryName] ?? null;
            $stateId   = $stateName ? ($states[$stateName] ?? null) : null;

            $code = $this->generateCode($countryName, $stateName ?? $city, $centerName, $usedCodes);

            Center::query()->updateOrCreate(
                ['city' => $city, 'name' => $centerName],
                [
                    'code'        => $code,
                    'mobile'      => $this->clean($data['Mobile Number']          ?? null),
                    'mobile_alt'  => $this->clean($data['Alternative Mobile No.'] ?? null),
                    'email'       => $this->clean($data['Email']                  ?? null),
                    'address'     => $this->clean($data['address']                ?? null),
                    'google_link' => $this->clean($data['address_google_link']    ?? null),
                    'gst_no'      => $this->cleanGst($data['gst_no']              ?? null),
                    'state_id'    => $stateId,
                    'status'      => $this->status($data['status']                ?? null),
                ]
            );

            $imported++;
        }

        fclose($handle);

        $this->command?->info("✓ Imported {$imported} centers from center_master.csv.");
        if ($skipped) {
            $this->command?->warn("  Skipped {$skipped} rows (empty center name).");
        }
    }

    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Generate center code: {1 char country}{2 chars state}{2 chars center}
     *
     * Example: India + Delhi + Wellness = I + DE + WE = IDEWE
     *
     * Collisions get a numeric suffix: IDEWE2, IDEWE3 …
     */
    private function generateCode(string $country, string $state, string $center, array &$used): string
    {
        $c = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $country), 0, 1));
        $s = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $state),   0, 2));
        $n = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $center),  0, 2));

        $base = str_pad($c, 1, 'X') . str_pad($s, 2, 'X') . str_pad($n, 2, 'X');

        if (! isset($used[$base])) {
            $used[$base] = 1;
            return $base;
        }

        $used[$base]++;
        return $base . $used[$base];
    }

    /** Trim, collapse whitespace, return null for empty / NULL strings. */
    private function clean(?string $value): ?string
    {
        $v = trim(preg_replace('/\s+/', ' ', (string) $value));
        return ($v === '' || strtoupper($v) === 'NULL') ? null : $v;
    }

    /** Clean GST — strip whitespace, uppercase, null for NA/NULL/empty. */
    private function cleanGst(?string $value): ?string
    {
        $v = strtoupper(preg_replace('/\s+/', '', (string) $value));
        return ($v === '' || $v === 'NULL' || $v === 'NA') ? null : $v;
    }

    /** Map Yes/No → 1/0. */
    private function status(?string $value): int
    {
        return strtolower($this->clean($value) ?? '') === 'yes' ? 1 : 0;
    }

    /** Truncate centers safely. */
    private function truncateCenters(): void
    {
        if (Schema::hasTable('regionals')) {
            DB::table('regionals')->whereNotNull('center_id')->update(['center_id' => null]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        try {
            Center::query()->truncate();
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        $this->command?->info('Truncated centers table.');
    }
}

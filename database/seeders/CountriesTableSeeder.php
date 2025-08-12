<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            ['code' => 'ES'],
            ['code' => 'US'],
            ['code' => 'FR'],
            ['code' => 'DE'],
            ['code' => 'IT'],
            ['code' => 'PT'],
            ['code' => 'GB'],
            ['code' => 'MX'],
            ['code' => 'AR'],
            ['code' => 'BR'],
            ['code' => 'CL'],
            ['code' => 'CO'],
            ['code' => 'PE'],
            ['code' => 'VE'],
            ['code' => 'UY'],
            ['code' => 'EC'],
            ['code' => 'PY'],
            ['code' => 'BO'],
            ['code' => 'CR'],
            ['code' => 'PA'],
        ]);
    }
}

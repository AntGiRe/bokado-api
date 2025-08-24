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
            ['code' => 'ES', 'slug' => 'spain'],
            ['code' => 'US', 'slug' => 'united-state'],
            ['code' => 'FR', 'slug' => 'france'],
            ['code' => 'DE', 'slug' => 'germany'],
            ['code' => 'IT', 'slug' => 'italy'],
            ['code' => 'PT', 'slug' => 'portugal'],
            ['code' => 'GB', 'slug' => 'united-kingdom'],
            ['code' => 'MX', 'slug' => 'mexico'],
            ['code' => 'AR', 'slug' => 'argentina'],
            ['code' => 'BR', 'slug' => 'brazil'],
            ['code' => 'CL', 'slug' => 'chile'],
            ['code' => 'CO', 'slug' => 'colombia'],
            ['code' => 'PE', 'slug' => 'peru'],
            ['code' => 'VE', 'slug' => 'venezuela'],
            ['code' => 'UY', 'slug' => 'uruguay'],
            ['code' => 'EC', 'slug' => 'ecuador'],
            ['code' => 'PY', 'slug' => 'paraguay'],
            ['code' => 'BO', 'slug' => 'bolivia'],
            ['code' => 'CR', 'slug' => 'costa-rica'],
            ['code' => 'PA', 'slug' => 'panama'],
        ]);
    }
}

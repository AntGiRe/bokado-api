<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTouristicRegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('city_touristic_region')->insert([
            ['city_id' => 25, 'touristic_region_id' => 1],
            ['city_id' => 6, 'touristic_region_id' => 1],
            ['city_id' => 5, 'touristic_region_id' => 1],
            ['city_id' => 20, 'touristic_region_id' => 1],
            ['city_id' => 1, 'touristic_region_id' => 1],
            ['city_id' => 4, 'touristic_region_id' => 1],
            ['city_id' => 14, 'touristic_region_id' => 1],
        ]);
    }
}

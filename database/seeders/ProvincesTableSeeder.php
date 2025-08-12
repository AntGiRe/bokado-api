<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provinces')->insert([
            ['code' => 'Málaga', 'region_id' => 1],
            ['code' => 'Cádiz', 'region_id' => 1],
            ['code' => 'Sevilla', 'region_id' => 1],
            ['code' => 'Granada', 'region_id' => 1],
            ['code' => 'Almería', 'region_id' => 1],
            ['code' => 'Córdoba', 'region_id' => 1],
            ['code' => 'Jaén', 'region_id' => 1],
            ['code' => 'Huelva', 'region_id' => 1],
            ['code' => 'Badajoz', 'region_id' => 2],
            ['code' => 'Cáceres', 'region_id' => 2],
            ['code' => 'Madrid', 'region_id' => 3],
            ['code' => 'Barcelona', 'region_id' => 4],
            ['code' => 'Valencia', 'region_id' => 5],
            ['code' => 'Bilbao', 'region_id' => 6],
            ['code' => 'Zaragoza', 'region_id' => 7],
        ]);
    }
}

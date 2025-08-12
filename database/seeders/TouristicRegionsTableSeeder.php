<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TouristicRegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('touristic_regions')->insert([
            ['name' => 'Region 1', 'description' => 'Description for Region 1'],
            ['name' => 'Region 2', 'description' => 'Description for Region 2'],
            ['name' => 'Region 3', 'description' => 'Description for Region 3'],
        ]);
    }
}

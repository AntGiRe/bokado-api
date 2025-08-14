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
            ['name' => 'Costa del Sol', 'description' => 'Description for Costa del Sol'],
        ]);
    }
}

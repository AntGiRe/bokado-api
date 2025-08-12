<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            ['code' => 'Andalucía', 'country_id' => 1],
            ['code' => 'Cataluña', 'country_id' => 1],
            ['code' => 'Madrid', 'country_id' => 1],
            ['code' => 'Valencia', 'country_id' => 1],
            ['code' => 'Galicia', 'country_id' => 1],
            ['code' => 'País Vasco', 'country_id' => 1],
            ['code' => 'Canarias', 'country_id' => 1],
            ['code' => 'Aragón', 'country_id' => 1],
            ['code' => 'Castilla y León', 'country_id' => 1],
            ['code' => 'Castilla-La Mancha', 'country_id' => 1],
        ]);
    }
}

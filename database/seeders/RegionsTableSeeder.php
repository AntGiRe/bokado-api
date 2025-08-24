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
            ['code' => 'Andalucía', 'slug' => 'andalucia-r1', 'country_id' => 1],
            ['code' => 'Cataluña', 'slug' => 'cataluna-r2', 'country_id' => 1],
            ['code' => 'Madrid', 'slug' => 'madrid-r3', 'country_id' => 1],
            ['code' => 'Valencia', 'slug' => 'valencia-r4', 'country_id' => 1],
            ['code' => 'Galicia', 'slug' => 'galicia-r5', 'country_id' => 1],
            ['code' => 'País Vasco', 'slug' => 'pais-vasco-r6', 'country_id' => 1],
            ['code' => 'Canarias', 'slug' => 'canarias-r7', 'country_id' => 1],
            ['code' => 'Aragón', 'slug' => 'aragon-r8', 'country_id' => 1],
            ['code' => 'Castilla y León', 'slug' => 'castilla-y-leon-r9', 'country_id' => 1],
            ['code' => 'Castilla-La Mancha', 'slug' => 'castilla-la-mancha-r10', 'country_id' => 1],
        ]);
    }
}

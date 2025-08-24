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
            ['code' => 'Málaga', 'slug' => 'malaga-p1', 'region_id' => 1],
            ['code' => 'Cádiz', 'slug' => 'cadiz-p2', 'region_id' => 1],
            ['code' => 'Sevilla', 'slug' => 'sevilla-p3', 'region_id' => 1],
            ['code' => 'Granada', 'slug' => 'granada-p4', 'region_id' => 1],
            ['code' => 'Almería', 'slug' => 'almeria-p5', 'region_id' => 1],
            ['code' => 'Córdoba', 'slug' => 'cordoba-p6', 'region_id' => 1],
            ['code' => 'Jaén', 'slug' => 'jaen-p7', 'region_id' => 1],
            ['code' => 'Huelva', 'slug' => 'huelva-p8', 'region_id' => 1],
            ['code' => 'Badajoz', 'slug' => 'badajoz-p9', 'region_id' => 2],
            ['code' => 'Cáceres', 'slug' => 'caceres-p10', 'region_id' => 2],
            ['code' => 'Madrid', 'slug' => 'madrid-p11', 'region_id' => 3],
            ['code' => 'Barcelona', 'slug' => 'barcelona-p12', 'region_id' => 4],
            ['code' => 'Valencia', 'slug' => 'valencia-p13', 'region_id' => 5],
            ['code' => 'Bilbao', 'slug' => 'bilbao-p14', 'region_id' => 6],
            ['code' => 'Zaragoza', 'slug' => 'zaragoza-p15', 'region_id' => 7],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provinces')->insert([
            ['id' => 1, 'code' => 'Málaga', 'slug' => 'malaga-p1', 'region_id' => 1],
            ['id' => 2, 'code' => 'Cádiz', 'slug' => 'cadiz-p2', 'region_id' => 1],
        ]);

        DB::table('province_translations')->insert([
            [
                'province_id' => 1,
                'locale' => 'en',
                'name' => 'Malaga',
            ],
            [
                'province_id' => 1,
                'locale' => 'es',
                'name' => 'Malaga',
            ],
            [
                'province_id' => 2,
                'locale' => 'es',
                'name' => 'Cadiz',
            ],
            [
                'province_id' => 2,
                'locale' => 'en',
                'name' => 'Cadiz',
            ],
        ]);
    }
}

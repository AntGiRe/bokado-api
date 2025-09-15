<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            ['id' => 1, 'code' => 'Andalucía', 'slug' => 'andalucia-r1', 'country_id' => 1],
            ['id' => 2, 'code' => 'Cataluña', 'slug' => 'cataluna-r2', 'country_id' => 1],
            ['id' => 3, 'code' => 'Madrid', 'slug' => 'madrid-r3', 'country_id' => 1],
            ['id' => 4, 'code' => 'Valencia', 'slug' => 'valencia-r4', 'country_id' => 1],
            ['id' => 5, 'code' => 'Galicia', 'slug' => 'galicia-r5', 'country_id' => 1],
            ['id' => 6, 'code' => 'País Vasco', 'slug' => 'pais-vasco-r6', 'country_id' => 1],
        ]);

        DB::table('region_translations')->insert([
            [
                'region_id' => 1,
                'locale' => 'es',
                'name' => 'Andalucía'
            ],
            [
                'region_id' => 1,
                'locale' => 'en',
                'name' => 'Andalusia'
            ],
            [
                'region_id' => 2,
                'locale' => 'es',
                'name' => 'Cataluña'
            ],
            [
                'region_id' => 2,
                'locale' => 'en',
                'name' => 'Catalonia'
            ],
            [
                'region_id' => 3,
                'locale' => 'es',
                'name' => 'Madrid'
            ],
            [
                'region_id' => 3,
                'locale' => 'en',
                'name' => 'Madrid'
            ],
            [
                'region_id' => 4,
                'locale' => 'es',
                'name' => 'Valencia'
            ],
            [
                'region_id' => 4,
                'locale' => 'en',
                'name' => 'Valencia'
            ],
            [
                'region_id' => 5,
                'locale' => 'es',
                'name' => 'Galicia'
            ],
            [
                'region_id' => 5,
                'locale' => 'en',
                'name' => 'Galicia'
            ],
            [
                'region_id' => 6,
                'locale' => 'es',
                'name' => 'País Vasco'
            ],
            [
                'region_id' => 6,
                'locale' => 'en',
                'name' => 'Basque Country'
            ],
        ]);
    }
}

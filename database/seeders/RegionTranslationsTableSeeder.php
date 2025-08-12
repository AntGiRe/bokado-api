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
            [
                'region_id' => 7,
                'locale' => 'es',
                'name' => 'Aragón'
            ],
            [
                'region_id' => 7,
                'locale' => 'en',
                'name' => 'Aragon'
            ],
            [
                'region_id' => 8,
                'locale' => 'es',
                'name' => 'Castilla y León'
            ],
            [
                'region_id' => 8,
                'locale' => 'en',
                'name' => 'Castile and León'
            ],
        ]);
    }
}

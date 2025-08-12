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
        DB::table('province_translations')->insert([
            [
                'province_id' => 1,
                'locale' => 'en',
                'name' => 'Malaga',
            ],
            [
                'province_id' => 2,
                'locale' => 'es',
                'name' => 'Malaga',
            ],
            [
                'province_id' => 3,
                'locale' => 'es',
                'name' => 'Cadiz',
            ],
            [
                'province_id' => 4,
                'locale' => 'en',
                'name' => 'Seville',
            ],
            [
                'province_id' => 5,
                'locale' => 'en',
                'name' => 'Granada',
            ],
            [
                'province_id' => 6,
                'locale' => 'en',
                'name' => 'Almeria',
            ],
            [
                'province_id' => 7,
                'locale' => 'en',
                'name' => 'Córdoba',
            ],
            
        ]);
    }
}

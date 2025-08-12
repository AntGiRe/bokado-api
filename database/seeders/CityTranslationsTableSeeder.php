<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CityTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('city_translations')->insert([
            ['city_id' => 1, 'locale' => 'es', 'name' => 'Málaga'],
            ['city_id' => 2, 'locale' => 'es', 'name' => 'Torremolinos'],
            ['city_id' => 3, 'locale' => 'es', 'name' => 'Alhaurín de la Torre'],
            ['city_id' => 4, 'locale' => 'es', 'name' => 'Marbella'],
            ['city_id' => 5, 'locale' => 'es', 'name' => 'Fuengirola'],
            ['city_id' => 1, 'locale' => 'en', 'name' => 'Málaga'],
            ['city_id' => 2, 'locale' => 'en', 'name' => 'Torremolinos'],
            ['city_id' => 3, 'locale' => 'en', 'name' => 'Alhaurín de la Torre'],
            ['city_id' => 4, 'locale' => 'en', 'name' => 'Marbella'],
            ['city_id' => 5, 'locale' => 'en', 'name' => 'Fuengirola'],
        ]);
    }
}

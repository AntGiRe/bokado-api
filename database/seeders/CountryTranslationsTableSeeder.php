<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CountryTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds. Locale es el idioma del pais traducido, el pais country esta en countriesTableSeeder
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            ['id' => 1, 'code' => 'ES', 'slug' => 'spain'],
            ['id' => 2, 'code' => 'US', 'slug' => 'united-state'],
        ]);

        DB::table('country_translations')->insert([
            ['country_id' => 1, 'locale' => 'es', 'name' => 'España'],
            ['country_id' => 1, 'locale' => 'en', 'name' => 'Spain'],
            ['country_id' => 2, 'locale' => 'en', 'name' => 'United States'],
            ['country_id' => 2, 'locale' => 'es', 'name' => 'Estados Unidos'],
        ]);
    }
}

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
        DB::table('country_translations')->insert([
            ['country_id' => 1, 'locale' => 'es', 'name' => 'España'],
            ['country_id' => 1, 'locale' => 'en', 'name' => 'Spain'],
            ['country_id' => 2, 'locale' => 'en', 'name' => 'United States'],
            ['country_id' => 2, 'locale' => 'es', 'name' => 'Estados Unidos'],
            ['country_id' => 3, 'locale' => 'fr', 'name' => 'France'],
            ['country_id' => 3, 'locale' => 'es', 'name' => 'Francia'],
            ['country_id' => 4, 'locale' => 'de', 'name' => 'Deutschland'],
            ['country_id' => 4, 'locale' => 'es', 'name' => 'Alemania'],
            ['country_id' => 5, 'locale' => 'it', 'name' => 'Italia'],
            ['country_id' => 5, 'locale' => 'es', 'name' => 'Italia'],
            ['country_id' => 6, 'locale' => 'pt', 'name' => 'Portugal'],
            ['country_id' => 6, 'locale' => 'es', 'name' => 'Portugal'],
            ['country_id' => 7, 'locale' => 'en', 'name' => 'United Kingdom'],
            ['country_id' => 7, 'locale' => 'es', 'name' => 'Reino Unido'],
            ['country_id' => 8, 'locale' => 'es', 'name' => 'México'],
            ['country_id' => 8, 'locale' => 'en', 'name' => 'Mexico'],
            ['country_id' => 9, 'locale' => 'es', 'name' => 'Argentina'],
            ['country_id' => 9, 'locale' => 'en', 'name' => 'Argentina'],
            ['country_id' => 10, 'locale' => 'pt', 'name' => 'Brasil'],
            ['country_id' => 10, 'locale' => 'es', 'name' => 'Brasil'],
            ['country_id' => 11, 'locale' => 'es', 'name' => 'Chile'],
            ['country_id' => 11, 'locale' => 'en', 'name' => 'Chile'],
            ['country_id' => 12, 'locale' => 'es', 'name' => 'Colombia'],
            ['country_id' => 12, 'locale' => 'en', 'name' => 'Colombia'],
            ['country_id' => 13, 'locale' => 'es', 'name' => 'Perú'],
            ['country_id' => 13, 'locale' => 'en', 'name' => 'Peru'],
            ['country_id' => 14, 'locale' => 'es', 'name' => "Venezuela"],
            ['country_id' => 14, 'locale' => "en", "name" => "Venezuela"],
            ['country_id' => 15, 'locale' => "es", "name" => "Uruguay"],
            ['country_id' => 15, "locale" => "en", "name" => "Uruguay"],
            ['country_id' => 16, "locale" => "es", "name" => "Ecuador"],
            ['country_id' => 16, "locale" => "en", "name" => "Ecuador"],
            ['country_id' => 17, "locale" => "es", "name" => "Paraguay"],
            ['country_id' => 17, "locale" => "en", "name" => "Paraguay"],
            ['country_id' => 18, "locale" => "es", "name" => "Bolivia"],
            ['country_id' => 18, "locale" => "en", "name" => "Bolivia"],
            ['country_id' => 19, "locale" => "es", "name" => "Costa Rica"],
            ['country_id' => 19, "locale" => "en", "name" => "Costa Rica"],
            ['country_id' => 20, "locale" => "es", "name" => "Panamá"],
            ['country_id' => 20, "locale" => "en", "name" => "Panama"],
        ]);
    }
}

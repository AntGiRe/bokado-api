<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageTableSeeder::class,
            PaymentMethodTranslationsTableSeeder::class,
            CountryTranslationsTableSeeder::class,
            RegionTranslationsTableSeeder::class,
            ProvinceTranslationsTableSeeder::class,
            CityTranslationsTableSeeder::class,
            CityTouristicRegionsTableSeeder::class,
            CurrencyTranslationsTableSeeder::class,
            FeatureTranslationsTableSeeder::class,
            TouristicRegionTranslationsTableSeeder::class,
        ]);
    }
}

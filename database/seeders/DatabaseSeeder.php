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
            CountriesTableSeeder::class,
            RegionsTableSeeder::class,
            ProvincesTableSeeder::class,
            CitiesTableSeeder::class,
            CurrenciesTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            PaymentMethodTranslationsTableSeeder::class,
            CountryTranslationsTableSeeder::class,
            RegionTranslationsTableSeeder::class,
            ProvinceTranslationsTableSeeder::class,
            CityTranslationsTableSeeder::class,
            TouristicRegionsTableSeeder::class,
            CityTouristicRegionsTableSeeder::class,
            CurrencyTranslationsTableSeeder::class,
            FeatureTranslationsTableSeeder::class,
        ]);
    }
}

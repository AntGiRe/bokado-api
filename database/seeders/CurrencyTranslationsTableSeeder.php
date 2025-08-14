<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currency_translations')->insert([
            ['currency_id' => 1, 'locale' => 'en', 'name' => 'Euro'],
            ['currency_id' => 1, 'locale' => 'es', 'name' => 'Euro'],
            ['currency_id' => 2, 'locale' => 'en', 'name' => 'US Dollar'],
            ['currency_id' => 2, 'locale' => 'es', 'name' => 'Dólar estadounidense'],
            ['currency_id' => 3, 'locale' => 'en', 'name' => 'British Pound'],
            ['currency_id' => 3, 'locale' => 'es', 'name' => 'Libra esterlina'],
        ]);
    }
}

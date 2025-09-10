<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->insert([
            ['id' => 1, 'name' => 'Euro', 'code' => 'EUR', 'symbol' => '€'],
            ['id' => 2, 'name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$'],
            ['id' => 3, 'name' => 'British Pound', 'code' => 'GBP', 'symbol' => '£'],
        ]);
    }
}

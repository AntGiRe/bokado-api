<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            ['code' => 'credit_card'],
            ['code' => 'cash'],
            ['code' => 'paypal'],
            ['code' => 'apple_pay'],
            ['code' => 'google_pay'],
        ]);
    }
}

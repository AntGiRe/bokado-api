<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PaymentMethodTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            ['id' => 1, 'code' => 'credit_card'],
            ['id' => 2, 'code' => 'cash'],
            ['id' => 3, 'code' => 'paypal'],
            ['id' => 4, 'code' => 'apple_pay'],
            ['id' => 5, 'code' => 'google_pay'],
        ]);
        
        DB::table('payment_method_translations')->insert([
            [
                'payment_method_id' => 1,
                'locale' => 'en',
                'name' => 'Credit Card'
            ],
            [
                'payment_method_id' => 1,
                'locale' => 'es',
                'name' => 'Tarjeta de Crédito'
            ],
            [
                'payment_method_id' => 2,
                'locale' => 'en',
                'name' => 'Cash'
            ],
            [
                'payment_method_id' => 2,
                'locale' => 'es',
                'name' => 'Efectivo'
            ],
            [
                'payment_method_id' => 3,
                'locale' => 'en',
                'name' => 'PayPal'
            ],
            [
                'payment_method_id' => 3,
                'locale' => 'es',
                'name' => 'PayPal'
            ],
            [
                'payment_method_id' => 4,
                'locale' => 'en',
                'name' => 'Apple Pay'
            ],
            [
                'payment_method_id' => 4,
                'locale' => 'es',
                'name' => 'Apple Pay'
            ],
            [
                'payment_method_id' => 5,
                'locale' => 'en',
                'name' => 'Google Pay'
            ],
            [
                'payment_method_id' => 5,
                'locale' => 'es',
                'name' => 'Google Pay'
            ]
        ]);
    }
}

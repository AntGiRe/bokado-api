<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FeatureTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['id' => 1, 'code' => 'terrace'],
            ['id' => 2, 'code' => 'wheelchair_accessible'],
            ['id' => 3, 'code' => 'outdoor_seating'],
            ['id' => 4, 'code' => 'free_wifi'],
            ['id' => 5, 'code' => 'parking_available'],
        ];

        DB::table('features')->insert($features);

        DB::table('feature_translations')->insert([
            ['feature_id' => 1, 'locale' => 'en', 'name' => 'Terrace'],
            ['feature_id' => 1, 'locale' => 'es', 'name' => 'Terraza'],

            ['feature_id' => 2, 'locale' => 'en', 'name' => 'Wheelchair Accessible'],
            ['feature_id' => 2, 'locale' => 'es', 'name' => 'Accesible para silla de ruedas'],

            ['feature_id' => 3, 'locale' => 'en', 'name' => 'Outdoor Seating'],
            ['feature_id' => 3, 'locale' => 'es', 'name' => 'Zona exterior'],

            ['feature_id' => 4, 'locale' => 'en', 'name' => 'Free Wi-Fi'],
            ['feature_id' => 4, 'locale' => 'es', 'name' => 'Wi-Fi gratis'],

            ['feature_id' => 5, 'locale' => 'en', 'name' => 'Parking Available'],
            ['feature_id' => 5, 'locale' => 'es', 'name' => 'Parking disponible'],
        ]);
    }
}

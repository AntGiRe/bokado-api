<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TouristicRegionTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('touristic_region_translations')->insert([
            [
                'touristic_region_id' => 1,
                'locale' => 'es',
                'name' => 'Costa del Sol',
                'description' => 'Zona turística famosa por sus playas y clima cálido en la provincia de Málaga.',
            ],
            [
                'touristic_region_id' => 1,
                'locale' => 'en',
                'name' => 'Costa del Sol',
                'description' => 'Tourist area famous for its beaches and warm climate in the Málaga province.',
            ],
            [
                'touristic_region_id' => 1,
                'locale' => 'fr',
                'name' => 'Costa del Sol',
                'description' => 'Zone touristique célèbre pour ses plages et son climat chaud dans la province de Malaga.',
            ],
            // Agrega más idiomas si quieres
        ]);
    }
}

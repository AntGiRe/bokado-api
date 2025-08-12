<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            ['code' => 'Málaga', 'province_id' => 1],
            ['code' => 'Torremolinos', 'province_id' => 1],
            ['code' => 'Alhaurín de la Torre', 'province_id' => 1],
            ['code' => 'Marbella', 'province_id' => 1],
            ['code' => 'Fuengirola', 'province_id' => 1],
            ['code' => 'Benalmádena', 'province_id' => 1],
            ['code' => 'Estepona', 'province_id' => 1],
            ['code' => 'Rincón de la Victoria', 'province_id' => 1],
            ['code' => 'Vélez-Málaga', 'province_id' => 1],
            ['code' => 'Cártama', 'province_id' => 1],
            ['code' => 'Antequera', 'province_id' => 1],
            ['code' => 'Alhaurín el Grande', 'province_id' => 1],
            ['code' => 'Coín', 'province_id' => 1],
            ['code' => 'Mijas', 'province_id' => 1],
            ['code' => 'Nerja', 'province_id' => 1],
            ['code' => 'Ronda', 'province_id' => 1],
            ['code' => 'Archidona', 'province_id' => 1],
            ['code' => 'Torrox', 'province_id' => 1],
            ['code' => 'Almuñécar', 'province_id' => 1],
            ['code' => 'La Cala de Mijas', 'province_id' => 1],
            ['code' => 'San Pedro de Alcántara', 'province_id' => 1],
            ['code' => 'Villanueva de la Concepción', 'province_id' => 1],
            ['code' => 'Pizarra', 'province_id' => 1],
            ['code' => 'Álora', 'province_id' => 1],
            ['code' => 'Benahavís', 'province_id' => 1],
            ['code' => 'Ojén', 'province_id' => 1],
            ['code' => 'Monda', 'province_id' => 1],
            ['code' => 'Sierra de Yeguas', 'province_id' => 1],
        ]);
    }
}

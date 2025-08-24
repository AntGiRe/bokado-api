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
            ['code' => 'Málaga', 'slug' => 'malaga-c1', 'province_id' => 1],
            ['code' => 'Torremolinos', 'slug' => 'torremolinos-c2', 'province_id' => 1],
            ['code' => 'Alhaurín de la Torre', 'slug' => 'alhaurin-de-la-torre-c3', 'province_id' => 1],
            ['code' => 'Marbella', 'slug' => 'marbella-c4', 'province_id' => 1],
            ['code' => 'Fuengirola', 'slug' => 'fuengirola-c5', 'province_id' => 1],
            ['code' => 'Benalmádena', 'slug' => 'benalmadena-c6', 'province_id' => 1],
            ['code' => 'Estepona', 'slug' => 'estepona-c7', 'province_id' => 1],
            ['code' => 'Rincón de la Victoria', 'slug' => 'rincon-de-la-victoria-c8', 'province_id' => 1],
            ['code' => 'Vélez-Málaga', 'slug' => 'velez-malaga-c9', 'province_id' => 1],
            ['code' => 'Cártama', 'slug' => 'cartama-c10', 'province_id' => 1],
            ['code' => 'Antequera', 'slug' => 'antequera-c11', 'province_id' => 1],
            ['code' => 'Alhaurín el Grande', 'slug' => 'alhaurin-el-grande-c12', 'province_id' => 1],
            ['code' => 'Coín', 'slug' => 'coin-c13', 'province_id' => 1],
            ['code' => 'Mijas', 'slug' => 'mijas-c14', 'province_id' => 1],
            ['code' => 'Nerja', 'slug' => 'nerja-c15', 'province_id' => 1],
            ['code' => 'Ronda', 'slug' => 'ronda-c16', 'province_id' => 1],
            ['code' => 'Archidona', 'slug' => 'archidona-c17', 'province_id' => 1],
            ['code' => 'Torrox', 'slug' => 'torrox-c18', 'province_id' => 1],
            ['code' => 'Almuñécar', 'slug' => 'almunecar-c19', 'province_id' => 1],
            ['code' => 'La Cala de Mijas', 'slug' => 'la-cala-de-mijas-c20', 'province_id' => 1],
            ['code' => 'San Pedro de Alcántara', 'slug' => 'san-pedro-de-alcantara-c21', 'province_id' => 1],
            ['code' => 'Villanueva de la Concepción', 'slug' => 'villanueva-de-la-concepcion-c22', 'province_id' => 1],
            ['code' => 'Pizarra', 'slug' => 'pizarra-c23', 'province_id' => 1],
            ['code' => 'Álora', 'slug' => 'alora-c24', 'province_id' => 1],
            ['code' => 'Benahavís', 'slug' => 'benahavis-c25', 'province_id' => 1],
            ['code' => 'Ojén', 'slug' => 'ojen-c26', 'province_id' => 1],
            ['code' => 'Monda', 'slug' => 'monda-c27', 'province_id' => 1],
            ['code' => 'Sierra de Yeguas', 'slug' => 'sierra-de-yeguas-c28', 'province_id' => 1],
        ]);
    }
}

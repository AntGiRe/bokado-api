<?php

namespace Tests\Feature\Api\V1;

use PHPUnit\Framework\Attributes\Test;
use Database\Seeders\CurrenciesTableSeeder;
use Database\Seeders\CurrencyTranslationsTableSeeder;
use Database\Seeders\LanguageTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LanguageTableSeeder::class);
        $this->seed(CurrenciesTableSeeder::class);
        $this->seed(CurrencyTranslationsTableSeeder::class);
    }

    #[Test]
    public function it_returns_paginated_list_of_currencies()
    {
        $response = $this->getJson('/api/v1/currencies');

        $response->assertStatus(200);

        // Verifica la estructura principal
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'code', 'symbol', 'name']
            ],
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        // Verifica valores específicos (ajusta según tu seeder)
        $response->assertJsonFragment([
            'code' => 'USD',
            'symbol' => '$',
            'name' => 'US Dollar'
        ]);
    }

    #[Test]
    public function it_returns_currencies_in_different_locales()
    {
        // Test con locale 'en'
        $responseEn = $this->getJson('/api/v1/currencies?locale=en');

        $responseEn->assertStatus(200);

        $responseEn->assertJsonFragment([
            'name' => 'US Dollar', // Nombre en inglés
        ]);

        // Test con locale 'es'
        $responseEs = $this->getJson('/api/v1/currencies?locale=es');

        $responseEs->assertStatus(200);

        $responseEs->assertJsonFragment([
            'name' => 'Dólar estadounidense', // Nombre en español
        ]);
    }

    #[Test]
    public function it_respects_per_page_parameter()
    {
        // Pidiendo solo 1 por página
        $response = $this->getJson('/api/v1/currencies?per_page=1');

        $response->assertStatus(200);

        $this->assertCount(1, $response->json('data'));

        $response->assertJsonStructure([
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        $this->assertEquals(1, $response->json('pagination.per_page'));
    }

    #[Test]
    public function it_filters_currencies_by_name()
    {
        // Filtrar por 'Dollar' (en inglés)
        $response = $this->getJson('/api/v1/currencies?locale=es&filter=Dólar');

        $response->assertStatus(200);

        // Que la respuesta contenga 'Dólar estadounidense'
        $response->assertJsonFragment([
            'name' => 'Dólar estadounidense',
        ]);

        // Y no contenga otras monedas que no tienen 'Dólar' en el nombre
        $data = $response->json('data');
        foreach ($data as $currency) {
            $this->assertStringContainsString('Dólar', $currency['name']);
        }
    }

    #[Test]
    public function it_returns_a_single_currency()
    {
        // Suponemos que el USD tiene ID 2 (ajusta según tu seeder)
        $response = $this->getJson('/api/v1/currencies/2');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => ['id', 'code', 'symbol', 'name']
        ]);

        $response->assertJsonFragment([
            'id' => 2,
            'code' => 'USD',
            'symbol' => '$',
            'name' => 'US Dollar'
        ]);
    }

    #[Test]
    public function it_returns_404_for_invalid_currency_id()
    {
        $response = $this->getJson('/api/v1/currencies/9999');

        $response->assertStatus(404);
    }
}

<?php

namespace Tests\Feature\Api\V1;

use PHPUnit\Framework\Attributes\Test;
use Database\Seeders\LanguageTableSeeder;
use Database\Seeders\RegionTranslationsTableSeeder;
use Database\Seeders\CountryTranslationsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LanguageTableSeeder::class);
        $this->seed(CountryTranslationsTableSeeder::class);
        $this->seed(RegionTranslationsTableSeeder::class);
    }

    #[Test]
    public function it_returns_paginated_list_of_regions()
    {
        // Requesting the list of regions
        $response = $this->getJson('/api/v1/locations/regions');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'code', 'slug', 'country_id', 'name']
            ],
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        $response->assertJsonFragment([
            'code' => 'Andalucía',
            'slug' => 'andalucia-r1',
            'name' => 'Andalusia'
        ]);
    }

    #[Test]
    public function it_returns_regions_in_different_locales()
    {
        // Testing with locale 'en'
        $responseEn = $this->getJson('/api/v1/locations/regions?locale=en');

        $responseEn->assertStatus(200);

        $responseEn->assertJsonFragment([
            'name' => 'Andalusia',
        ]);

        // Testing with locale 'es'
        $responseEs = $this->getJson('/api/v1/locations/regions?locale=es');

        $responseEs->assertStatus(200);

        $responseEs->assertJsonFragment([
            'name' => 'Andalucía',
        ]);
    }

    #[Test]
    public function it_respects_per_page_parameter()
    {
        // Requesting only 1 per page
        $response = $this->getJson('/api/v1/locations/regions?per_page=1');

        $response->assertStatus(200);

        $this->assertCount(1, $response->json('data'));

        $response->assertJsonStructure([
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        $this->assertEquals(1, $response->json('pagination.per_page'));
    }

    #[Test]
    public function it_filters_countries_by_name()
    {
        // Filter by 'Andalucía'
        $response = $this->getJson('/api/v1/locations/regions?locale=es&filter=Andalucía');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => 'Andalucía',
        ]);

        $data = $response->json('data');
        foreach ($data as $region) {
            $this->assertStringContainsString('Andalucía', $region['name']);
        }
    }

    #[Test]
    public function it_filters_regions_by_country_id()
    {
        // Filter by country_id=1
        $response = $this->getJson('/api/v1/locations/regions?country_id=1');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(6, $data);

        foreach ($data as $region) {
            $this->assertEquals(1, $region['country_id']);
        }
    }

    #[Test]
    public function it_returns_a_single_region()
    {
        // Get region with id 1
        $response = $this->getJson('/api/v1/locations/regions/1');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => ['id', 'code', 'name']
        ]);

        $response->assertJsonFragment([
            'id' => 1,
            'code' => 'Andalucía',
            'name' => 'Andalusia'
        ]);
    }

    #[Test]
    public function it_returns_404_for_invalid_region_id()
    {
        // Get region with invalid id
        $response = $this->getJson('/api/v1/locations/regions/9999');

        $response->assertStatus(404);
    }
}

<?php

namespace Tests\Feature\Api\V1;

use PHPUnit\Framework\Attributes\Test;
use Database\Seeders\LanguageTableSeeder;
use Database\Seeders\RegionTranslationsTableSeeder;
use Database\Seeders\CountryTranslationsTableSeeder;
use Database\Seeders\ProvinceTranslationsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProvinceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LanguageTableSeeder::class);
        $this->seed(CountryTranslationsTableSeeder::class);
        $this->seed(RegionTranslationsTableSeeder::class);
        $this->seed(ProvinceTranslationsTableSeeder::class);
    }

    #[Test]
    public function it_returns_paginated_list_of_provinces()
    {
        $response = $this->getJson('/api/v1/locations/provinces');

        $response->assertStatus(200);

        // Check main structure
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'code', 'slug', 'region_id', 'name']
            ],
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        // Check specific values
        $response->assertJsonFragment([
            'code' => 'Málaga',
            'slug' => 'malaga-p1',
            'name' => 'Malaga'
        ]);
    }

    #[Test]
    public function it_returns_provinces_in_different_locales()
    {
        // Test with locale 'en'
        $responseEn = $this->getJson('/api/v1/locations/provinces?locale=en');

        $responseEn->assertStatus(200);

        $responseEn->assertJsonFragment([
            'name' => 'Malaga',
        ]);

        // Test with locale 'es'
        $responseEs = $this->getJson('/api/v1/locations/provinces?locale=es');

        $responseEs->assertStatus(200);

        $responseEs->assertJsonFragment([
            'name' => 'Malaga',
        ]);
    }

    #[Test]
    public function it_respects_per_page_parameter()
    {
        // Requesting only 1 per page
        $response = $this->getJson('/api/v1/locations/provinces?per_page=1');

        $response->assertStatus(200);

        $this->assertCount(1, $response->json('data'));

        $response->assertJsonStructure([
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        $this->assertEquals(1, $response->json('pagination.per_page'));
    }

    #[Test]
    public function it_filters_provinces_by_name()
    {
        // Filter by 'Malaga'
        $response = $this->getJson('/api/v1/locations/provinces?locale=es&filter=Malaga');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => 'Malaga',
        ]);

        $data = $response->json('data');
        foreach ($data as $province) {
            $this->assertStringContainsString('Malaga', $province['name']);
        }
    }

    #[Test]
    public function it_filters_provinces_by_country_id()
    {
        // Filter by country_id=1
        $response = $this->getJson('/api/v1/locations/provinces?country_id=1');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(2, $data);
    }

    #[Test]
    public function it_filters_provinces_by_region_id()
    {
        // Filter by region_id=1
        $response = $this->getJson('/api/v1/locations/provinces?region_id=1');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(2, $data);

        foreach ($data as $province) {
            $this->assertEquals(1, $province['region_id']);
        }
    }

    #[Test]
    public function it_returns_a_single_province()
    {
        // Get province with id 1
        $response = $this->getJson('/api/v1/locations/provinces/1');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => ['id', 'code', 'name']
        ]);

        $response->assertJsonFragment([
            'id' => 1,
            'code' => 'Málaga',
            'name' => 'Malaga'
        ]);
    }

    #[Test]
    public function it_returns_404_for_invalid_province_id()
    {
        // Get province with invalid id
        $response = $this->getJson('/api/v1/locations/provinces/9999');

        $response->assertStatus(404);
    }
}

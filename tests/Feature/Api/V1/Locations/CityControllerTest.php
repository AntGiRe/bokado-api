<?php

namespace Tests\Feature\Api\V1;

use PHPUnit\Framework\Attributes\Test;
use Database\Seeders\LanguageTableSeeder;
use Database\Seeders\RegionTranslationsTableSeeder;
use Database\Seeders\CountryTranslationsTableSeeder;
use Database\Seeders\ProvinceTranslationsTableSeeder;
use Database\Seeders\CityTranslationsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LanguageTableSeeder::class);
        $this->seed(CountryTranslationsTableSeeder::class);
        $this->seed(RegionTranslationsTableSeeder::class);
        $this->seed(ProvinceTranslationsTableSeeder::class);
        $this->seed(CityTranslationsTableSeeder::class);
    }

    #[Test]
    public function it_returns_paginated_list_of_cities()
    {
        $response = $this->getJson('/api/v1/locations/cities');

        $response->assertStatus(200);

        // Check main structure
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'code', 'slug', 'province_id', 'name']
            ],
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        // Check specific values
        $response->assertJsonFragment([
            'code' => 'Málaga',
            'slug' => 'malaga-c1',
            'name' => 'Málaga'
        ]);
    }

    #[Test]
    public function it_returns_cities_in_different_locales()
    {
        // Test with locale 'en'
        $responseEn = $this->getJson('/api/v1/locations/cities?locale=en');

        $responseEn->assertStatus(200);

        $responseEn->assertJsonFragment([
            'name' => 'Málaga',
        ]);

        // Test with locale 'es'
        $responseEs = $this->getJson('/api/v1/locations/cities?locale=es');

        $responseEs->assertStatus(200);

        $responseEs->assertJsonFragment([
            'name' => 'Málaga',
        ]);
    }

    #[Test]
    public function it_respects_per_page_parameter()
    {
        // Requesting only 1 per page
        $response = $this->getJson('/api/v1/locations/cities?per_page=1');

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
        $response = $this->getJson('/api/v1/locations/cities?locale=es&filter=Malaga');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => 'Málaga',
        ]);

        $data = $response->json('data');
        foreach ($data as $province) {
            $this->assertStringContainsString('Málaga', $province['name']);
        }
    }

    #[Test]
    public function it_filters_cities_by_country_id()
    {
        // Filter by country_id=1
        $response = $this->getJson('/api/v1/locations/cities?country_id=1');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(5, $data);
    }

    #[Test]
    public function it_filters_cities_by_region_id()
    {
        // Filter by region_id=1
        $response = $this->getJson('/api/v1/locations/cities?region_id=1');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(5, $data);
    }

    #[Test]
    public function it_filters_cities_by_province_id()
    {
        // Filter by province_id=1
        $response = $this->getJson('/api/v1/locations/cities?province_id=1');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(5, $data);

        foreach ($data as $city) {
            $this->assertEquals(1, $city['province_id']);
        }
    }

    #[Test]
    public function it_returns_a_single_city()
    {
        // Get city with id 1
        $response = $this->getJson('/api/v1/locations/cities/1');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => ['id', 'code', 'name']
        ]);

        $response->assertJsonFragment([
            'id' => 1,
            'code' => 'Málaga',
            'name' => 'Málaga'
        ]);
    }

    #[Test]
    public function it_returns_404_for_invalid_city_id()
    {
        // Get city with invalid id
        $response = $this->getJson('/api/v1/locations/cities/9999');

        $response->assertStatus(404);
    }
}

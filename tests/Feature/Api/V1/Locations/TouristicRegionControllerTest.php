<?php

namespace Tests\Feature\Api\V1;

use PHPUnit\Framework\Attributes\Test;
use Database\Seeders\LanguageTableSeeder;
use Database\Seeders\TouristicRegionTranslationsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TouristicRegionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LanguageTableSeeder::class);
        $this->seed(TouristicRegionTranslationsTableSeeder::class);
    }

    #[Test]
    public function it_returns_paginated_list_of_touristic_regions()
    {
        $response = $this->getJson('/api/v1/locations/touristic-regions');

        $response->assertStatus(200);

        // Check main structure
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'slug', 'name', 'description']
            ],
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        // Check specific values
        $response->assertJsonFragment([
            'slug' => 'costa-del-sol-tr1',
            'name' => 'Costa del Sol',
            'description' => 'Tourist area famous for its beaches and warm climate in the Málaga province.'
        ]);
    }

    #[Test]
    public function it_returns_touristic_regions_in_different_locales()
    {
        // Test with locale 'en'
        $responseEn = $this->getJson('/api/v1/locations/touristic-regions?locale=en');

        $responseEn->assertStatus(200);

        $responseEn->assertJsonFragment([
            'name' => 'Costa del Sol',
        ]);

        // Test with locale 'es'
        $responseEs = $this->getJson('/api/v1/locations/touristic-regions?locale=es');

        $responseEs->assertStatus(200);

        $responseEs->assertJsonFragment([
            'name' => 'Costa del Sol',
        ]);
    }

    #[Test]
    public function it_respects_per_page_parameter()
    {
        // Requesting only 1 per page
        $response = $this->getJson('/api/v1/locations/touristic-regions?per_page=1');

        $response->assertStatus(200);

        $this->assertCount(1, $response->json('data'));

        $response->assertJsonStructure([
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        $this->assertEquals(1, $response->json('pagination.per_page'));
    }

    #[Test]
    public function it_filters_regions_by_name()
    {
        // Filter by 'Costa del Sol'
        $response = $this->getJson('/api/v1/locations/touristic-regions?locale=es&filter=Costa del Sol');

        $response->assertStatus(200);

        // Check that the response contains 'Costa del Sol'
        $response->assertJsonFragment([
            'name' => 'Costa del Sol',
        ]);

        // And does not contain other regions that do not have 'Costa del Sol' in the name
        $data = $response->json('data');
        foreach ($data as $region) {
            $this->assertStringContainsString('Costa del Sol', $region['name']);
        }
    }

    #[Test]
    public function it_returns_a_single_region()
    {
        // Get region with id 1
        $response = $this->getJson('/api/v1/locations/touristic-regions/1');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => ['id', 'slug', 'name']
        ]);

        $response->assertJsonFragment([
            'id' => 1,
            'slug' => 'costa-del-sol-tr1',
            'name' => 'Costa del Sol'
        ]);

    }

    #[Test]
    public function it_returns_404_for_invalid_region_id()
    {
        // Get region with invalid id
        $response = $this->getJson('/api/v1/locations/touristic-regions/9999');

        $response->assertStatus(404);
    }
}

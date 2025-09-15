<?php

namespace Tests\Feature\Api\V1;

use Database\Seeders\CountryTranslationsTableSeeder;
use PHPUnit\Framework\Attributes\Test;
use Database\Seeders\LanguageTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LanguageTableSeeder::class);
        $this->seed(CountryTranslationsTableSeeder::class);
    }

    #[Test]
    public function it_returns_paginated_list_of_countries()
    {
        $response = $this->getJson('/api/v1/locations/countries');

        $response->assertStatus(200);

        // Check main structure
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'code', 'slug', 'name']
            ],
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        // Check specific values
        $response->assertJsonFragment([
            'code' => 'ES',
            'slug' => 'spain',
            'name' => 'Spain'
        ]);
    }

    #[Test]
    public function it_returns_countries_in_different_locales()
    {
        // Test with locale 'en'
        $responseEn = $this->getJson('/api/v1/locations/countries?locale=en');

        $responseEn->assertStatus(200);

        $responseEn->assertJsonFragment([
            'name' => 'Spain',
        ]);

        // Test with locale 'es'
        $responseEs = $this->getJson('/api/v1/locations/countries?locale=es');

        $responseEs->assertStatus(200);

        $responseEs->assertJsonFragment([
            'name' => 'España',
        ]);
    }

    #[Test]
    public function it_respects_per_page_parameter()
    {
        // Requesting only 1 per page
        $response = $this->getJson('/api/v1/locations/countries?per_page=1');

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
        // Filter by 'España'
        $response = $this->getJson('/api/v1/locations/countries?locale=es&filter=España');

        $response->assertStatus(200);

        // Check that the response contains 'España'
        $response->assertJsonFragment([
            'name' => 'España',
        ]);

        // And does not contain other countries that do not have 'España' in the name
        $data = $response->json('data');
        foreach ($data as $country) {
            $this->assertStringContainsString('España', $country['name']);
        }
    }

    #[Test]
    public function it_returns_a_single_country()
    {
        // Get country with id 1
        $response = $this->getJson('/api/v1/locations/countries/1');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => ['id', 'code', 'name']
        ]);

        $response->assertJsonFragment([
            'id' => 1,
            'code' => 'ES',
            'name' => 'Spain'
        ]);

    }

    #[Test]
    public function it_returns_404_for_invalid_country_id()
    {
        // Get country with invalid id
        $response = $this->getJson('/api/v1/locations/countries/9999');

        $response->assertStatus(404);
    }
}

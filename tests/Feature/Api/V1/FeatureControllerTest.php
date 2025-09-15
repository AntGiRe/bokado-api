<?php

namespace Tests\Feature\Api\V1;

use Database\Seeders\FeatureTranslationsTableSeeder;
use Database\Seeders\FeatureTableSeeder;
use PHPUnit\Framework\Attributes\Test;
use Database\Seeders\LanguageTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LanguageTableSeeder::class);
        $this->seed(FeatureTranslationsTableSeeder::class);
    }

    #[Test]
    public function it_returns_paginated_list_of_features()
    {
        $response = $this->getJson('/api/v1/features');

        $response->assertStatus(200);

        // Check main structure
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'code', 'name']
            ],
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        // Verify specific values (adjust according to your seeder)
        $response->assertJsonFragment([
            'code' => 'terrace',
            'name' => 'Terrace'
        ]);
    }

    #[Test]
    public function it_returns_features_in_different_locales()
    {
        // Test with locale 'en'
        $responseEn = $this->getJson('/api/v1/features?locale=en');

        $responseEn->assertStatus(200);

        $responseEn->assertJsonFragment([
            'name' => 'Terrace',
        ]);

        // Test with locale 'es'
        $responseEs = $this->getJson('/api/v1/features?locale=es');

        $responseEs->assertStatus(200);

        $responseEs->assertJsonFragment([
            'name' => 'Terraza',
        ]);
    }

    #[Test]
    public function it_respects_per_page_parameter()
    {
        // Requesting only 1 per page
        $response = $this->getJson('/api/v1/features?per_page=1');

        $response->assertStatus(200);

        $this->assertCount(1, $response->json('data'));

        $response->assertJsonStructure([
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        $this->assertEquals(1, $response->json('pagination.per_page'));
    }

    #[Test]
    public function it_filters_features_by_name()
    {
        // Filter by 'Terraza'
        $response = $this->getJson('/api/v1/features?locale=es&filter=Terraza');

        $response->assertStatus(200);

        // Check that the response contains 'Terraza'
        $response->assertJsonFragment([
            'name' => 'Terraza',
        ]);

        // And does not contain other features that do not have 'Terraza' in the name
        $data = $response->json('data');
        foreach ($data as $feature) {
            $this->assertStringContainsString('Terraza', $feature['name']);
        }
    }

    #[Test]
    public function it_returns_a_single_feature()
    {
        // Get feature with id 1
        $response = $this->getJson('/api/v1/features/1');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => ['id', 'code', 'name']
        ]);

        $response->assertJsonFragment([
            'id' => 1,
            'code' => 'terrace',
            'name' => 'Terrace'
        ]);

    }

    #[Test]
    public function it_returns_404_for_invalid_feature_id()
    {
        // Get feature with invalid id
        $response = $this->getJson('/api/v1/features/9999');

        $response->assertStatus(404);
    }
}

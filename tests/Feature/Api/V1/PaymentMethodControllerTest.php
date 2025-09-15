<?php

namespace Tests\Feature\Api\V1;

use PHPUnit\Framework\Attributes\Test;
use Database\Seeders\LanguageTableSeeder;
use Database\Seeders\PaymentMethodTranslationsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LanguageTableSeeder::class);
        $this->seed(PaymentMethodTranslationsTableSeeder::class);
    }

    #[Test]
    public function it_returns_paginated_list_of_payment_methods()
    {
        $response = $this->getJson('/api/v1/payment-methods');

        $response->assertStatus(200);

        // Check main structure
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'code', 'name']
            ],
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        // Check specific values
        $response->assertJsonFragment([
            'code' => 'cash',
            'name' => 'Cash'
        ]);
    }

    #[Test]
    public function it_returns_payment_methods_in_different_locales()
    {
        // Test with locale 'en'
        $responseEn = $this->getJson('/api/v1/payment-methods?locale=en');

        $responseEn->assertStatus(200);

        $responseEn->assertJsonFragment([
            'name' => 'Cash',
        ]);

        // Test with locale 'es'
        $responseEs = $this->getJson('/api/v1/payment-methods?locale=es');

        $responseEs->assertStatus(200);

        $responseEs->assertJsonFragment([
            'name' => 'Efectivo',
        ]);
    }

    #[Test]
    public function it_respects_per_page_parameter()
    {
        // Requesting only 1 per page
        $response = $this->getJson('/api/v1/payment-methods?per_page=1');

        $response->assertStatus(200);

        $this->assertCount(1, $response->json('data'));

        $response->assertJsonStructure([
            'pagination' => ['current_page', 'per_page', 'total', 'last_page']
        ]);

        $this->assertEquals(1, $response->json('pagination.per_page'));
    }

    #[Test]
    public function it_filters_payment_methods_by_name()
    {
        // Filter by 'Efectivo'
        $response = $this->getJson('/api/v1/payment-methods?locale=es&filter=Efectivo');

        $response->assertStatus(200);

        // Check that the response contains 'Efectivo'
        $response->assertJsonFragment([
            'name' => 'Efectivo',
        ]);

        // And does not contain other payment methods that do not have 'Efectivo' in the name
        $data = $response->json('data');
        foreach ($data as $currency) {
            $this->assertStringContainsString('Efectivo', $currency['name']);
        }
    }

    #[Test]
    public function it_returns_a_single_payment_method()
    {
        // Get payment method with id 2
        $response = $this->getJson('/api/v1/payment-methods/2');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => ['id', 'code', 'name']
        ]);

        $response->assertJsonFragment([
            'id' => 2,
            'code' => 'cash',
            'name' => 'Cash'
        ]);

    }

    #[Test]
    public function it_returns_404_for_invalid_payment_method_id()
    {
        // Get payment method with invalid id
        $response = $this->getJson('/api/v1/payment-methods/9999');

        $response->assertStatus(404);
    }
}

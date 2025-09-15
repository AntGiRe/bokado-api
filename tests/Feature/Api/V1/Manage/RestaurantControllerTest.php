<?php

namespace Tests\Feature\Api\V1;

use PHPUnit\Framework\Attributes\Test;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    //INDEX
    #[Test]
    public function it_requires_authentication_to_access_restaurants_index()
    {
        $response = $this->getJson('/api/v1/manage/restaurants');

        $response->assertStatus(401);
    }

    #[Test]
    public function it_allows_authenticated_user_to_access_restaurants_index()
    {
        $user = \App\Models\User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/manage/restaurants');

        $response->assertStatus(200);
    }

    //SHOW
    #[Test]
    public function it_requires_authentication_to_access_restaurants_show()
    {
        $response = $this->getJson('/api/v1/manage/restaurants/1');

        $response->assertStatus(401);
    
    }

    #[Test]
    public function it_allows_authenticated_user_to_access_restaurants_show()
    {
        $user = \App\Models\User::factory()->create();
        Sanctum::actingAs($user);

        $restaurant = \App\Models\Restaurant::factory()->create();

        $restaurant->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->getJson("/api/v1/manage/restaurants/{$restaurant->id}");

        $response->assertStatus(200);
    }
}
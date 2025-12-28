<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Location;
use App\Models\User;

class LocationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_locations()
    {
        Location::factory()->count(3)->create();

        $response = $this->getJson('/api/locations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'street',
                            'building_number',
                            'area',
                        ]
                    ],
                    'pagination'
                ]
            ]);
    }

    public function test_can_create_location()
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'street' => 'Test Street',
            'building_number' => '123',
            'area' => 'Test Area',
        ];

        $response = $this->postJson('/api/locations', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'street',
                    'building_number',
                    'area',
                ]
            ]);
        
        $this->assertDatabaseHas('_locations', ['street' => 'Test Street']);
    }

    public function test_can_update_location()
    {
        $location = Location::factory()->create();
        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
            'street' => 'Updated Street',
            'building_number' => '456',
            'area' => 'Updated Area',
        ];

        $response = $this->putJson("/api/locations/{$location->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'street' => 'Updated Street',
                ]
            ]);
        
        $this->assertDatabaseHas('_locations', ['id' => $location->id, 'street' => 'Updated Street']);
    }

    public function test_can_delete_location()
    {
        $location = Location::factory()->create();

        $response = $this->deleteJson("/api/locations/{$location->id}");

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('_locations', ['id' => $location->id]);
    }
}

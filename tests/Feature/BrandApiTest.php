<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Brands;

class BrandApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_brands()
    {
        Brands::factory()->count(3)->create();

        $response = $this->getJson('/api/brands');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'name',
                        ]
                    ],
                    'pagination'
                ]
            ]);
    }

    public function test_can_show_brand()
    {
        $brand = Brands::factory()->create();

        $response = $this->getJson("/api/brands/{$brand->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ]
            ]);
    }

    public function test_can_create_brand()
    {
        $data = [
            'name' => 'Test Brand',
        ];

        $response = $this->postJson('/api/brands', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ]
            ]);
        
        $this->assertDatabaseHas('brands', ['name' => 'Test Brand']);
    }

    public function test_can_update_brand()
    {
        $brand = Brands::factory()->create();

        $data = [
            'name' => 'Updated Brand Name',
        ];

        $response = $this->putJson("/api/brands/{$brand->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Updated Brand Name',
                ]
            ]);
        
        $this->assertDatabaseHas('brands', ['id' => $brand->id, 'name' => 'Updated Brand Name']);
    }

    public function test_can_delete_brand()
    {
        $brand = Brands::factory()->create();

        $response = $this->deleteJson("/api/brands/{$brand->id}");

        $response->assertStatus(200); // Assuming 200 OK for successful deletion, or 204 No Content
        
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }
}

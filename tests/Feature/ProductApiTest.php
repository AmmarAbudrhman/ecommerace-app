<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Products;
use App\Models\Catgories;
use App\Models\Brands;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_products()
    {
        Products::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'price',
                            'image',
                        ]
                    ],
                    'pagination'
                ]
            ]);
    }

    public function test_can_show_product()
    {
        $product = Products::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'image',
                ]
            ]);
    }

    public function test_can_create_product()
    {
        Storage::fake('public');
        $category = Catgories::factory()->create();
        $brand = Brands::factory()->create();

        $data = [
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100.00,
            'amount' => 10,
            'is_trending' => true,
            'is_available' => true,
            'discount' => 0,
            'image' => UploadedFile::fake()->image('product.jpg'),
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'price',
                ]
            ]);
        
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_can_update_product()
    {
        $product = Products::factory()->create();

        $data = [
            'name' => 'Updated Product Name',
        ];

        $response = $this->putJson("/api/products/{$product->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Updated Product Name',
                ]
            ]);
        
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Product Name']);
    }

    public function test_can_delete_product()
    {
        $product = Products::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}

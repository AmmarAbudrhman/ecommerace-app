<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Location;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_orders()
    {
        $user = User::factory()->create();
        Orders::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'user',
                            'location',
                            'total_price',
                            'status',
                            'date_of_delivery',
                            'items',
                            'created_at'
                        ]
                    ],
                    'pagination'
                ]
            ]);
    }

    public function test_can_show_order()
    {
        $order = Orders::factory()->create();
        
        $response = $this->getJson("/api/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user',
                    'location',
                    'total_price',
                    'status',
                    'date_of_delivery',
                    'items',
                    'created_at'
                ]
            ]);
    }

    public function test_can_create_order()
    {
        $user = User::factory()->create();
        $location = Location::factory()->create(['user_id' => $user->id]);
        $product = Products::factory()->create();

        $data = [
            'user_id' => $user->id,
            'location_id' => $location->id,
            'total_price' => 100,
            'date_of_delivery' => '2025-12-31',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'price' => 50
                ]
            ]
        ];

        $response = $this->postJson('/api/orders', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user',
                    'location',
                    'total_price',
                    'status',
                    'date_of_delivery',
                    'items' => [
                        '*' => [
                            'id',
                            'product_id',
                            'quantity',
                            'price'
                        ]
                    ],
                    'created_at'
                ]
            ]);
    }

    public function test_can_update_order()
    {
        $order = Orders::factory()->create();
        
        $data = [
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/orders/{$order->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'status' => 'completed'
                ]
            ]);
    }
}

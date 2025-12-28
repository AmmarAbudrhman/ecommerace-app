<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrderFactory extends Factory
{
    protected $model = \App\Models\Orders::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'location_id' => \App\Models\Location::factory(),
            'total_price' => $this->faker->randomFloat(2, 50, 500),
            'status' => 'pending',
            'date_of_delivery' => $this->faker->date(),
        ];
    }
}

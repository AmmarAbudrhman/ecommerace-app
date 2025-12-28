<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductFactory extends Factory
{
    protected $model = \App\Models\Products::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => \App\Models\Catgories::factory(),
            'brand_id' => \App\Models\Brands::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'is_trending' => $this->faker->boolean,
            'is_available' => $this->faker->boolean,
            'amount' => $this->faker->numberBetween(1, 100),
            'discount' => $this->faker->randomFloat(2, 0, 50),
            'image' => $this->faker->imageUrl(),
        ];
    }
}

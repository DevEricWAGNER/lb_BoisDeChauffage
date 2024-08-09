<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->word,
            'product_description' => $this->faker->paragraph,
            'photo' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(0, 1000, 100000), // Generate a random price
            'type' => $this->faker->word,
            'sales_count' => $this->faker->numberBetween(0, 10), // Optional: if you use sales_count
        ];
    }
}

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
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'sku' => 'sku-' . $this->faker->unique()->numberBetween(1, 100),
            'price' => $this->faker->numberBetween(1000, 9999),
            'initial_stock_quantity' => $this->faker->numberBetween(1, 1000),
            'current_stock_quantity' => $this->faker->numberBetween(1, 1000),
        ];
    }

}

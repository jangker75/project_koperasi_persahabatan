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
            'name' => $this->faker->word(),
            'sku' => $this->faker->randomDigit(),
            'unit_measurement' => 'kilogram (kg)',
            'description' => $this->faker->paragraph(3),
            'cover' => 'default-image.jpg',
            'brand_id' => 1
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $price = rand(1000,10000);
        $qty = rand(1,10);
        return [
            'order_id' => rand(1,10),
            'product_name' => $this->faker->colorName(),
            'price' => $price,
            'qty' => $qty,
            'subtotal' => $price*$qty
        ];
    }
}

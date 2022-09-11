<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $subtotal = rand(10000, 100000);
        return [
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'status_id' => 3,
        ];
    }
}

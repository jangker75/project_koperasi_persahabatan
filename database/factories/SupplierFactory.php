<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Toko ' . $this->faker->name, 
            'contact_name' => $this->faker->name,
            'contact_address' => $this->faker->address(), 
            'contact_phone' => $this->faker->phoneNumber(), 
            'contact_link' => '--'
        ];
    }
}

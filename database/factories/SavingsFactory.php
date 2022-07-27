<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Savings>
 */
class SavingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'principal_savings_amount' => 25000,
            'mandatory_savings_amount' => 0,
            'activity_savings_amount' => 0,
            'voluntary_savings_amount' => 0,
        ];
    }
}

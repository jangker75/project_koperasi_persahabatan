<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyBalance>
 */
class CompanyBalanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_id' => 1,
            'loan_balance' => 0,
            'store_balance' => 0,
            'other_balance' => 0,
            'total_balance' => 0,
        ];
    }
}

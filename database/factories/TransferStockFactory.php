<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransferStock>
 */
class TransferStockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'transfer_stock_code' => $this->faker->regexify('[0-9]{16}'), 
            'from_store_id' => 1, 
            'to_store_id' => 3,
            'status_id' => 3, 
            'req_empl_id' => rand(1,100), 
            'send_empl_id' => rand(101,200), 
            'req_date' => Carbon::now()
        ];
    }
}

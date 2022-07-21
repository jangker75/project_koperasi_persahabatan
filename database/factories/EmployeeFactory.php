<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1, 
            'first_name' => fake()->firstName(), 
            'last_name' => fake()->lastName(),
            'birthday' => fake()->date(), 
            'address_1' => fake()->address(), 
            'address_2' => fake()->address(),
            'nik' => fake()->asciify(), 
            'nip' => fake()->asciify(), 
            'gender' => 'M', 
            'bank' => 'bca', 
            'rekening' => fake()->asciify(),
            'registered_date' => now()
        ];
    }
}

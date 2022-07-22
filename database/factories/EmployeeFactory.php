<?php

namespace Database\Factories;

use App\Models\MasterDataStatus;
use App\Models\Position;
use Database\Seeders\MDStatusSeeder;
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
        $position = Position::pluck('id');
        $statusEmployee = MasterDataStatus::statusEmployee()->pluck('id');
        return [
            'first_name' => fake()->firstName(), 
            'last_name' => fake()->lastName(),
            'birthday' => fake()->date(), 
            'address_1' => fake()->address(), 
            'address_2' => fake()->address(),
            'nik' => fake()->creditCardNumber(), 
            'nip' => fake()->creditCardNumber(), 
            'gender' => 'Laki-Laki', 
            'bank' => 'BCA', 
            'rekening' => fake()->creditCardNumber(),
            'registered_date' => now(),
            'status_employee_id' => $statusEmployee[rand(0, count($statusEmployee) -1 )],
            'position_id' => $position[rand(0, count($position) -1 )],
        ];
    }
}

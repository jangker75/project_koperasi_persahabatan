<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\MasterDataStatus;
use App\Models\Position;
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
        $department = Department::pluck('id');
        $gender = array_keys(\App\Enums\ConstantEnum::GENDER);
        $bank = array_keys(\App\Enums\ConstantEnum::BANK);
        return [
            'first_name' => fake()->firstName(), 
            'last_name' => fake()->lastName(),
            'birthday' => fake()->date(), 
            'address_1' => fake()->address(), 
            'address_2' => '',
            'nik' => fake()->creditCardNumber(), 
            'nip' => fake()->creditCardNumber(), 
            'gender' => $gender[rand(0, 1)],
            'bank' => $bank[rand(0, 1)], 
            'phone' => fake()->phoneNumber(),
            'rekening' => fake()->creditCardNumber(),
            'registered_date' => now(),
            'status_employee_id' => $statusEmployee[rand(0, count($statusEmployee) -1 )],
            'position_id' => $position[rand(0, count($position) -1 )],
            'department_id' => $department[rand(0, count($department) -1 )],
        ];
    }
}

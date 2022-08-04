<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Savings;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make(['nik' => '123456', 'position_id' => 1]);
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole('superadmin');
        });
        
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make(['nik' => '12345678']);
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole(checkPositionRole($employee->position->position_code));
        });
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make(['nik' => '123123123']);
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole(checkPositionRole($employee->position->position_code));
        });
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make(['nik' => '321321321']);
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole(checkPositionRole($employee->position->position_code));
        });
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make(['nik' => '100231232']);
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole(checkPositionRole($employee->position->position_code));
        });

        User::factory(500)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make();
            $employee->position_id = 6;
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole('nasabah');
        });
    }
}

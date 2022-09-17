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
            $employee = Employee::factory()->make([
                'nik' => '12345678',
                'position_id' => 6,
            ]);
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole(checkPositionRole($employee->position->position_code));
        });
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make([
                'nik' => '123123123',
                'position_id' => 2,
            ]);
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole(checkPositionRole($employee->position->position_code));
        });
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make([
                'nik' => '321321321',
                'position_id' => 3,
            ]);
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole(checkPositionRole($employee->position->position_code));
        });
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make([
                'nik' => '100231232',
                'position_id' => 4
        ]);
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole(checkPositionRole($employee->position->position_code));
        });

        User::factory(50)->create()->each(function ($user) {
            // Seed the relation with one employee
            $savings = Savings::factory()->make();
            $employee = Employee::factory()->make();
            $employee->position_id = 7;
            $user->employee()->save($employee);
            $savings->employee_id = $user->employee->id;
            $savings->save();
            $user->assignRole('nasabah');
        });
    }
}

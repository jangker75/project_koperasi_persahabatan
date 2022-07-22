<?php

namespace Database\Seeders;

use App\Models\Employee;
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
            $employee = Employee::factory()->make(['nik' => '123456']);
            $user->employee()->save($employee);
            $user->assignRole('superadmin');
        });
        
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $employee = Employee::factory()->make(['nik' => '12345678']);
            $user->employee()->save($employee);
            $user->assignRole('admin');
        });

        User::factory(500)->create()->each(function ($user2) {
            // Seed the relation with one employee
            $employee = Employee::factory()->make();
            $user2->employee()->save($employee);
            $user2->assignRole('employee');
        });
    }
}

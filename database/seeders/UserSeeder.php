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
            $user->assignRole('usipa');
        });
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $employee = Employee::factory()->make(['nik' => '123123123']);
            $user->employee()->save($employee);
            $user->assignRole('toko');
        });
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $employee = Employee::factory()->make(['nik' => '321321321']);
            $user->employee()->save($employee);
            $user->assignRole('kasir');
        });
        User::factory(1)->create()->each(function ($user) {
            // Seed the relation with one employee
            $employee = Employee::factory()->make(['nik' => '100231232']);
            $user->employee()->save($employee);
            $user->assignRole('manager');
        });

        User::factory(500)->create()->each(function ($user2) {
            // Seed the relation with one employee
            $employee = Employee::factory()->make();
            $user2->employee()->save($employee);
            $user2->assignRole('nasabah');
        });
    }
}

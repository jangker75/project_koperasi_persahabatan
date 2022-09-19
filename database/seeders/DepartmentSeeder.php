<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Honorer',
            'department_code' => 'HONOR',
        ]);
        Department::create([
            'name' => 'Golongan I',
            'department_code' => 'GOLN1',
        ]);
        Department::create([
            'name' => 'Golongan II',
            'department_code' => 'GOLN2',
        ]);
        Department::create([
            'name' => 'Golongan III',
            'department_code' => 'GOLN1',
        ]);
        Department::create([
            'name' => 'Golongan IV',
            'department_code' => 'GOLN4',
        ]);
        Department::create([
            'name' => 'PPPK',
            'department_code' => 'PPPK1',
        ]);
        Department::create([
            'name' => 'KONTRAK',
            'department_code' => 'KONTR',
        ]);
        Department::create([
            'name' => 'FKUI',
            'department_code' => 'FKUI1',
        ]);
        Department::create([
            'name' => 'CPNS',
            'department_code' => 'CPNS1',
        ]);
    }
}

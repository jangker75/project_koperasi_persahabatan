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
            'name' => 'Golongan I-A',
            'department_code' => 'GOL1A',
        ]);
        Department::create([
            'name' => 'Golongan II-A',
            'department_code' => 'GOL2A',
        ]);
        Department::create([
            'name' => 'Golongan I-B',
            'department_code' => 'GOL1B',
        ]);
    }
}

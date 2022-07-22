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
            'name' => 'Poli Gigi',
            'department_code' => 'PGG',
        ]);
        Department::create([
            'name' => 'Poli Anak',
            'department_code' => 'PNK',
        ]);
        Department::create([
            'name' => 'UMUM',
            'department_code' => 'UMM',
        ]);
    }
}

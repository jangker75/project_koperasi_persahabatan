<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name' => 'Staff',
            'position_code' => 'STF',
        ]);
        Position::create([
            'name' => 'Nasabah',
            'position_code' => 'NSB',
        ]);
    }
}

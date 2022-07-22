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
            'name' => 'Staff Koperasi UsiPa',
            'position_code' => 'USP',
        ]);
        Position::create([
            'name' => 'Staff Koperasi Toko',
            'position_code' => 'TKO',
        ]);
        Position::create([
            'name' => 'Staff Koperasi Kasir',
            'position_code' => 'KSR',
        ]);
        Position::create([
            'name' => 'Manager Koperasi',
            'position_code' => 'MGR',
        ]);
        Position::create([
            'name' => 'Nasabah',
            'position_code' => 'NSB',
        ]);
    }
}

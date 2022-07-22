<?php

namespace Database\Seeders;

use App\Models\MasterDataStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MDStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'PNS',
                'type' => 'status_employee',
            ],
            [
                'name' => 'Non PNS',
                'type' => 'status_employee',
            ],
        ];
        collect($data)->each(function($item){
            MasterDataStatus::create($item);
        });
    }
}

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
        $statusEmployee = [
            [
                'name' => 'PNS',
                'type' => 'status_employee',
            ],
            [
                'name' => 'Non PNS',
                'type' => 'status_employee',
            ],
        ];
        $statusLoan = [
            [
                'name' => 'Waiting',
                'type' => 'status_loan_approval',
            ],
            [
                'name' => 'Approved',
                'type' => 'status_loan_approval',
            ],
            [
                'name' => 'Rejected',
                'type' => 'status_loan_approval',
            ],
        ];


        collect($statusEmployee)->each(function($item){
            MasterDataStatus::create($item);
        });
        collect($statusLoan)->each(function($item){
            MasterDataStatus::create($item);
        });
    }
}

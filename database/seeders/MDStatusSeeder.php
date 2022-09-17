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
                'id' => 20,
                'name' => 'PNS',
                'type' => 'status_employee',
            ],
            [
                'id' => 21,
                'name' => 'Kokarda',
                'type' => 'status_employee',
            ],
            [
                'id' => 22,
                'name' => 'BLU',
                'type' => 'status_employee',
            ],
            [
                'id' => 23,
                'name' => 'Kontrak',
                'type' => 'status_employee',
            ],
            [
                'id' => 24,
                'name' => 'PPPK',
                'type' => 'status_employee',
            ],
            [
                'id' => 3,
                'name' => 'Open',
                'description' => 'Tiket ini baru saja dibuat',
                'type' => 'orders,order_suppliers,transfer_stocks',
            ],
            [
                'id' => 4,
                'name' => 'waiting',
                'description' => 'Tiket ini sedang menunggu untuk di process',
                'type' => 'orders,order_suppliers,transfer_stocks',
            ],
            [
                'id' => 5,
                'name' => 'process',
                'description' => 'Tiket ini sedang dikerjakan',
                'type' => 'orders,order_suppliers,transfer_stocks',
            ],
            [
                'id' => 6,
                'name' => 'success',
                'description' => 'Tiket ini berhasil dan sudah selesai dikerjakan',
                'type' => 'orders,order_suppliers,transfer_stocks',
            ],
            [
                'id' => 7,
                'name' => 'failed',
                'description' => 'Tiket ini gagal dikerjakan, dan dibatalkan',
                'type' => 'orders,order_suppliers,transfer_stocks',
            ],
            [
                'id' => 8,
                'name' => 'reject',
                'description' => 'Tiket ini dibatalkan',
                'type' => 'orders,order_suppliers,transfer_stocks',
            ],
        ];
        $statusLoan = [
            [
                'id' => 50,
                'name' => 'Waiting',
                'type' => 'status_loan_approval',
            ],
            [
                'id' => 51,
                'name' => 'Approved',
                'type' => 'status_loan_approval',
            ],
            [
                'id' => 52,
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

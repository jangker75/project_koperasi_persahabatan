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
            [
                'name' => 'Open',
                'description' => 'Tiket ini baru saja dibuat',
                'type' => 'order_supplier,transfer_stock',
            ],
            [
                'name' => 'waiting',
                'description' => 'Tiket ini sedang menunggu untuk di process',
                'type' => 'order_supplier,transfer_stock',
            ],
            [
                'name' => 'process',
                'description' => 'Tiket ini sedang dikerjakan',
                'type' => 'order_supplier,transfer_stock',
            ],
            [
                'name' => 'success',
                'description' => 'Tiket ini berhasil dan sudah selesai dikerjakan',
                'type' => 'order_supplier,transfer_stock',
            ],
            [
                'name' => 'failed',
                'description' => 'Tiket ini gagal dikerjakan, dan dibatalkan',
                'type' => 'order_supplier,transfer_stock',
            ],
            [
                'name' => 'reject',
                'description' => 'Tiket ini dibatalkan',
                'type' => 'order_supplier,transfer_stock',
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

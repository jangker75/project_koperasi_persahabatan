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
                'name' => 'Non PNS',
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
                'type' => 'orders',
                'color_button' => 'btn-info'
            ],
            [
                'id' => 4,
                'name' => 'waiting',
                'description' => 'Tiket ini sedang menunggu untuk di process',
                'type' => 'orders,paylater',
                'color_button' => 'btn-warning'
            ],
            [
                'id' => 5,
                'name' => 'process',
                'description' => 'Tiket ini sedang dikerjakan',
                'type' => 'orders',
                'color_button' => 'btn-warning'
            ],
            [
                'id' => 6,
                'name' => 'success',
                'description' => 'Tiket ini berhasil dan sudah selesai dikerjakan',
                'type' => 'orders,paylater',
                'color_button' => 'btn-success'
            ],
            [
                'id' => 7,
                'name' => 'failed',
                'description' => 'Tiket ini gagal dikerjakan, dan dibatalkan',
                'type' => 'orders',
                'color_button' => 'btn-danger'
            ],
            [
                'id' => 8,
                'name' => 'reject',
                'description' => 'Tiket ini dibatalkan',
                'type' => 'orders',
                'color_button' => 'btn-danger'
            ],
            [
                'id' => 9,
                'name' => 'approved',
                'description' => 'Tiket ini telah disetujui',
                'type' => 'orders,paylater',
                'color_button' => 'btn-success'
            ],
            [
                'name' => 'Create Ticket',
                'description' => 'Pengajuan untuk penambahan stock',
                'type' => 'order_suppliers,transfer_stocks',
            ],
            [
                'name' => 'Approved Ticket',
                'description' => 'Pengajuan Telah di setujui',
                'type' => 'order_suppliers,transfer_stocks',
            ],
            [
                'name' => 'Ordering',
                'description' => 'Sesi Pemesanan',
                'type' => 'order_suppliers,transfer_stocks',
            ],
            [
                'name' => 'Processing',
                'description' => 'Pesanan sedang disiapkan',
                'type' => 'transfer_stocks',
            ],
            [
                'name' => 'Receive',
                'description' => 'Pesanan sudah diterima',
                'type' => 'order_suppliers,transfer_stocks',
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

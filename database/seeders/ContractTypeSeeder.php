<?php

namespace Database\Seeders;

use App\Models\ContractType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = [
            [
                'name' => 'Pinjaman Uang',
                'contract_type_code' => 'P001',
            ],
            [
                'name' => 'Pinjaman Barang',
                'contract_type_code' => 'P002',
            ],
            [
                'name' => 'Pinjaman Lainnya',
                'contract_type_code' => 'P099',
            ],
        ];

        collect($type)->each(function($item){
            ContractType::create($item);
        });
    }
}

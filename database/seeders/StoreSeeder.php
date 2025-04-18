<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
          [
            'name' => 'Warehouse',
            'location' => 'Lt. 2',
            'manager_id' => 1,
            'is_warehouse' => true
          ],
          [
            'name' => 'Toko Rawat Jalan',
            'location' => 'Lt. 1',
            'manager_id' => 2
          ],
        ])->each(function($data){
          Store::create($data);
        });
    }
}

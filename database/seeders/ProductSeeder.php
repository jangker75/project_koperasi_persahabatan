<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::factory(50)->create();

        foreach ($product as $i => $pro) {
          $pr = rand(1,100) . "000";
          $mar = rand(1,20);
          Price::create([
            'product_id' => $pro->id, 
            'cost' => $pr, 
            'revenue' => $pr + ($mar * $pr / 100), 
            'margin' => $mar,
            'profit' => ($pr + ($mar * $pr / 100)) - $pr
          ]);

          Stock::create([
            'product_id' => $pro->id, 
            'store_id' => 1, 
            'qty' => rand(5,50)
          ]);
        }
    }
}

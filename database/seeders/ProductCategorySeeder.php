<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::get();
        $category = Category::get();

        foreach ($product as $key => $prod) {
          foreach ($category as $key => $cat) {
            DB::table('category_has_product')->insert([
              'product_id' => $prod->id,
              'category_id' => $cat->id
            ]);
          }
        }
    }
}

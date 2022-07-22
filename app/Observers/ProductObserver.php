<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function creating(Product $product){
      $product->slug = str($product->name)->slug();
      $product->upc = $product->sku;
    }

    public function updating(Product $product){
      $product->slug = str($product->name)->slug();
      $product->upc = $product->sku;
    }
}

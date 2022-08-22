<?php 
  
namespace App\Services;

use App\Repositories\ProductStockRepositories;

class OrderService{

  public function calculateAllSubtotal($items){
    $skus = array_column($items, 'sku');
    $skus = implode(",",$skus);

    $dataProduct = ProductStockRepositories::findProductBySomeSku($skus);
    $qtys = array_column($items, 'qty');
    $subTotalAll = 0;
    foreach ($dataProduct as $key => $product) {
      $subTotalAll += $product->price * $qtys[$key];
    }

    return $subTotalAll;
  }
}
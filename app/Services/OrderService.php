<?php 
  
namespace App\Services;

use App\Repositories\ProductStockRepositories;

class OrderService{

  public function calculateAllSubtotal($items){
    $skus = array_column($items, 'sku');
    $skus = implode(",",$skus);

    $dataProduct = ProductStockRepositories::findProductBySomeSku($skus);
    $qtys = array_column($items, 'qty');
    $dicounts = array_column($items, 'discount');
    $subTotalAll = 0;
    foreach ($dataProduct as $key => $product) {
      if(isset($dicounts[$key])){
        $subTotalAll += ($product->price * $qtys[$key]) - $dicounts[$key];
      }else{
        $subTotalAll += $product->price * $qtys[$key];
      }
    }

    return $subTotalAll;
  }
}
<?php 
  
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProductStockRepositories{

  public static function findProductOnStockByKeyword($keyword, $notIn = null, $fromStore = null){
    $originStore = $fromStore;
    $notInListProduct = $notIn;
    $keyword = str($keyword)->slug();


    $query = "
      SELECT 
        products.id AS productId,
        products.name AS productName,
        stocks.qty AS qty
      FROM stocks
      LEFT JOIN products ON stocks.product_id = products.id
      WHERE products.slug LIKE '%" . $keyword ."%'
      AND stocks.qty > 0
      ";

    $middle = $originStore !== null ? " AND stocks.store_id = " . $originStore : "";
    $middle = $notInListProduct !== null ? " AND stocks.product_id NOT IN (" . implode(",", $notInListProduct) . ")" : "";
    $lastQuery = " ORDER BY stocks.id DESC LIMIT 6";
    $query = $query.$middle.$lastQuery;

    
    $data = DB::select(DB::raw($query));

    return $data;
  }
}
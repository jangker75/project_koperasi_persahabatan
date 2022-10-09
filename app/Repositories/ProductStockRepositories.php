<?php 
  
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProductStockRepositories{

  public static function findProductOnStockByKeyword($keyword, $notIn = null, $fromStore = null){
    $originStore = $fromStore;
    $notInListProduct = $notIn;
    $keyword = str($keyword)->slug();

    $middle = "";

    $query = "
      SELECT 
        products.id AS productId,
        products.name AS productName,
        products.sku AS productSKU,
        products.cover as productCover,
        stocks.qty AS qty,
        prices.revenue as price
      FROM stocks
        LEFT JOIN products ON stocks.product_id = products.id
        LEFT JOIN prices ON products.id = prices.product_id AND prices.is_active = 1 AND prices.deleted_at is null
      WHERE 
        products.slug LIKE '%" . $keyword ."%'
        AND stocks.qty > 0
      ";

    if($originStore !== null){
      $middle .= " AND stocks.store_id = " . $originStore;
    }
    if($notInListProduct !== null){
      $middle .= " AND stocks.product_id NOT IN (" . implode(",", $notInListProduct) . ")";
    }
    
    $lastQuery = " GROUP BY products.id ORDER BY stocks.id DESC LIMIT 6";
    $query = $query.$middle.$lastQuery;

    $data = DB::select(DB::raw($query));

    return $data;
  }

  public static function findProductBySku($sku, $storeId = null){
    $storeQuery = "";

    if($storeId !== null){
      $storeQuery = " AND stocks.store_id = " . $storeId . " AND stocks.qty > 0";
    }
    
    $sql = "
        SELECT
          products.id AS id,
          products.name AS title,
          products.sku AS sku,
          products.cover,
          products.description,
	        products.unit_measurement,
	        IF(brands.name IS NULL, '--', brands.name) AS brandName,
          (SELECT prices.revenue FROM prices WHERE prices.product_id = products.id ORDER BY prices.id DESC LIMIT 1) AS price,
          stocks.qty AS stock
        FROM 
          products
          LEFT JOIN stocks ON products.id = stocks.product_id
          LEFT JOIN brands ON products.brand_id = brands.id
        WHERE
          (products.sku = '".$sku."' OR products.slug LIKE '%" . str($sku)->slug() . "%')" . $storeQuery;

    // dd($sql);
    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public static function findProductBySomeSku($sku){
    $sql = "
      SELECT
        products.id AS id,
        products.name AS title,
        products.sku AS sku,
        products.cover,
        (SELECT prices.revenue FROM prices WHERE prices.product_id = products.id AND prices.is_active = true ORDER BY prices.id DESC LIMIT 1) AS price
      FROM 
        products
      WHERE
        products.sku IN (" . $sku . ")
    ";
    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public static function getDataonStockbyStore($storeId, $page = null, $category = null){
    $pages = 1;
    $joinCategory = "";
    $clauseCategory = "";

    if($page !== null){
      $pages = $page;
    }

    if($category !== null){
      $joinCategory = "
        JOIN category_has_product ON products.id = category_has_product.product_id
        JOIN categories ON categories.id = category_has_product.category_id
      ";

      $clauseCategory = " AND categories.id = $category";
    }

    $sql = "
      SELECT
        products.id AS id,
        products.name AS title,
        products.sku AS sku,
        products.cover,
        (SELECT prices.revenue FROM prices WHERE prices.product_id = products.id ORDER BY prices.id DESC LIMIT 1) AS price,
        stocks.qty AS stock,
        stocks.store_id AS storeId
      FROM 
        products
        LEFT JOIN stocks ON products.id = stocks.product_id " . 
        $joinCategory . "
      WHERE 
        stocks.store_id = " . $storeId 
        . " AND stocks.qty > 0 " . $clauseCategory . "
      ORDER BY products.id DESC
      LIMIT 20 OFFSET " . ($pages - 1) * 20 . "
    ";

    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public function indexStock($storeId = null){
    if($storeId !== null){
      $whereClause = " WHERE stocks.store_id = ". $storeId;
    }else{
      $whereClause = "";
    }

    $sql = "
      SELECT
        stocks.product_id AS id,
        products.name AS name,
      products.sku AS sku,
        (SELECT GROUP_CONCAT(stores.name)  FROM stores) AS store_name,
        GROUP_CONCAT(stocks.qty) AS qty
      FROM stocks 
        LEFT JOIN products ON stocks.product_id = products.id AND products.deleted_at IS NULL
      " . $whereClause . "
      GROUP BY 
        stocks.product_id
      ORDER BY
        stocks.store_id ASC
    ";

    $data = DB::select(DB::raw($sql));

    return $data;
  }
}
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
        products.deleted_at IS NULL AND
        (products.slug LIKE '%" . $keyword ."%' OR products.sku LIKE '%" . $keyword ."%')
        AND stocks.qty > 0
      ";

    if($originStore !== null){
      $middle .= " AND stocks.store_id = " . $originStore;
    }

    if($notInListProduct !== null){
      $middle .= " AND stocks.product_id NOT IN (" . implode(",", $notInListProduct) . ")";
    }

    $lastQuery = " GROUP BY products.id ORDER BY stocks.id DESC LIMIT 12";
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

  public static function findProductById($id, $storeId = null){
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
          products.id = " . $id . $storeQuery;

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
      $whereClause = " AND stocks.store_id = ". $storeId . " AND orders.store_id = " . $storeId;
    }else{
      $whereClause = "";
    }

    $sql = "
      SELECT
        stocks.product_id AS id,
        products.name AS name,
        products.sku AS sku,
        (SELECT GROUP_CONCAT(stores.name)  FROM stores) AS store_name,
        stocks.qty AS qty,
        GROUP_CONCAT(DISTINCT
            JSON_OBJECT(
              'store_id', stocks.store_id,
              'quantity' , stocks.qty
            )
          SEPARATOR '@'
        ) AS qtyResult
      FROM stocks
        LEFT JOIN products ON stocks.product_id = products.id AND products.deleted_at IS NULL
        LEFT JOIN order_details ON order_details.product_name = products.name
        LEFT JOIN orders ON order_details.order_id = orders.id
      WHERE products.id IS NOT NULL
      " . $whereClause . "
      GROUP BY
        stocks.product_id
      ORDER BY
        stocks.store_id ASC
    ";

    return DB::select(DB::raw($sql));
  }

  public function indexProduct(){
    $sql = "
      SELECT
        products.id AS id,
        products.name AS name,
        products.sku AS sku,
        products.unit_measurement AS unit_measurement,
        prices.revenue AS price,
        if(brands.name IS NULL, '--', brands.name) AS brand
      FROM products
      LEFT JOIN prices ON products.id = prices.product_id AND prices.deleted_at IS NULL AND prices.is_active = 1
      LEFT JOIN brands ON products.brand_id = brands.id AND brands.deleted_at IS NULL
      GROUP BY
        products.id
    ";
    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public function getProdukFromOrderToday($storeId){
    $sql = "
      SELECT
        products.id,
        products.sku,
        sum(order_details.qty) as qtyOrder,
        order_details.product_name as name,
        stocks.qty
      FROM orders
        LEFT JOIN order_details ON orders.id = order_details.order_id AND order_details.deleted_at IS NULL
        LEFT JOIN products ON order_details.product_name = products.name
        LEFT JOIN stocks ON stocks.store_id = " . $storeId . " AND products.id = stocks.product_id
      WHERE
        DATE(orders.order_date) = CURDATE() AND
        orders.store_id = " . $storeId . " AND
        orders.deleted_at IS NULL
      GROUP BY order_details.product_name
    ";

    return DB::select(DB::raw($sql));
  }

  public function getProductByCategoryId($storeId, $categoryId){
    $sql = "
      SELECT
        products.id,
        products.sku,
        products.name,
        stocks.qty
      FROM categories
      LEFT JOIN category_has_product ON categories.id = category_has_product.category_id
      LEFT JOIN products ON category_has_product.product_id = products.id
      LEFT JOIN stocks ON products.id = stocks.product_id AND stocks.store_id = " . $storeId . "
      LEFT JOIN order_details ON order_details.product_name = products.name
      LEFT JOIN orders ON order_details.order_id = orders.id
      WHERE
        categories.id = " . $categoryId . " AND categories.deleted_at IS NULL
        AND orders.store_id = " . $storeId . "
      GROUP BY category_has_product.product_id
    ";

    return DB::select(DB::raw($sql));
  }

  public function listingRekapitulasiData($download = false, $request){

    $page = isset($request->page) ? $request->page : 1;
    $limit = isset($request->size) ? $request->size : 10;
    $order_by = isset($request->order_by) ? $request->order_by : 'products.id';
    $order_method = isset($request->order_method) ? $request->order_method : 'asc';
    $store = isset($request['store']) ? $request['store'] : (isset($request->store) ? $request->store : 1);
    $search = isset($request->search) ? implode(' ', explode('-',$request->search)) : null;

    $query = DB::query()->select(
      'products.id',
      'products.name',
      'products.sku',
      'stocks.store_id',
      'stores.name as store_name',
      'stocks.qty',
      DB::raw('(SELECT prices.cost FROM prices WHERE prices.product_id = products.id and is_active = 1 ORDER BY prices.id DESC LIMIT 1) AS cost'),
      DB::raw('(SELECT prices.revenue FROM prices WHERE prices.product_id = products.id and is_active = 1 ORDER BY prices.id DESC LIMIT 1) AS revenue'),
    )->from('products')
      ->leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
      ->leftJoin('stores', 'stocks.store_id', '=', 'stores.id')
    ->whereNull('products.deleted_at')
    ->where('stocks.store_id', $store);

    if($download == false){
      if($search != null){
        $query->where('products.name', 'like','%' . $search . '%');
      }
    }

    $query->groupBy('products.id');
    $query->groupBy('stocks.store_id');

    if($download == false){
      if($order_by == 'prices.cost'){
        $query->orderByRaw('(select cost from prices where prices.product_id = products.id and is_active = 1 ORDER BY prices.id DESC LIMIT 1) '. $order_method);
      }else if($order_by == 'prices.revenue'){
        $query->orderByRaw('(select cost from prices where prices.product_id = products.id  and is_active = 1 ORDER BY prices.id DESC LIMIT 1) '.  $order_method);
      }else{
        $query->orderBy($order_by, $order_method);
      }
      $paginate = $query->paginate($limit)->toArray();
      $data = [
        'current' => $paginate['current_page'],
        'total' => $paginate['total'],
        'perPage' => $paginate['per_page'],
        'first' => $paginate['from'],
        'last' => $paginate['to'],
        'links' => $paginate['links'],
        'data' => $paginate['data']
      ];
    }else{
      $data = $query->get()->toArray();
    }

    return $data;
  }
}

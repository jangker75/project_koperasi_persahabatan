<?php 
  
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OrderSupplierRepository{
  public function getItemFromId($id){
    $sql = "
      SELECT 
        detail_order_suppliers.id AS id,
        detail_order_suppliers.product_id AS productId,
        products.name as productName,
        detail_order_suppliers.request_qty AS quantity,
        detail_order_suppliers.request_unit AS unit,
        products.name as title,
        prices.cost as priceCost,
        prices.revenue as priceRevenue,
        prices.margin as priceMargin,
        prices.profit as priceProfit
      FROM 
      detail_order_suppliers
      LEFT JOIN order_suppliers ON detail_order_suppliers.order_supplier_id = order_suppliers.id
      LEFT JOIN products ON detail_order_suppliers.product_id = products.id
      LEFT JOIN prices ON products.id = prices.product_id AND prices.is_active = 1
      WHERE 
      detail_order_suppliers.order_supplier_id = " . $id . " AND detail_order_suppliers.deleted_at IS NULL";

    $data = DB::select(DB::raw($sql));

    return $data;
  }
}
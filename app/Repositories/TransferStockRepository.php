<?php 
  
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TransferStockRepository {
  public static function getItemFromId($id){
    $sql = "
      SELECT 
        detail_transfer_stocks.id AS id,
        detail_transfer_stocks.product_id AS productId,
        products.name as productName,
        stocks.qty AS stock,
        detail_transfer_stocks.request_qty AS quantity,
        CONCAT(products.name, ' (stock : ',stocks.qty,')') as title
      FROM 
      detail_transfer_stocks
      LEFT JOIN transfer_stocks ON detail_transfer_stocks.transfer_stock_id = transfer_stocks.id
      LEFT JOIN products ON detail_transfer_stocks.product_id = products.id
      LEFT JOIN stocks ON products.id = stocks.product_id AND transfer_stocks.from_store_id = stocks.store_id
      WHERE 
      detail_transfer_stocks.transfer_stock_id = " . $id . " AND detail_transfer_stocks.deleted_at IS NULL";

    $data = DB::select(DB::raw($sql));

    return $data;
  }
}
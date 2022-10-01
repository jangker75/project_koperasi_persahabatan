<?php 
  
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OpnameRepository{

  public function findDetailOpnameByOpnameId($id){
    $sql = "SELECT 
        opname_details.opname_id AS opnameId,
        products.name AS productName,
        products.sku AS productSku,
        opname_details.quantity AS quantity,
        opname_details.description AS description,
        opname_details.price AS price,
        opname_details.amount AS amount,
        opname_details.is_expired AS isExpired,
        opname_details.type AS type
      FROM opname_details
        LEFT JOIN products ON opname_details.product_id = products.id
      WHERE 
        opname_details.opname_id = " . $id . " AND 
        opname_details.deleted_at IS NULL 
    ";

    $data = DB::select(DB::raw($sql));

    return $data;
  }
}
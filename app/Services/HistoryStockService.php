<?php 
  
namespace App\Services;

use App\Models\HistoryStock;

class HistoryStockService{

  public function update($mode = "order", $params){
    if($mode == "order"){
      $title = "Stock berkurang dari pembelian kode order : " . $params['orderCode'] . " dengan jumlah " . $params['qty'];
      $type = "deduction";
    }else if($mode == "transfer"){
      $title = "Stock berpindah dari " . $params["from"] . " ke " . $params["destination"];
      $type = "move";
    }else if($mode == "supply"){
      $title = "Stock bertambah dari pengadaan barang kode : " . $params['orderSupplyCode'];
      $type = "induction";
    }else if($mode == "opname"){
      $title = "Stock berkurang dari stock opname kode : " . $params['opnameCode'];
      $type = "deduction";
    }else if($mode == "rejection"){
      $title = "Penambahan Stock karna pembatalan Order : " . $params['orderCode'] . " dengan jumlah ". $params['qty'];
      $type = 'induction';
    }

    HistoryStock::create([
      "product_id" => $params['productId'],
      "title" => $title,
      "qty" => $params['qty'],
      "type" => $type
    ]);
  }
}
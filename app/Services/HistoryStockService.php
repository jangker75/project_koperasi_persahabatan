<?php 
  
namespace App\Services;
use Illuminate\Support\Facades\Auth;

use App\Models\HistoryStock;

class HistoryStockService{

  public function update($mode = "order", $params, $user = null){
    $userby = ($user ? (" | by: " . $user['first_name'] . " " . $user['last_name']) : (auth()->user() ? (" | by: " . auth()->user()->employee->full_name) : ""));
    if($mode == "order"){
      $title = "Stock berkurang dari pembelian kode order : " . $params['orderCode'] . " dengan jumlah " . $params['qty'] . $userby;
      $type = "deduction";
    }else if($mode == "transfer"){
      $title = "Stock berpindah dari " . $params["from"] . " ke " . $params["destination"] . $userby;
      $type = "move";
    }else if($mode == "supply"){
      $title = "Stock bertambah dari pengadaan barang kode : " . $params['orderSupplyCode'] . $userby;
      $type = "induction";
    }else if($mode == "opname"){
      if($params['type'] == 'minus'){
        $title = "Stock berkurang dari stock opname kode : " . $params['opnameCode'] . $userby;
        $type = "deduction";
      }else{
        $title = "Stock bertambah dari stock opname kode : " . $params['opnameCode'] . $userby;
        $type = "induction";
      }
    }else if($mode == "rejection"){
      $title = "Penambahan Stock karna pembatalan Order : " . $params['orderCode'] . " dengan jumlah ". $params['qty'] . $userby;
      $type = 'induction';
    }else if($mode == "return"){
      $title = "Stock berkurang dari Return, kode : " . $params['returnCode'] . $userby;
      $type = "deduction";
    }else if($mode == "cancel-return"){
      $title = "Stock bertambah dari Pembatalan Return, kode : " . $params['returnCode'] . $userby;
      $type = "induction";
    }

    HistoryStock::create([
      "product_id" => $params['productId'],
      "title" => $title,
      "qty" => $params['qty'],
      "type" => $type
    ]);
  }
}
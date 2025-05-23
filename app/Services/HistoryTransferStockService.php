<?php 
  
namespace App\Services;

use App\Models\HistoryTransferStock;
use App\Models\MasterDataStatus;
use App\Models\TransferStock;
use Illuminate\Support\Facades\Auth;

class HistoryTransferStockService{

  public static function update($status, $transferStockId, $user = null){
    $transferStock = TransferStock::find($transferStockId);
    $userby = ($user ? (" | by: " . $user['first_name'] . " " . $user['last_name']) : (auth()->user() ? (" | by: " . auth()->user()->employee->full_name) : ""));

    if($status == "Create Ticket"){
      $title = Auth::user()->employee->full_name . " telah membuat ticket transfer stock dengan Kode: ". $transferStock->transfer_stock_code . $userby;
    }
    else if($status == "Approved Ticket"){
      $title = "Pengajuan sudah disetujui, transfer stock Kode: " . $transferStock->transfer_stock_code . $userby;
    }
    else if($status == "Ordering"){
      $title = Auth::user()->employee->full_name . " telah memulai proses order, transfer stock Kode: " . $transferStock->transfer_stock_code . $userby;
    }
    else if($status == "Processing"){
      $title = "Konfirmasi ketersediaan berhasil, Order sedang disiapkan, transfer stock Kode: " . $transferStock->transfer_stock_code . $userby;
    }
    else if($status == "Receive"){
      $title = "Order Sudah diterima, transfer stock Kode: " . $transferStock->transfer_stock_code . $userby;
    }
    else if($status == "reject"){
      $title = "Order Sudah dibatalkan, transfer stock Kode: " . $transferStock->transfer_stock_code . $userby;
    }

    HistoryTransferStock::create([
      'title' => $title,
      'status' => $status,
      'transfer_stock_id' => $transferStockId
    ]);

    $status = MasterDataStatus::where('name', $status)->first();
    $transferStock->status_id = $status->id;
    $transferStock->save();
  }
}
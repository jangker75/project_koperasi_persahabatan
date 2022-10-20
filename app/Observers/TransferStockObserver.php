<?php

namespace App\Observers;

use App\Models\HistoryTransferStock;
use App\Models\MasterDataStatus;
use App\Models\TransferStock;
use App\Services\CodeService;
use Illuminate\Support\Facades\Auth;

class TransferStockObserver
{
    public function creating(TransferStock $TransferStock){
      $status = MasterDataStatus::where('name','Create Ticket')->first();
      $code = new CodeService();
      $TransferStock->transfer_stock_code = $code->generateCode("TS-");
      $TransferStock->status_id = $status->id;
    }

    public function created(TransferStock $TransferStock){
      HistoryTransferStock::create([
        'title' => $TransferStock->Requester->name . " telah membuat ticket transfer stock dengan Kode: ". $TransferStock->transfer_stock_code,
        'status' => 'Create Ticket',
        'transfer_stock_id' => $TransferStock->id
      ]);
    }
}

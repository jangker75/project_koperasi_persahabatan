<?php

namespace App\Observers;

use App\Models\TransferStock;
use App\Services\CodeService;

class TransferStockObserver
{
    public function creating(TransferStock $TransferStock){
      $code = new CodeService();
      $TransferStock->transfer_stock_code = $code->generateCode("TS-");
      $TransferStock->status_id = 3;
    }
}

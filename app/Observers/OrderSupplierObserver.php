<?php

namespace App\Observers;

use App\Models\OrderSupplier;
use App\Services\CodeService;

class OrderSupplierObserver
{
    public function creating(OrderSupplier $OrderSupplier){
      $code = new CodeService();
      $OrderSupplier->order_supplier_code = $code->generateCode("OS-");
      $OrderSupplier->status_id = 3;
    }
}

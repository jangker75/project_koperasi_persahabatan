<?php

namespace App\Observers;

use App\Models\ReturnSupplier;
use App\Services\CodeService;

class ReturnSupplierObserver
{
    public function creating(ReturnSupplier $ReturnSupplier){
      $code = new CodeService();
      $ReturnSupplier->return_supplier_code = $code->generateCodeFromDate('RTN-');
    }
}

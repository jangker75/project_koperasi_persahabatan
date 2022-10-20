<?php

namespace App\Observers;

use App\Models\Supplier;
use App\Services\CodeService;

class SupplierObserver
{
    public function creating(Supplier $supplier){
      $code = new CodeService();
      $supplier->supplier_code = $code->generateCodeFromName($supplier->name, $length = 8);
    }
}

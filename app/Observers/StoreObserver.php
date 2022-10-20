<?php

namespace App\Observers;

use App\Models\Store;
use App\Services\CodeService;

class StoreObserver
{
    public function creating(Store $Store){
      $code = new CodeService();
      $Store->Store_code = $code->generateCodeFromName($Store->name,"", $length = 8);
    }
}

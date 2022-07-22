<?php

namespace App\Observers;

use App\Models\Brand;
use App\Services\CodeService;

class BrandObserver
{
    public function creating(Brand $brand){
      $code = new CodeService();
      $brand->brand_code = $code->generateCodeFromName($brand->name, $length = 8);
    }
}

<?php

namespace App\Observers;

use App\Models\Opname;
use App\Services\CodeService;

class OpnameObserver
{
    public function creating(Opname $opname){
      $opname->opname_code = (new CodeService())->generateCodeFromDate("SO-00-");
    }
}

<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\CodeService;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{
    public function creating(Order $order){
      $codeSr = new CodeService();
      $order->order_code = $codeSr->generateCodeFromDate("OR-");
    }
}

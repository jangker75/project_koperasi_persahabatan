<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.payment-method.index');
        $this->data['link'] = url('api/payment-method');
    }

    public function index(){
      $data = $this->data;
      $data['titlePage'] = 'Kelola Data Metode Pembayaran';
      return view('admin.pages.toko.payment-method.index', $data);
    }
}

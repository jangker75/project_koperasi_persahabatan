<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends BaseAdminController
{
    public function __construct()
    {
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.supplier.index');
        $this->data['link'] = url('api/supplier');
    }

    public function index(){
      $data = $this->data;
      $data['titlePage'] = 'Kelola Data Pemasok';
      $data['suppliers'] = Supplier::latest()->get();
      return view('admin.pages.toko.supplier.index', $data);
    }
}

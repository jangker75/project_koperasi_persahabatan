<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.brand.index');
        $this->data['link'] = url('api/brand');
    }

    public function index(){
      $data = $this->data;
      $data['titlePage'] = 'Kelola Data Brand';
      return view('admin.pages.toko.brand.index', $data);
    }
}

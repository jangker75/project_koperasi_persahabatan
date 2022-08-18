<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends BaseAdminController
{
    public function __construct()
    {
        $this->data['currentIndex'] = route('admin.dashboard');
    }
    public function index()
    {
        $data = $this->data;
        $data['titlePage'] = 'Dashboard';
        return view('admin.pages.dashboard.index', $data);
    }

    public function posCheckout(){
      $data['titlePage'] = 'Checkout Order';

      return view('admin.pos.checkout', $data);
    }
}

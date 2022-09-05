<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use App\Models\Loan;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Store;
use App\Repositories\OrderRepository;
use App\Repositories\PaylaterRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseAdminController
{
    public function __construct()
    {
        $this->data['currentIndex'] = route('admin.dashboard');
    }
    public function index()
    {
        $data = $this->data;
        $data['loanNew'] = Loan::where('loan_approval_status_id','=',50)->orderBy('id','desc')->limit(5)->get();
        $data['titlePage'] = 'Dashboard';
        return view('admin.pages.dashboard.index', $data);
    }

    public function posCheckout(){
      $data['titlePage'] = 'Checkout Order';
      $data['stores'] = Store::where('is_warehouse', false)->get();
      $data['paymentMethod'] = PaymentMethod::get();
      return view('admin.pos.checkout', $data);
    }

    public function requestOrder(){
      $data['titlePage'] = 'Data Permintaan Order dari Nasabah';
      $data['orders'] = OrderRepository::getOrderFromEmployee();
      return view('admin.pos.paylater-index', $data);
    }

    public function detailRequestOrder($orderCode){
      $data['titlePage'] = 'Data Paylater '. $orderCode;
      $data['order'] = Order::where('order_code', $orderCode)->first();
      $data['employee'] = Auth::user()->employee;
      $data['tax'] = ApplicationSetting::where('name', 'tax')->first();
      $data['paymentMethod'] = PaymentMethod::where('name', '!=', 'paylater')->get();
      return view('admin.pos.paylater-detail', $data);
    }
}

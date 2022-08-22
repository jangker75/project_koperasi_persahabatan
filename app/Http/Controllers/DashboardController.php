<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\PaymentMethod;
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
        $data['loanNew'] = Loan::where('loan_approval_status_id','=',50)->orderBy('id','desc')->limit(5)->get();
        $data['titlePage'] = 'Dashboard';
        return view('admin.pages.dashboard.index', $data);
    }

    public function posCheckout(){
      $data['titlePage'] = 'Checkout Order';
      $data['paymentMethod'] = PaymentMethod::get();
      return view('admin.pos.checkout', $data);
    }
}

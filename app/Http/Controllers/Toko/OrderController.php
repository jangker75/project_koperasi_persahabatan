<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Models\Employee;
use App\Models\MasterDataStatus;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Repositories\OrderRepository;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.order.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $data['titlePage'] = "List Order";
        $data['employees'] = Employee::whereNull('resign_date')->get();
        return view('admin.pages.toko.order.index', $data);
    }

    public function show($orderCode){
      $data = $this->data;
      $data['order'] = Order::where('order_code', $orderCode)->first();
      $data['titlePage'] = "Detail Order ". $data['order']->order_code;
      $data['employee'] = Auth::user()->employee;
      $data['tax'] = ApplicationSetting::where('name', 'tax')->first();
      $data['paymentMethod'] = PaymentMethod::where('name', '!=', 'paylater')->get();

      return view('admin.pages.toko.order.show', $data);
    }

    public function paid($orderCode){
      $order = Order::where('order_code', $orderCode)->first();
      $order->transaction->is_paid = true;
      $order->transaction->save();
      (new CompanyService())->addCreditBalance($order->transaction->amount, 'store_balance', 'paylater');

      return redirect()->back();
    }
}

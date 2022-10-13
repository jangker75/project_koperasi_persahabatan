<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Models\MasterDataStatus;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Repositories\OrderRepository;
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
        $waiting = MasterDataStatus::where('name', 'waiting')->first();
        $data['orders'] = Order::where('status_id', '!=', $waiting->id)->latest()->get();
        $data['orders'] = (new OrderRepository())->getAllOrders();
        // dd($data['orders']);
        $data['titlePage'] = "List Order";
        $data['statuses'] = collect(DB::select(DB::raw("SELECT name, description FROM master_data_statuses WHERE master_data_statuses.`type` LIKE '%orders%'")))->toArray();
        
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
}

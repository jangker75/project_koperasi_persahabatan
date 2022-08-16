<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
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
        $data['order'] = Order::latest()->get();
        $data['titlePage'] = "List Order";
        $data['statuses'] = collect(DB::select(DB::raw("SELECT name, description FROM master_data_statuses WHERE master_data_statuses.`type` LIKE '%orders%'")))->toArray();

        return view('admin.pages.toko.order.index', $data);
    }

    public function show($id){
      $data = $this->data;
      $data['order'] = Order::find($id);
      $data['titlePage'] = "Detail Order ". $data['order']->order_code;

      return view('admin.pages.toko.order.index', $data);
    }
}

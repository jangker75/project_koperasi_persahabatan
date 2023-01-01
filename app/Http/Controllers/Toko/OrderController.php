<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
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
use Yajra\DataTables\DataTables;

class OrderController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
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

    public function getIndexDatatables()
    {
        $query = Order::query()
        ->select(
          'orders.*',
          DB::raw('concat("Rp. ", format(orders.total, 0)) as totalPrice'),
          DB::raw('IF(employees.first_name is null, "-", concat(employees.first_name, " ", employees.last_name)) as employee'),
          DB::raw('SUM(order_details.qty) as totalQtyProduct'),
          DB::raw('IF(transactions.is_paylater = 1, "ya", "tidak") as isPaylater'),
          DB::raw('IF(transactions.is_delivery = 1, "ya", "tidak") as isDelivery'),
          DB::raw('IF(transactions.is_paid = 1, "Lunas", "Belum Lunas") as isPaid'),
          'master_data_statuses.name as statusOrder'
        )
        ->leftJoin('transactions', 'orders.id', '=', 'transactions.order_id')
        ->leftJoin('employees', 'transactions.requester_employee_id', '=', 'employees.id')
        ->leftJoin('order_details', 'orders.id', '=','order_details.order_id')
        ->leftJoin('master_data_statuses', 'orders.status_id', '=', 'master_data_statuses.id')
        ->whereNull('order_details.deleted_at')
        ->where('orders.status_id', 6)
        ->groupBy('orders.id');

        $datatable = new DataTables();
        return $datatable->eloquent($query)
          ->addIndexColumn(true)
          ->addColumn('actions', function($row){
              $btn = '<a href="'.route('admin.order.show', $row['order_code']).'"
                class="btn btn-primary btn-sm me-1" data-toggle="tooltip" data-placement="top"
                target="_blank" title="Lihat Detail Produk">Lihat Detail</a>';
              return $btn;
          })
          ->filterColumn('employee', function($query, $keyword) {
              $sql = "CONCAT(employees.first_name,'-',employees.last_name)  like ?";
              $query->whereRaw($sql, ["%{$keyword}%"]);
          })
          ->filterColumn('totalPrice', function($query, $keyword) {
              $sql = "orders.total like ?";
              $query->whereRaw($sql, ["%{$keyword}%"]);
          })
          ->filterColumn('isPaylater', function($query, $keyword) {
              if($keyword == "ya"){
                $sql = "transactions.is_paylater = 1";
                $query->whereRaw($sql);
              }else{
                $sql = "transactions.is_paylater != 1";
                $query->whereRaw($sql);
              }
          })
          ->filterColumn('isDelivery', function($query, $keyword) {
              if($keyword == "ya"){
                $sql = "transactions.is_delivery = 1";
                $query->whereRaw($sql);
              }else{
                $sql = "transactions.is_delivery != 1";
                $query->whereRaw($sql);
              }
          })
          ->filterColumn('isPaid', function($query, $keyword) {
              if($keyword == "lunas"){
                $sql = "transactions.is_paid = 1";
                $query->whereRaw($sql);
              }else{
                $sql = "transactions.is_paid != 1";
                $query->whereRaw($sql);
              }
          })
          ->filter(function($queryNew) {
              if(request()->has('date')){
                $date = explode(",", request('date'));
                $sql = "orders.order_date between '" . $date[0] ." 00:00:00' AND '" . $date[1] . " 23:59:59'" ;
                $queryNew->whereRaw($sql);
              }
          })
          ->rawColumns(['actions'])
          ->make(true);
    }
}

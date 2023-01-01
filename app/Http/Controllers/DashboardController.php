<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\PrintLabel;
use App\Models\Product;
use App\Models\Store;
use App\Repositories\OrderRepository;
use App\Repositories\PaylaterRepository;
use App\Repositories\ProductStockRepositories;
use App\Services\GeneralService;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\DNS1D;

class DashboardController extends BaseAdminController
{
    public function __construct()
    {
        // parent::__construct();

        $this->data['currentIndex'] = route('admin.dashboard');
    }
    public function index()
    {
        $data = $this->data;
        $data['loanNew'] = Loan::with('employee')->where('loan_approval_status_id','=',50)->orderBy('id','desc')->limit(5)->get();
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
      $data['stringifyDetail'] = json_encode(collect($data['order']->detail)->toArray());
      $data['employee'] = Auth::user()->employee;
      $data['tax'] = ApplicationSetting::where('name', 'tax')->first();
      $data['paymentMethod'] = PaymentMethod::where('name', '!=', 'paylater')->get();
      return view('admin.pos.paylater-detail', $data);
    }

    public function printReceipt($orderCode, Request $request){
      // $data['cash'] = $request->cash;
      $data['order'] = Order::where('order_code', $orderCode)->first();
      $records = DB::table('transactions')->select(DB::raw('*'))
                  ->whereRaw('Date(transaction_date) = CURDATE()')->get();
      $data['countBill'] = count($records);

      $pdf = Pdf::loadView('admin.export.PDF.receipt-order', $data)
      ->setPaper(array( 0 , 0 , 138 , 138 ));
      $pdf->render();

      $page_count = $pdf->get_canvas()->get_page_number();
      unset($pdf);

      $pdf = Pdf::setOption(['isJavascriptEnabled' => true, 'defaultFont' => 'sans-serif', 'dpi' => 96])
                ->loadView('admin.export.PDF.receipt-order', $data)
                ->setPaper( array( 0 , 0 , 138 , 138 * $page_count + 20 ));
      
      return $pdf->stream("kartu_anggota.pdf");    
      
    }

    public function printStruk($orderCode, Request $request){
      $data['order'] = Order::where('order_code', $orderCode)->first();
      $records = DB::table('transactions')->select(DB::raw('*'))
                  ->whereRaw('Date(transaction_date) = CURDATE()')->get();
      $data['countBill'] = count($records);

      return view('admin.export.PDF.receipt-order', $data);
    }

    public function printLabel(){
      $data['titlePage'] = 'Halaman cetak harga';
      $data['categories'] = Category::get();
      return view('admin.pages.toko.product.print-label',$data);
    }
}

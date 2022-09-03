<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Models\Category;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Store;
use App\Repositories\PaylaterRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function home(){
      $data['categories'] = Category::get();
      $data['stores'] = Store::where('is_warehouse', false)->get();

      return view('nasabah.pages.home', $data);
    }

    public function product(Request $request){
      $data['categories'] = Category::get();
      $data['stores'] = Store::where('is_warehouse', false)->get();

      return view('nasabah.pages.product.index', $data);
    }

    public function productDetail($sku){
      $data['stores'] = Store::where('is_warehouse', false)->get();
      return view('nasabah.pages.product.show', $data);
    }

    public function checkout(){
      $data['paymentMethods'] = PaymentMethod::get();
      $data['tax'] = ApplicationSetting::where('name', 'tax')->first();
      $data['delivery_fee'] = ApplicationSetting::where('name', 'delivery_fee')->first();
      return view("nasabah.pages.checkout.index", $data);
    }

    public function profile(){
      $employee = Auth::user()->employee;
      return view("nasabah.pages.profile.index", compact('employee'));
    }

    public function paylaterHistory(){
      $data['employee'] = Auth::user()->employee;
      $data['paylater'] = PaylaterRepository::getDataPaylaterFromStaffId(Auth::user()->employee->id);
      return view("nasabah.pages.paylater.index", $data);
    }

    public function detailOrder($orderCode){
      $data['order'] = Order::where('order_code', $orderCode)->first();
      $data['employee'] = Auth::user()->employee;
      return view("nasabah.pages.paylater.detail", $data);
    }
}

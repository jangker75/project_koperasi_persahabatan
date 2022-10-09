<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Models\Category;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\PaylaterRepository;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PagesController extends Controller
{
    public function home(){
      $data['categories'] = Category::get();
      $data['stores'] = Store::where('is_warehouse', false)->get();

      $employeeId = auth()->user()->employee->id;
      $data['checkDataNasabah'] = (new EmployeeService())->checkDataProfile($employeeId);
      // dd($checkDataNasabah);
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

    public function changepassword()
    {
      return view('nasabah.pages.changepassword.index');
    }
    public function postChangepassword(Request $request)
    {
        $validated = $request->validate([
          'old_password' => 'required|alpha_dash',
          'password' => ['required_without:id', 'nullable','confirmed', Password::min(8)->letters()],
        ],
        [
          'password.min' => 'Minimal 8 Karakter',
          'password.confirmed' => 'Konfirmasi password tidak sama'
        ]);
        if(Hash::check($validated['old_password'],auth()->user()->password)){
          $a = User::where('id', auth()->user()->id)->update([
            'password' => Hash::make($validated['password']),
          ]);
          return redirect()->route('nasabah.profile')->with('success', __('general.notif_edit_data_success'));
        }else{
          return redirect()->back()->withErrors('password lama salah');
        }
        
    }



    public function checkout(){
      $data['paymentMethods'] = PaymentMethod::get();
      $data['tax'] = ApplicationSetting::where('name', 'tax')->first();
      $data['delivery_fee'] = ApplicationSetting::where('name', 'delivery_fee')->first();
      return view("nasabah.pages.checkout.index", $data);
    }

    public function profile(){
      $data['employee'] = Auth::user()->employee;
      $data['totalBill'] = Transaction::where('requester_employee_id', $data['employee']->id)
                              ->where('is_paid', 0)
                              ->where('status_transaction_id', 4)
                              ->sum('amount');
      $data['totalPaylater'] = Transaction::where('requester_employee_id', $data['employee']->id)
                              ->where('is_paid', 0)
                              ->where('is_paylater', 1)
                              ->sum('amount');
      return view("nasabah.pages.profile.index", $data);
    }

    public function paylaterHistory(){
      $data['employee'] = Auth::user()->employee;
      $data['paylater'] = PaylaterRepository::getDataPaylaterFromStaffId(Auth::user()->employee->id);
      // dd($data);
      return view("nasabah.pages.paylater.index", $data);
    }

    public function orderHistory(){
      $data['employee'] = Auth::user()->employee;
      $data['orders'] = (new OrderRepository())->getOrderFromEmployee($data['employee']->id);
      // $data['paylater'] = PaylaterRepository::getDataPaylaterFromStaffId(Auth::user()->employee->id);
      dd($data);
      return view("nasabah.pages.paylater.index", $data);
    }

    public function detailOrder($orderCode){
      $data['order'] = Order::where('order_code', $orderCode)->first();
      $data['employee'] = Auth::user()->employee;
      return view("nasabah.pages.paylater.detail", $data);
    }
}

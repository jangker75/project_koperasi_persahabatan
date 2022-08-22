<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Repositories\EmployeeRepository;
use App\Repositories\ProductStockRepositories;
use App\Services\OrderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request){
      try {
        $calculateService = new OrderService();
        $subTotalAll = $calculateService->calculateAllSubtotal($request->item);

        if($request->paymentMethodId == 1){
          $status = 6; 
        }else{
          $status = 4;
        }

        $order = Order::create([
          'subtotal' => $subTotalAll,
          'discount' => $request->discount,
          'total' => $subTotalAll - $request->discount,
          'status_id' => $status,
          'employee_onduty_id' => $request->employeeOndutyId
        ]);

        foreach ($request->item as $key => $product) {
          $productInfo = ProductStockRepositories::findProductBySku($product['sku']);
          $orderDetail = OrderDetail::create([
            'order_id' => $order->id,
            'product_name' => $productInfo[0]->title,
            'price' => $productInfo[0]->price,
            'qty' => $product['qty'],
            'subtotal' => $productInfo[0]->price*$product['qty']
          ]);
        }

        $inputTransaksi = [
          'order_id' => $order->id,
          'amount' => $order->total,
          'status_transaction_id' => $status,
        ];

        if($request->paymentMethodId == 2 || $request->paymentMethodId == 3){
          $inputTransaksi['payment_method_id'] = $request->paymentMethodId;
          $inputTransaksi['payment_code'] = $request->paymentCode; 
        }elseif ($request->paymentMethodId == 4) {
          $employee = EmployeeRepository::findEmployeeByNameOrNik($request->paylater);
          
          if (!$employee) {
              throw new ModelNotFoundException('Data nasabah tidak ditemukan');
          }
          $inputTransaksi['payment_method_id'] = $request->paymentMethodId;
          $inputTransaksi['is_paylater'] = true;
          $inputTransaksi['status_paylater_id'] = $status;
          $inputTransaksi['requester_employee_id'] = $employee[0]->id;
          $inputTransaksi['request_date'] = Carbon::now();
        }

        $transaction = Transaction::create($inputTransaksi);

        if($request->paymentMethodId == 1){
          // action menambah Saldo disini
        }

        if($request->paymentMethodId == 4){
          $response['message'] = "Paylater Berhasil dibuat untuk Nasabah Atas nama " . $transaction->requester->getFullNameAttribute() . ", Proses Paylater masuk untuk di setujui terlebih dahulu";
          $response['status'] = "success";
          $response['print'] = false;
        }else{
          $response['message'] = "Transaksi berhasil";
          $response['status'] = "success";
          $response['print'] = true;
        }

        $response['order'] = Order::with('status', 'detail')->find($order->id);

        return response()->json($response, 200);
      } catch (Exception $e) {
        $response['message'] = $e->getMessage();
        $response['status'] = "failed";
        return response()->json($response, 500);
      }
      
    }
}

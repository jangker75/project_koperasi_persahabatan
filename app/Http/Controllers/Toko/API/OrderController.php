<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use App\Models\Stock;
use App\Models\Transaction;
use App\Repositories\EmployeeRepository;
use App\Repositories\ProductStockRepositories;
use App\Services\HistoryStockService;
use App\Services\OrderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request){
      try {
        DB::beginTransaction();
        $calculateService = new OrderService();
        $subTotalAll = $calculateService->calculateAllSubtotal($request->item);

        $paymentMethod = PaymentMethod::find($request->paymentMethodId);
        if(str($paymentMethod->name)->slug == "paylater"){
          $status = 4;
        }else{
          $status = 6; 
        }

        // order
        $order = Order::create([
          'subtotal' => $subTotalAll,
          'discount' => $request->discount,
          'total' => $subTotalAll - $request->discount,
          'status_id' => $status,
          'employee_onduty_id' => $request->employeeOndutyId
        ]);

        // order detail
        foreach ($request->item as $key => $product) {
          $productInfo = ProductStockRepositories::findProductBySku($product['sku'], $request->storeId);
          if(!$productInfo || $productInfo[0]->stock < $product['qty']){
            throw new ModelNotFoundException('Data Produk tidak ditemukan atau stock yg tidak mencukupi');
          }
          $orderDetail = OrderDetail::create([
            'order_id' => $order->id,
            'product_name' => $productInfo[0]->title,
            'price' => $productInfo[0]->price,
            'qty' => $product['qty'],
            'subtotal' => $productInfo[0]->price*$product['qty']
          ]);

          // update stock
          $stockNow = Stock::select("qty")
                            ->where("store_id", $request->storeId)
                            ->where("product_id", $productInfo[0]->id)
                            ->first();
          $stock = Stock::where("store_id", $request->storeId)
                      ->where("product_id", $productInfo[0]->id)
                      ->update([
                        "qty" => $stockNow->qty - $orderDetail->qty
                      ]);

          // update history stock
          $history = new HistoryStockService();
          $history->update("order",[
            "productId" => $productInfo[0]->id,
            "qty" => $orderDetail->qty,
            "orderCode" => $order->order_code
          ]);
        }

        // table transaction
        $inputTransaksi = [
          'order_id' => $order->id,
          'amount' => $order->total,
          'status_transaction_id' => $status,
          'payment_method_id' => $request->paymentMethodId
        ];

        if(str($paymentMethod->name)->slug == "paylater"){
          $employee = EmployeeRepository::findEmployeeByNameOrNik($request->paylater);
          if (!$employee) {
              throw new ModelNotFoundException('Data nasabah tidak ditemukan');
          }

          $inputTransaksi['is_paylater'] = true;
          $inputTransaksi['status_paylater_id'] = $status;
          $inputTransaksi['requester_employee_id'] = $employee[0]->id;
          $inputTransaksi['request_date'] = Carbon::now();
        }elseif (str($paymentMethod->name)->slug !== "paylater" && str($paymentMethod->name)->slug !== "cash") {
          $inputTransaksi['payment_code'] = $request->paymentCode;
        }

        $transaction = Transaction::create($inputTransaksi);

        
        // saldo
        if($request->paymentMethodId == 1){
          // action menambah Saldo disini
        }

        if($request->paymentMethodId == 4){
          $response['message'] = "Paylater Berhasil dibuat untuk Nasabah Atas nama " . $transaction->requester->getFullNameAttribute() . ", Proses Paylater masuk untuk di setujui terlebih dahulu";
          $response['status'] = "success";
          $response['print'] = false;
        }else{
          $response['message'] = "Transaksi berhasil";
          $response['print'] = true;
          $response['status'] = "success";
        }

        $response['order'] = Order::with('status', 'detail')->find($order->id);

        DB::commit();
        return response()->json($response, 200);
      } catch (Exception $e) {
        DB::rollBack();
        $response['message'] = $e->getMessage();
        $response['status'] = "failed";
        return response()->json($response, 500);
      }
      
    }
}

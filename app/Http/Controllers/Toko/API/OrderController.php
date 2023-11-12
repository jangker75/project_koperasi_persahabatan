<?php

namespace App\Http\Controllers\Toko\API;

use App\Exports\BasicReportExport;
use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Models\Delivery;
use App\Models\Employee;
use App\Models\MasterDataStatus;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\Repositories\EmployeeRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaylaterRepository;
use App\Repositories\ProductStockRepositories;
use App\Services\CompanyService;
use App\Services\HistoryStockService;
use App\Services\OrderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function store(Request $request){
      try {
        DB::beginTransaction();
        // $calculateService = new OrderService();
        // $subTotalAll = $calculateService->calculateAllSubtotal($request->item);

        $paymentMethod = PaymentMethod::where('name', "like", "%".$request->paymentMethod."%")->first();
        if(!$paymentMethod){
          throw new ModelNotFoundException('Payment method tidak ditemukan');
        }
        $tax = ApplicationSetting::where('name', 'tax')->first();
        $status = 6;

        // // order
        // $order = Order::create([
        //   'subtotal' => $subTotalAll,
        //   'discount' => $request->discount,
        //   'total' => $subTotalAll - $request->discount + (int) $tax->content,
        //   'status_id' => $status,
        //   'employee_onduty_id' => $request->employeeOndutyId,
        //   'store_id' => $request->storeId
        // ]);
        $order = Order::create([
          'status_id' => $status,
          'employee_onduty_id' => $request->employeeOndutyId,
          'store_id' => $request->storeId
        ]);

        $subtotalAll = 0;

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
            'discount' => $product['discount'],
            'subtotal' => (int) ($productInfo[0]->price*$product['qty']) - (int) $product['discount']
          ]);

          $subtotalAll += $orderDetail->subtotal;

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

        $order['subtotal'] = $subtotalAll;
        $order['discount'] = $request->discount;
        $order['total'] = $subtotalAll - $request->discount + (int) $tax->content;
        $order->save();

        // table transaction
        $inputTransaksi = [
          'order_id' => $order->id,
          'amount' => $order->total,
          'status_transaction_id' => $status,
          'payment_method_id' => $paymentMethod->id,
          'is_paid' => true
        ];

        if(str($paymentMethod->name)->slug == "paylater"){
          $employee = EmployeeRepository::findEmployeeByNameOrNik($request->paylater);

          if (!$employee) {
              throw new ModelNotFoundException('Data nasabah tidak ditemukan');
          }

          $statusPaylate = MasterDataStatus::where('name', 'approved')->first();

          $inputTransaksi['is_paid'] = false;
          $inputTransaksi['approval_employee_id'] = $request->employeeOndutyId;
          $inputTransaksi['is_paylater'] = true;
          $inputTransaksi['status_paylater_id'] = $statusPaylate->id;
          $inputTransaksi['requester_employee_id'] = $employee[0]->id;
          $inputTransaksi['approval_employee_id'] = $request->employeeOndutyId;
          $inputTransaksi['is_paid'] = false;
          $inputTransaksi['approve_date'] = Carbon::now();
          $inputTransaksi['request_date'] = Carbon::now();
        }elseif(str($paymentMethod->name)->slug == "cash"){
          if($request->employeeRequester !== null){
            $requesterEmployee = EmployeeRepository::findEmployeeByNameOrNik($request->employeeRequester);
            $inputTransaksi['requester_employee_id'] = $requesterEmployee[0]->id;
          }
          $inputTransaksi['cash'] = (int) $request->cash;
          $inputTransaksi['change'] = (int) $request->cash - $order->total;
        }elseif ($paymentMethod->name !== "paylater" && str($paymentMethod->name)->slug !== "cash") {
          $inputTransaksi['cash'] = $order->total;
          $inputTransaksi['change'] = 0;
          $inputTransaksi['payment_code'] = $request->paymentCode;
        }

        $transaction = Transaction::create($inputTransaksi);

        // saldo
        if($paymentMethod->name !== "paylater"){
          (new CompanyService())->addCreditBalance($transaction->amount, 'store_balance', $paymentMethod->name);
        }

        if($paymentMethod->name == 'paylater'){
          $response['message'] = "Paylater Berhasil dibuat untuk Nasabah Atas nama " . $transaction->requester->getFullNameAttribute() . ", Proses Paylater masuk untuk di setujui terlebih dahulu";
          $response['print'] = false;
        }else{
          $response['message'] = "Transaksi berhasil";
          $response['print'] = true;
        }
        $response['status'] = "success";

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

    public function orderNasabah(Request $request){
      $calculateService = new OrderService();
      $subTotalAll = $calculateService->calculateAllSubtotal($request->item);
      $tax = ApplicationSetting::where('name', 'tax')->first();
      
      try {
        DB::beginTransaction();

        if($request->paylater){
          $check = PaylaterRepository::checkPaylaterFromEmployeeId($request->requesterId);
    
          if($check){
            throw new ModelNotFoundException('Nasabah sedang mengajukan paylater, harap selesaikan terlebih dahulu');
          }
        }

        $status = 4;

        $inputOrder = [
          'subtotal' => $subTotalAll,
          'total' => $subTotalAll - 0 + (int) $tax->content,
          'status_id' => $status,
          'store_id' => $request->storeId
        ];

        if($request->delivery){
          $inputOrder['note'] = $request->note;
          $deliveryFee = ApplicationSetting::where('name', 'delivery_fee')->first();
          $inputOrder['total'] = $inputOrder['total'] + (int) $deliveryFee->content;
        }

        // order
        $order = Order::create($inputOrder);

        // order detail
        foreach ($request->item as $key => $product) {
          $productInfo = ProductStockRepositories::findProductBySku($product['sku'], $request->storeId);
          if(!$productInfo){
            throw new ModelNotFoundException('Data Produk tidak ditemukan ');
          }
          if($productInfo[0]->stock < $product['qty']){
            throw new ModelNotFoundException('Stock yg tidak mencukupi');
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

        $employee = Employee::find($request->requesterId);
        if (!$employee) {
            throw new ModelNotFoundException('Data nasabah tidak ditemukan');
        }
        $inputTransaksi = [
            'order_id' => $order->id,
            'amount' => $order->total,
            'status_transaction_id' => $status,
            'payment_method_id' => 1,
            'is_paid' => false,
            'requester_employee_id' => $employee->id
          ];

        if($request->paylater){
          // table transaction
          $paymentMethod = PaymentMethod::where('name', 'paylater')->first();

          $employee = Employee::find($request->requesterId);
          if (!$employee) {
              throw new ModelNotFoundException('Data nasabah tidak ditemukan');
          }

          $inputTransaksi['payment_method_id'] = $paymentMethod->id;
          $inputTransaksi['is_paylater'] = true;
          $inputTransaksi['status_paylater_id'] =  $status;
          $inputTransaksi['request_date'] = Carbon::now();
        }

        if($request->delivery){
          $inputTransaksi['is_delivery'] = true;
          $inputTransaksi['delivery_fee'] = (int) $deliveryFee->content;

          Delivery::create([
            'order_id' => $order->id,
            'other_fee' => (int) $deliveryFee->content
          ]);
        }

        Transaction::create($inputTransaksi);

        $response['message'] = "berikan Kode Order ini Admin\nKODE : ". $order->order_code;
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

    public function rejectOrder(Request $request){
      try {
        DB::beginTransaction();
        
        $order = Order::where('order_code', $request->orderCode)->first();
        $status = MasterDataStatus::where('name', 'failed')->first();
        $statusPaylate = MasterDataStatus::where('name', 'reject')->first();

        $order->status_id = $status->id;
        $order->employee_onduty_id = $request->employeeOndutyId;
        $order->save();

        foreach ($order->detail as $key => $detail) {
          $product = Product::where('name', $detail->product_name)->first();
          // update stocks
          $stockNow = Stock::where("store_id", $order->store_id)
                            ->where("product_id", $product->id)
                            ->first();
          $stock = Stock::where("store_id", $order->store_id)
                      ->where("product_id", $product->id)
                      ->update([
                        "qty" => $stockNow->qty + $detail->qty
                      ]);

          // update history stocks
          $history = new HistoryStockService();
          $history->update("rejection",[
            "productId" => $product->id,
            "qty" => $detail->qty,
            "orderCode" => $order->order_code
          ]);
        }

        $transaction = $order->transaction;
        $transaction->status_transaction_id = $status->id;
        $transaction->status_paylater_id = $statusPaylate->id;
        $transaction->approval_employee_id = $request->employeeOndutyId;
        $transaction->approve_date = Carbon::now();

        $transaction->save();

        DB::commit();
        $response['message'] = "Success Tolak Transaksi ini";
        $response['status'] = "success";
        return response()->json($response, 200);
      } catch (Exception $e) {
        DB::rollBack();
        $response['message'] = $e->getMessage();
        $response['status'] = "failed";
        return response()->json($response, 500);
      }
    }

    public function checkoutOrder(Request $request){
      try {
        DB::beginTransaction();
        $order = Order::where('order_code', $request->orderCode)->first();
        $status = MasterDataStatus::where('name', 'success')->first();
        $statusPaylater = MasterDataStatus::where('name', 'approved')->first();
        $tax = ApplicationSetting::where('name', 'tax')->first();
        $allSubtotal = 0;

        foreach ($request->item as $key => $item) {
          $detail = OrderDetail::find($item['id']);
          $detail->discount = $item['discount'];
          $detail->subtotal = $detail->subtotal - (int) $item['discount'];
          $detail->save();
          $allSubtotal += (int) $detail->subtotal;
        }

        // status order
        $order->status_id = $status->id;
        $order->subtotal = $allSubtotal;
        $order->discount = (int) $request->discount;
        $order->total = $allSubtotal - ((int) $request->discount + (int) $tax->content);
        $order->employee_onduty_id = $request->employeeOndutyId;
        $order->save();


        // status order
        $transaction = $order->transaction;
        $transaction->status_transaction_id = $status->id;
        $transaction->approval_employee_id = $request->employeeOndutyId;
        $transaction->approve_date = Carbon::now();

        if($transaction->is_paylater == 0){
          if(!$request->paymentMethod){
            throw new ModelNotFoundException('User belum menginput metode Pembayaran');
          }
          if($request->paymentMethod !== "cash"){
            $paymentMethod = PaymentMethod::where('name', $request->paymentMethod)->first();
  
            if($request->paymentCode == "" || !$request->paymentCode){
              throw new ModelNotFoundException('User belum menginput Kode Pembayaran');
            }
            $transaction->payment_method_id = $paymentMethod->id;
            $transaction->payment_code = $request->paymentCode;

            $transaction->cash = $order->total;
            $transaction->change = 0;
          }else{
            $transaction->cash = $request->cash;
            $transaction->change = $request->cash - $order->total;
          }
          (new CompanyService())->addCreditBalance($transaction->amount, 'store_balance', $request->paymentMethod);
        }

        if($transaction->is_paylater == 1){
          $transaction->status_paylater_id = $statusPaylater->id;
        }

        if($transaction->is_paylater == 0 || $transaction->is_paylater == null){
          $transaction->is_paid = true;
        }
        $transaction->save();

        DB::commit();
        $response['message'] = "Success Setujui Transaksi ini";
        $response['status'] = "success";
        return response()->json($response, 200);
      } catch (Exception $e) {
        DB::rollBack();
        $response['message'] = $e->getMessage();
        $response['status'] = "failed";
        return response()->json($response, 500);
      }
    }

    public function getDataOrder(Request $request){
      $data = (new OrderRepository())->getAllOrders($request->page, $request->params);
      $pagination = (new OrderRepository())->paginateOrder($request->page, $request->params);
      $total = (new OrderRepository())->getAllOrders($request->page, $request->params, 1)[0];

      $result = [
        'data' => $data,
        'pagination' => $pagination,
        'total' => $total
      ];
      return response()->json($result, 200);
    }

    public function reportToday($storeId){
      $calculate = (new OrderRepository)->calculateReportCloseCashier($storeId);
      $itemCalculate = (new OrderRepository)->itemReportCloseCashier($storeId);
      
      // $totalOrder = Transaction::select(DB::raw('COUNT(transactions.id) as total'))
      //                           ->whereDate('transaction_date', '=', date('Y-m-d'))->get();
      return response()->json([
        'calculate' => $calculate,
        'items' => $itemCalculate
      ],200);
    }
}

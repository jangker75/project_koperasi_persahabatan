<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Models\DetailOrderSupplier;
use App\Models\Employee;
use App\Models\MasterDataStatus;
use App\Models\OrderSupplier;
use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use App\Repositories\OrderSupplierRepository;
use App\Services\CompanyService;
use App\Services\HistoryStockService;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderSupplierController extends Controller
{
    public function store(Request $request){
      try {
          DB::beginTransaction();
          $order = OrderSupplier::create([
            'supplier_id' => $request->supplierId, 
            'to_store_id' => $request->destinationStore,
            'req_empl_id' => $request->employeeId,
            'order_date' => Carbon::now(),
            'note' => $request->note
          ]);


          foreach ($request->product as $kPro => $item) {

            $product = Product::find($item['productId']);
            if(!$product){
              throw new ModelNotFoundException('Data Produk tidak ditemukan');
            }
            
            DetailOrderSupplier::create([
              'order_supplier_id' => $order->id,
              'product_id' => $product->id,
              'request_qty' => $item['quantity'],
              'request_unit' => $item['unit'],
            ]);
          }

          DB::commit();
          $response['message'] = "Tiket berhasil dibuat";
          return response()->json($response, 200);
        } catch (QueryException $e) {
          DB::rollBack();
          $response['message'] = "Tiket gagal dibuat";
          return response()->json($response, 500);
        }
    }


    public function getDetailById($id){
      $data['detailItem'] = (new OrderSupplierRepository())->getItemFromId($id);
      $data['message'] = "Tiket berhasil dibuat";
      return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
      try {
          DB::beginTransaction();
          $order = OrderSupplier::find($id);
          $order->update([
            'supplier_id' => $request->supplierId, 
            'to_store_id' => $request->destinationStore,
            'req_empl_id' => $request->employeeId,
            'order_date' => Carbon::now(),
            'note' => $request->note
          ]);
          $order = OrderSupplier::find($id);

          $ids = [];

          foreach ($request->product as $kPro => $requestItem) {


            $product = Product::find($requestItem['productId']);
            if(!$product){
              throw new ModelNotFoundException('Data Produk tidak ditemukan');
            }

            foreach ($order->detailItem as $key => $item) {
              if($item->product_id == $product->id){
                $detail = DetailOrderSupplier::find($item->id)->update([
                  'request_qty' => $requestItem['quantity']
                ]);
                array_push($ids, $item->id);
              }else{
                $check = DetailOrderSupplier::where('order_supplier_id', $order->id)
                                          ->where('product_id', $product->id)->first();
                if(!$check){
                  $detail = DetailOrderSupplier::create([
                    'order_supplier_id' => $order->id,
                    'product_id' => $product->id,
                    'request_qty' => $requestItem['quantity'],
                    'request_unit' => $requestItem['unit'],
                  ]);
                  array_push($ids, $detail->id);
                }
              }
            }
          }
          DetailOrderSupplier::whereNotIn('id', $ids)->delete();
          DB::commit();
          $response['message'] = "Tiket berhasil diterima";
          return response()->json($response, 200);
        } catch (QueryException $e) {
          DB::rollBack();
          $response['message'] = "Tiket gagal diterima";
          return response()->json($response, 500);
        }
    }

    public function receiveOrder(Request $request){
      try {
        DB::beginTransaction();
        $status = MasterDataStatus::where('name', 'Receive')->first();
        $orderSupplier = OrderSupplier::find($request->orderSupplierId);
        $orderSupplier->received_date = Carbon::now();
        $orderSupplier->save();

        $subtotal = [];
        foreach ($request->data as $key => $item) {
          $detail = DetailOrderSupplier::find($item['id']);
          $detail->request_unit = $item['receiveUnit'];
          $detail->quantity_per_unit = $item['quantityPerUnit'];
          $detail->price_per_unit = $item['newCost'];
          $detail->receive_unit = $item['receiveUnit'];
          $detail->receive_qty = $item['receiveQty'];
          $detail->subtotal = $item['receiveQty']*$item['newCost'];
          $detail->all_quantity_in_units = $item['quantityPerUnit']*$detail->request_qty;
          $detail->save();

          array_push($subtotal, $detail->subtotal);

          // update stock
          $stock = Stock::where("store_id", $orderSupplier->to_store_id)
              ->where("product_id", $detail->product_id)->first();
          $stock->qty = $stock->qty + $detail->all_quantity_in_units;
          $stock->save();
          $employeeOnduty = Employee::findOrFail($orderSupplier->req_empl_id)->toArray(); 
          (new HistoryStockService())->update("supply", [
            "orderSupplyCode" => $orderSupplier->order_supplier_code,
            "productId" => $detail->product_id,
            'qty' => $detail->all_quantity_in_units
          ], $employeeOnduty);

          $oldPrice = Price::where('product_id', $item['productId'])
                          ->where('is_active', true)->first();
          Price::where('product_id', $item['productId'])
                ->update(['is_active' => false]);

          $profit = (int) ($item['newRevenue'] - $item['newCost']);
          $margin = ($profit*100)/$item['newCost'];
          // dd($item['isSamePrice'], $margin, $profit);
          $appSetting = ApplicationSetting::where('name', 'minimum_margin_price')->first();
            
          if($item['isSamePrice'] == false || $item['isSamePrice'] == 0){
            $profit = (int) ($item['newRevenue'] - $item['newCost']);
            $margin = ($profit*100)/$item['newCost'];

            if($margin < (int) $appSetting->content){
              throw new ModelNotFoundException('Margin Harga tidak boleh kurang dari ' . $appSetting->content."%");
            }

            Price::create([
              'product_id' => $detail->product_id,
              'cost' => $item['newCost'],
              'revenue' => $item['newRevenue'],
              'margin' => $margin,
              'profit' => $profit,
              'is_active' => true
            ]);
          }else if($item['isSamePrice'] == true || $item['isSamePrice'] == 1){
            $profit = (int) ($oldPrice->revenue - $item['newCost']);
            $margin = ($profit*100)/$item['newCost'];

            if($margin < (int) $appSetting->content){
              throw new ModelNotFoundException('Margin Harga tidak boleh kurang dari ' . $appSetting->content."%");
            }

            Price::create([
              'product_id' => $detail->product_id,
              'cost' => $item['newCost'],
              'revenue' => $oldPrice->revenue,
              'margin' => $margin,
              'profit' => $profit,
              'is_active' => true
            ]);
          }else{
            $oldPrice->is_active == true;
            $oldPrice->save();
          }
        }
        
        // (new CompanyService())->addDebitBalance($orderSupplier->total, 'store_balance', 'order-supplier kode : '. $orderSupplier->order_supplier_code);
        
        if($request->isPaid == true || $request->isPaid == 1){
          $orderSupplier->is_paid == true;
        }else{
          $orderSupplier->is_paid == false;
        }
        $orderSupplier->total = array_sum($subtotal);
        $orderSupplier->status_id = $status->id;
        $orderSupplier->save();

        
        DB::commit();
        $response['message'] = "Tiket berhasil diedit";
        return response()->json($response, 200);
      } catch (QueryException $e) {
        DB::rollBack();
        $response['message'] = "Tiket gagal dibuat";
        return response()->json($response, 500);
      }
      
    }

    public function changeToPaid($id){
      try {
        $orderSupplier = OrderSupplier::find($id);
        if(!$orderSupplier){
          throw new ModelNotFoundException('Order Supplier not found');
        }
        $statusReceive = MasterDataStatus::where('name', 'Receive')->first();
        if($orderSupplier->status_id == $statusReceive->id){
          throw new ModelNotFoundException('Data belum berstatus "receive"');
        }
        if($orderSupplier->is_paid == 1){
          throw new ModelNotFoundException('order ini sudah dibayar');
        }

        $orderSupplier->is_paid = true;
        $orderSupplier->save();
      } catch (QueryException $e) {
          DB::rollBack();
          $response['message'] = "Tiket gagal dibayar";
          return response()->json($response, 500);
        }
    }
}

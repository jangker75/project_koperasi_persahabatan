<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\DetailTransferStock;
use App\Models\HistoryTransferStock;
use App\Models\Product;
use App\Models\Stock;
use App\Models\TransferStock;
use App\Repositories\ProductStockRepositories;
use App\Repositories\TransferstockRepository;
use App\Services\HistoryStockService;
use App\Services\HistoryTransferStockService;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferStockController extends Controller
{
    public function store(Request $request){
      try {
          DB::beginTransaction();
          $transfer = TransferStock::create([
            'from_store_id' => $request->originStore, 
            'to_store_id' => $request->destinationStore,
            'req_empl_id' => $request->employeeId,
            'req_date' => Carbon::now()
          ]);
          // dd($request->product[0]);
          foreach ($request->product as $kPro => $item) {

            $product = Product::find($item['productId']);
            if(!$product){
              throw new ModelNotFoundException('Data Produk tidak ditemukan');
            }
            $productInfo = ProductStockRepositories::findProductBySku($product->sku, $request->storeId);
            if(!$productInfo || $productInfo[0]->stock < $product['qty']){
              throw new ModelNotFoundException('stock yg tidak mencukupi');
            }
            
            DetailTransferStock::create([
              'transfer_stock_id' => $transfer->id,
              'product_id' => $product->id,
              'request_qty' => $item['quantity']
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

    public function update(Request $request, $id)
    {
      
      try {
          DB::beginTransaction();
          $transfer = TransferStock::find($id);
          $transfer->update([
            'from_store_id' => $request->originStore, 
            'to_store_id' => $request->destinationStore,
            'req_empl_id' => $request->employeeId,
            'req_date' => Carbon::now()
          ]);
          $transfer = TransferStock::find($id);

          $ids = [];

          foreach ($request->product as $kPro => $requestItem) {


            $product = Product::find($requestItem['productId']);
            if(!$product){
              throw new ModelNotFoundException('Data Produk tidak ditemukan');
            }
            $productInfo = ProductStockRepositories::findProductBySku($product->sku, $request->storeId);
            if(!$productInfo || $productInfo[0]->stock < $product['qty']){
              throw new ModelNotFoundException('stock yg tidak mencukupi');
            }

            foreach ($transfer->detailItem as $key => $item) {
              if($item->product_id == $product->id){
                $detail = DetailTransferStock::find($item->id)->update([
                  'request_qty' => $requestItem['quantity']
                ]);
                array_push($ids, $item->id);
              }else{
                $check = DetailTransferStock::where('transfer_stock_id', $transfer->id)
                                          ->where('product_id', $product->id)->first();
                if(!$check){
                  $detail = DetailTransferStock::create([
                    'transfer_stock_id' => $transfer->id,
                    'product_id' => $product->id,
                    'request_qty' => $requestItem['quantity']
                  ]);
                  array_push($ids, $detail->id);
                }
              }
            }
          }
          DetailTransferStock::whereNotIn('id', $ids)->delete();
          DB::commit();
          $response['message'] = "Tiket berhasil diedit";
          return response()->json($response, 200);
        } catch (QueryException $e) {
          DB::rollBack();
          $response['message'] = "Tiket gagal dibuat";
          return response()->json($response, 500);
        }
    }

    public function getDetailById($id){
      $data['detailItem'] = TransferstockRepository::getItemFromId($id);
      $data['message'] = "Tiket berhasil dibuat";
      return response()->json($data, 200);
    }

    public function confirmStock(Request $request){
      $transferStock = TransferStock::find($request->transferStockId);
      $transferStock->send_empl_id = $request->employeeId;
      $transferStock->save();

      foreach ($request->data as $key => $data) {
        $item = DetailTransferStock::find($data['id']);
        $item->available_qty = $data['value'];
        $item->save();
      }

      HistoryTransferStockService::update("Processing", $transferStock->id);
      
      $response['message'] = "Tiket berhasil dikonfirmasi";
      return response()->json($response, 200);
    }

    public function receiveStock(Request $request){
      $transferStock = TransferStock::find($request->transferStockId);
      foreach ($request->data as $key => $data) {
        $item = DetailTransferStock::find($data['id']);
        $item->receive_qty = $data['value'];
        $item->save();

        $stockOrigin = Stock::where('product_id', $item->product_id)
                          ->where('store_id', $transferStock->from_store_id)->first();
        $destinationOrigin = Stock::where('product_id', $item->product_id)
                          ->where('store_id', $transferStock->to_store_id)->first();
        
        $stockOrigin->qty = $stockOrigin->qty - $item->receive_qty;
        $stockOrigin->save();
        $destinationOrigin->qty = $stockOrigin->qty + $item->receive_qty;
        $destinationOrigin->save();

        (new HistoryStockService)->update("transfer", [
          "from" => $transferStock->fromStore->name,
          "destination" => $transferStock->toStore->name,
          "qty" => $item->receive_qty,
          "productId" => $item->product_id
        ]);

      }


      HistoryTransferStockService::update("Receive", $request->transferStockId);
      
      $response['message'] = "Tiket berhasil diterima";
      return response()->json($response, 200);
    }
}

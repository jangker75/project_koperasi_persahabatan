<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use App\Repositories\ProductStockRepositories;
use App\Services\HistoryStockService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpnameController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
          DB::beginTransaction();
          $inputOpname = [
            'store_id' => $request->storeId,
            'employee_id' => $request->employeeId
          ];

          if(isset($request->note)){
            $inputOpname['note'] = $request->note;
          }

          $opname = Opname::create($inputOpname);
          
          $totalPrice = 0;

          foreach ($request->item as $key => $item) {
            $product = Product::find($item['productId']);

            if(!$product){
                throw new ModelNotFoundException('Product Tidak ditemukan');
            }

            $price = Price::where('product_id', $product->id)
                          ->where('is_active', 1)
                          ->first();

            $inputDetail = [
              'opname_id' => $opname->id,
              'product_id' => $item['productId'],
              'quantity' => $item['quantity'],
              'description' => $item['description'],
              'type' => $item['type'],
              'price' => $price->cost,
              'amount' => $price->cost * $item['quantity']
            ];

            if($item['isExpired']){
              $inputDetail['is_expired'] = true;
              $inputDetail['price'] = 0;
              $inputDetail['amount'] = 0;
            }else{
              $totalPrice += $price->cost * $item['quantity'];
            }

            $detail = OpnameDetail::create($inputDetail);
            
            $stockNow = (new ProductStockRepositories())->findProductOnStockByKeyword($product->slug, null, $request->storeId)[0];

            if($item['type'] == 'minus'){
              $sisa = (int) $stockNow->qty - $item['quantity'];

              (new HistoryStockService())->update("opname", [
                'opnameCode' => $opname->opname_code,
                'type' => 'minus',
                'productId' => $item['productId'],
                'qty' => $item['quantity']
              ]);
            }else{
              $sisa = (int) $stockNow->qty + $item['quantity'];

              (new HistoryStockService())->update("opname", [
                'opnameCode' => $opname->opname_code,
                'type' => 'plus',
                'productId' => $item['productId'],
                'qty' => $item['quantity']
              ]);
            }

            Stock::where('store_id', $request->storeId)
                  ->where('product_id', $item['productId'])
                  ->update(['qty' => $sisa]);
          }

          $opname->total_price = $totalPrice;
          $opname->save();

          DB::commit();
          $response['message'] = 'Success Create New Opname';
          $response['status'] = "success";
          return response()->json($response, 200);
        } catch (Exception $e) {
          DB::rollBack();
          $response['message'] = $e->getMessage();
          $response['status'] = "failed";
          return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
          DB::beginTransaction();

          $opname = Opname::find($request->opnameId);
          if(!$opname){
            throw new ModelNotFoundException('Opname tidak ditemukan');
          }

          OpnameDetail::where('opname_id', $request->opnameId)->delete();
          
          DB::commit();
          $response['message'] = 'Success Delete Opname';
          $response['status'] = "success";
          return response()->json($response, 200);
        } catch (Exception $e) {
          DB::rollBack();
          $response['message'] = $e->getMessage();
          $response['status'] = "failed";
          return response()->json($response, 500);
        }
    }
}

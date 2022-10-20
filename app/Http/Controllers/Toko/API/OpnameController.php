<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use App\Repositories\OpnameRepository;
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

            if($item['isExpired'] == true || $item['isExpired'] == 1){
              $inputDetail['is_expired'] = true;
            }

            $totalPrice += $price->cost * $item['quantity'];

            $detail = OpnameDetail::create($inputDetail);
            
            $stockNow = (new ProductStockRepositories())->findProductOnStockByKeyword($product->slug, null, $request->storeId)[0];

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

    public function update(Request $request, $id){
      try {
        DB::beginTransaction();
        $opname = Opname::findOrFail($id);

        if($opname->is_commit == true){
          throw new ModelNotFoundException('Opname sudah di commit');
        }

        $inputOpname = [
          'store_id' => $request->storeId,
          'employee_id' => $request->employeeId
        ];

        if(isset($request->note)){
          $inputOpname['note'] = $request->note;
        }

        $opname->save();

        $totalPrice = 0;

        $opnameDetailExist = collect($opname->detail)->toArray();

        $listProductExist = array_column($opnameDetailExist, 'product_id');
        $listProductId = array_column($request->item, 'productId');

        $diffId = array_diff($listProductExist, $listProductId);

        if(count($diffId) > 0){
          OpnameDetail::whereIn('product_id', $diffId)
                        ->where('opname_id', $opname->id)->delete();
        }

        foreach ($request->item as $key => $item) {
          $detail = OpnameDetail::where('id', $item['id'])->first();
          
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

          if($item['isExpired'] == true || $item['isExpired'] == 1){
            $inputDetail['is_expired'] = true;
          }
          $totalPrice += $price->cost * $item['quantity'];

          if($detail){
            $detail->update($inputDetail);
          }else{
            OpnameDetail::create($inputDetail);
          }
        }

        DB::commit();
        $response['message'] = 'Success Update Opname';
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
    public function destroy(Request $request, $id)
    {
        try {
          DB::beginTransaction();

          $opname = Opname::find($id);
          if(!$opname){
            throw new ModelNotFoundException('Opname tidak ditemukan');
          }
          if($opname->is_commit == true){
            throw new ModelNotFoundException('Opname sudah di commit');
          }

          OpnameDetail::where('opname_id', $id)->delete();
          $opname->delete();
          
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

    public function show($id){
      $opname = Opname::findOrFail($id);

      $response['opname'] = $opname;
      $response['detail'] = (new OpnameRepository())->findDetailOpnameByOpnameId($id);
      $response['message'] = 'Success get Opname';
      $response['status'] = "success";
      return response()->json($response, 200);
    }

    public function commit($id){
      try {
          DB::beginTransaction();

          $opname = Opname::find($id);
          if(!$opname){
            throw new ModelNotFoundException('Opname tidak ditemukan');
          }
          if($opname->is_commit == true){
            throw new ModelNotFoundException('Opname sudah di commit');
          }

          foreach ($opname->detail as $key => $detail) {
            (new HistoryStockService())->update("opname", [
              'type' => $detail->type,
              'opnameCode' => $opname->opname_code,
              'productId' => $detail->product_id,
              'qty' => $detail->quantity
            ]);
          }

          $opname->is_commit = true;
          $opname->save();
          
          DB::commit();
          $response['message'] = 'Success Commit Opname';
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

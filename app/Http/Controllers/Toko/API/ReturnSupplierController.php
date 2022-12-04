<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\MasterDataStatus;
use App\Models\Price;
use App\Models\ReturnSupplier;
use App\Models\ReturnSupplierDetail;
use App\Models\Stock;
use App\Services\CodeService;
use App\Services\HistoryStockService;
use Illuminate\Http\Request;

class ReturnSupplierController extends Controller
{
    public function store(Request $request){
      $input = $request->all();
      $input['return_supplier_code'] = (new CodeService)->generateCodeFromDate("RTN/SUP/00/");
      $returnSupplier = ReturnSupplier::create($input);

      foreach ($input['items'] as $key => $item) {
        ReturnSupplierDetail::create([
          'return_supplier_id' => $returnSupplier->id,
          'product_id' => $item['id'],
          'product_name' => $item['title'],
          'product_sku' => $item['sku'],
          'qty' => $item['qty'],
          'description' => $item['description']
        ]);

        $stock = Stock::where('store_id', $input['store_id'])
                      ->where('product_id', $item['id'])->first();
        $stock->qty = $stock->qty - (int) $item['qty'];
        $stock->save();

        (new HistoryStockService)->update("return", [
          'returnCode' => $returnSupplier->return_supplier_code,
          'productId' => $item['id'],
          'qty' => $stock->qty
        ]);
      }

      return response()->json([
        'message' => 'success input data',
      ], 200);
    }
}

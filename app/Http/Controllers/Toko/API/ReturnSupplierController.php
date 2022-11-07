<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\MasterDataStatus;
use App\Models\Price;
use App\Models\ReturnSupplier;
use App\Models\ReturnSupplierDetail;
use Illuminate\Http\Request;

class ReturnSupplierController extends Controller
{
    public function store(Request $request){
      $input = $request->all();
      $status = MasterDataStatus::where('name', 'waiting')->first();
      $input['status_return_id'] = $status->id;
      $input['status_ticket_id'] = $status->id;
      // dd($input);
      $returnSupplier = ReturnSupplier::create($input);

      foreach ($input['items'] as $key => $item) {
        $price = Price::where('product_id', $item['id'])->latest()->first();

        ReturnSupplierDetail::create([
          'return_supplier_id' => $returnSupplier->id,
          'product_id' => $item['id'],
          'qty' => $item['qty'],
          'price' => $price->cost,
          'amount' => $price->cost*$item['qty'],
          'description' => $item['description']
        ]);
      }

      return response()->json([
        'message' => 'success input data',
      ], 200);
    }
}

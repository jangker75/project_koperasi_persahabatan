<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Repositories\ProductStockRepositories;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function rekapitulasiStock(Request $request){
      try {
        $data = (new ProductStockRepositories)->listingRekapitulasiData(false, $request);
        return response()->json($data, 200);
      } catch (\Throwable $th) {
        return response()->json([
          'error' => $th
        ], 500);
      }
    }
}

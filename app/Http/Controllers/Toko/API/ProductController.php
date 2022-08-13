<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Repositories\ProductStockRepositories;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function searchProduct(Request $request){
      try {
        $data = ProductStockRepositories::findProductOnStockByKeyword($request->keyword, $request->notInListProduct, $request->originStore);

        $data['message'] = "Success Search Product";
        $data['product'] = $data;

        return response()->json($data, 200);
      } catch (QueryException $e) {
        $data['message'] = "Failed Search Product";
        $data['error'] = $e;

        return response()->json($data, 500);
      }
      
      

    }
}

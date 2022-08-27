<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
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

    public function searchProductBySKU(Request $request){
      try {
        if(!$request->storeId){
          $request->storeId = null;
        }

        $product = ProductStockRepositories::findProductBySku($request->sku, $request->storeId);

        if(!$product){
          $data['message'] = "Failed Search Product";
          return response()->json($data, 500);
        }
        $data['message'] = "Success Search Product";
        $data['product'] = $product[0];

        return response()->json($data, 200);
      } catch (QueryException $e) {
        $data['message'] = "Failed Search Product";
        $data['error'] = $e;

        return response()->json($data, 500);
      }
    }

    public function getProductOnStockPaginate(Request $request){
      try {
        if($request->categoryId){
          $data['products'] = ProductStockRepositories::getDataonStockbyStore($request->storeId, $request->page, $request->categoryId);
        }else{
          $data['products'] = ProductStockRepositories::getDataonStockbyStore($request->storeId, $request->page);
        }
        $data['message'] = "success get data";
      } catch (\Throwable $th) {
        $data['message'] = "failed get data";
        $data['error'] = $th;
      }

      return response()->json($data,200);
      
    }
}

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
        $product = ProductStockRepositories::findProductOnStockByKeyword($request->keyword, $request->notInListProduct, $request->originStore);
        
        if(!$product){
          $data['message'] = "Failed Search Product";
          return response()->json($data, 500);
        }

        $data['message'] = "Success Search Product";
        $data['product'] = $product;

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

    public function searchProductById(Request $request){
      try {
        if(!$request->storeId){
          $request->storeId = null;
        }

        $product = ProductStockRepositories::findProductById($request->id, $request->storeId);

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

    public function searchProductStockZero(){
      $keyword = str(request()->get('keyword'))->slug();

      $data = Product::query()
                ->select(
                  'products.id as productId',
                  'products.name as productName',
                  'products.sku as productSKU',
                  'products.cover as productCover',
                  DB::raw('(SELECT prices.revenue FROM prices WHERE prices.product_id = products.id ORDER BY prices.id DESC LIMIT 1) AS price'),
                  DB::raw('SUM(stocks.qty) as qty')
                )
                ->leftJoin('stocks','products.id', '=', 'stocks.product_id')
                ->where('products.slug','LIKE', '%' . $keyword . '%')
                ->orWhere('products.sku', 'LIKE', '%' . $keyword . '%')
                ->groupBy('products.id')
                ->get();
      
      return response()->json([
        'product' => $data
      ], 200);
    }
}

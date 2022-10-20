<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
      try {
          $data['brand'] = Brand::latest()->get();
          $data['table']['head'] = ['name', 'brand_code'];
          $data['table']['body'] = Brand::latest()->get();
          $data['table']['editable'] = "1";
          return response()->json([
              'message' => 'Success get data',
              'data' => $data
          ], 200);
          
      } catch (QueryException $e) {
          return response()->json([
              'message' => 'Failed get data',
              'error' => $e,
              'errorMessage' => $e->errorInfo[2]
          ], 500);
      }
    }

    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $brand = Brand::create($input);

            return response()->json([
                'message' => 'Success storing data',
                'data' => $brand
            ], 200);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Failed storing data',
                'error' => $e,
                'errorMessage' => $e->errorInfo[2]
            ], 500);
            
        }
    }

    public function show($id)
    {
        try {

            $brand = Brand::find($id);
            return response()->json([
                'message' => 'Success getting data',
                'data' => $brand
            ], 200);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Failed getting data',
                'error' => $e,
                'errorMessage' => $e->errorInfo[2]
            ], 500);
            
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $brand = Brand::find($id);
            $input = $request->all();
            $brand->update($input);
            $brand->save();

            return response()->json([
                'message' => 'Success updating data',
                'data' => $brand
            ], 200);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Failed updating data',
                'error' => $e,
                'errorMessage' => $e->errorInfo[2]
            ], 500);
            
        }
    }

    public function destroy($id)
    {
        try {
            Brand::find($id)->delete();
            
            return response()->json([
                'message' => 'Success deleting data',
            ], 200);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Failed deleting data',
                'error' => $e,
                'errorMessage' => $e->errorInfo[2]
            ], 500);
            
        }
    }
}

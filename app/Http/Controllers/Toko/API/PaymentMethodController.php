<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(){
      try {
        $data['payment_method'] = PaymentMethod::whereNotIn('name', ['cash', 'paylater'])
                                  ->get();
        $data['table']['head'] = ['name', 'credentials', 'description'];
        $data['table']['body'] = PaymentMethod::whereNotIn('name', ['cash', 'paylater'])
                                  ->get();
        $data['table']['editable'] = "1,2,3";                
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
            $PaymentMethod = PaymentMethod::create($input);

            return response()->json([
                'message' => 'Success storing data',
                'data' => $PaymentMethod
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
            $PaymentMethod = PaymentMethod::find($id);
            return response()->json([
                'message' => 'Success getting data',
                'data' => $PaymentMethod
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
            $PaymentMethod = PaymentMethod::find($id);
            $input = $request->all();
            $PaymentMethod->update($input);
            $PaymentMethod->save();

            return response()->json([
                'message' => 'Success updating data',
                'data' => $PaymentMethod
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
            PaymentMethod::find($id)->delete();
            
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

<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
          $data['supplier'] = Supplier::latest()->get();
          $data['table']['head'] = ['name', 'contact_name', 'contact_address', 'contact_phone', 'contact_link'];
          $data['table']['body'] = Supplier::latest()->get();
          $data['table']['editable'] = "1,2,3,4,5";
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $Supplier = Supplier::create($input);

            return response()->json([
                'message' => 'Success storing data',
                'data' => $Supplier
            ], 200);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Failed storing data',
                'error' => $e,
                'errorMessage' => $e->errorInfo[2]
            ], 500);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $Supplier = Supplier::find($id);
            return response()->json([
                'message' => 'Success getting data',
                'data' => $Supplier
            ], 200);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Failed getting data',
                'error' => $e,
                'errorMessage' => $e->errorInfo[2]
            ], 500);
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $input = $request->all();
            $Supplier = Supplier::find($id)->update($input);

            return response()->json([
                'message' => 'Success updating data',
                'data' => $Supplier
            ], 200);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Failed updating data',
                'error' => $e,
                'errorMessage' => $e->errorInfo[2]
            ], 500);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Supplier::find($id)->delete();
            
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

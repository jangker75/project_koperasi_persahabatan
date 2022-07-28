<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\DynamicImageService;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
          $data['store'] = Store::latest()->get();
          $data['table']['head'] = ['name', 'description', 'cover'];
          $data['table']['body'] = Store::latest()->get();
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

            // upload image
            if($request->hasFile('cover')){
              $imgSrvc = new DynamicImageService();
              $input['image'] = $imgSrvc->upload('cover', $request, 'store', $input['name'])['path'];
            }

            $Store = Store::create($input);

            return response()->json([
                'message' => 'Success storing data',
                'data' => $Store
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

            $Store = Store::find($id);
            return response()->json([
                'message' => 'Success getting data',
                'data' => $Store
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
            $Store = Store::find($id);
            $input = $request->all();

            // upload image
            if($request->hasFile('cover')){
              $imgSrvc = new DynamicImageService();
              $input['image'] = $imgSrvc->update('cover', $request, 'store', $input['name'], $Store->cover)['path'];
            }

            $Store->update($input);
            $Store->save();

            return response()->json([
                'message' => 'Success updating data',
                'data' => $Store
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
            Store::find($id)->delete();
            
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

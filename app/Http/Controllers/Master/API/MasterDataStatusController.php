<?php

namespace App\Http\Controllers\Master\API;

use App\Http\Controllers\Controller;
use App\Models\MasterDataStatus;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MasterDataStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try {
          $data['masterDataStatus'] = MasterDataStatus::latest()->get();
          $data['table']['head'] = ['name', 'description', 'type'];
          $data['table']['body'] = MasterDataStatus::latest()->get();
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
            $masterStatus = MasterDataStatus::create($input);

            return response()->json([
                'message' => 'Success storing data',
                'data' => $masterStatus
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

            $masterStatus = MasterDataStatus::find($id);
            return response()->json([
                'message' => 'Success getting data',
                'data' => $masterStatus
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
            $masterStatus = MasterDataStatus::find($id);
            $input = $request->all();
            $masterStatus->update($input);
            $masterStatus->save();

            return response()->json([
                'message' => 'Success updating data',
                'data' => $masterStatus
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
            MasterDataStatus::find($id)->delete();
            
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

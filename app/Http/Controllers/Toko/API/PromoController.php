<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromoRequest;
use App\Models\Promo;
use App\Services\DynamicImageService;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
              $input['image'] = $imgSrvc->upload('cover', $request, 'promo', $input['name'])['path'];
            }

            $Promo = Promo::create($input);

            return response()->json([
                'message' => 'Success storing data',
                'data' => $Promo
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

            $Promo = Promo::find($id);
            return response()->json([
                'message' => 'Success getting data',
                'data' => $Promo
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
            $Promo = Promo::find($id);
            $input = $request->all();

            // upload image
            if($request->hasFile('cover')){
              $imgSrvc = new DynamicImageService();
              $input['image'] = $imgSrvc->update('cover', $request, 'promo', $input['name'], $Promo->image)['path'];
            }

            $Promo->update($input);
            $Promo->save();

            return response()->json([
                'message' => 'Success updating data',
                'data' => $Promo
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
        //
    }
}

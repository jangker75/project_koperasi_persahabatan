<?php

namespace App\Http\Controllers\Toko\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\DynamicImageService;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
          $data['category'] = Category::latest()->get();
          $data['table']['head'] = ['name', 'description', 'cover'];
          $data['table']['body'] = Category::latest()->get();
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
              $input['cover'] = $imgSrvc->upload('cover', $request, 'category', $input['name'])['path'];
            }

            $category = Category::create($input);

            return response()->json([
                'message' => 'Success storing data',
                'data' => $category
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

            $category = Category::find($id);
            return response()->json([
                'message' => 'Success getting data',
                'data' => $category
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
            $category = Category::find($id);
            $input = $request->all();

            // upload image
            if($request->hasFile('cover')){
              $imgSrvc = new DynamicImageService();
              $input['cover'] = $imgSrvc->update('cover', $request, 'category', $input['name'], $category->cover)['path'];
            }

            $category->update($input);
            $category->save();

            return response()->json([
                'message' => 'Success updating data',
                'data' => $category
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
            Category::find($id)->delete();
            
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

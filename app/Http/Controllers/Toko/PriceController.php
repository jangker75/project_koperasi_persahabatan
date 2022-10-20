<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;

class PriceController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $product = Product::find($request->get('product_id'));
        Price::find($product->price[count($product->price)-1]->id)->update(['is_active' => false]);
        $input['product_id'] = $request->get('product_id');
        $input['cost'] = str($request->get('cost'))->replace('.','');
        $input['revenue'] = str($request->get('revenue'))->replace('.','');
        $input['profit'] = str($request->get('profit'))->replace('.','');
        $input['margin'] = $request->get('margin');
        Price::create($input);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $input['cost'] = str($request->get('cost'))->replace('.','');
        $input['revenue'] = str($request->get('revenue'))->replace('.','');
        $input['profit'] = str($request->get('profit'))->replace('.','');
        $input['margin'] = $request->get('margin');
        Price::find($id)->update($input);

        return redirect()->back();
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

    public function pricesProduct($productId){
      $data['prices'] = Price::where('product_id', $productId)->latest()->get();
      $product = Product::select('id', 'name')->where('id', $productId)->first();
      $data['titlePage'] = 'History Produk '. $product->name;

      return view('admin.pages.toko.product.prices', $data);
    }
}

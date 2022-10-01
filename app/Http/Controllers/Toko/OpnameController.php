<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\Product;
use App\Models\Store;
use App\Repositories\ProductStockRepositories;
use App\Services\HistoryStockService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['titlePage'] = 'Kelola Data Opname Stock';
        $data['stocks'] = (new ProductStockRepositories())->indexStock();
        $data['opnames'] = Opname::latest()->get();
        $data['stores'] = Store::get();

        return view('admin.pages.toko.opname.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['titlePage'] = 'Halaman Reporting Opname';
        $data['type'] = ['minus', 'plus'];
        $data['stores'] = Store::where('is_warehouse', '!=', true)->get();
        return view('admin.pages.toko.opname.create', $data);
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
          DB::beginTransaction();
          $inputOpname = [
            'store_id' => $request->storeId,
            'employee_id' => $request->employeeId
          ];

          if(isset($request->note)){
            $inputOpname['note'] = $request->note;
          }

          $opname = Opname::create($inputOpname);
          
          foreach ($request->item as $key => $item) {
            $product = Product::find($request->productId);

            $detail = OpnameDetail::create([
              'opname_id' => $opname->id,
              'product_id' => $request->productId,
              'quantity' => $request->quantity,
              'description' => $request->description
            ]);
            
            $stockNow = (new ProductStockRepositories())->findProductOnStockByKeyword($product->slug, null, $request->storeId);
            $sisa = (int) $stockNow['qty'] - $request->quantity;
            (new HistoryStockService())->update("opname", [
              'opnameCode' => $opname->opname_code,
              'productId' => $request->productId,
              'qty' => $sisa
            ]);
          }

          DB::commit();
          $response['message'] = $opname;
          $response['status'] = "success";
          return response()->json($response, 200);
        } catch (Exception $e) {
          DB::rollBack();
          $response['message'] = $e->getMessage();
          $response['status'] = "failed";
          return response()->json($response, 500);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function printFormOpname($storeId){
      $data['stock'] = (new ProductStockRepositories())->indexStock($storeId);
      dd($data);
    }
}

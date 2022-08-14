<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\DetailTransferStock;
use App\Models\Product;
use App\Models\Store;
use App\Models\TransferStock;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagementStockController extends BaseAdminController
{

    public function __construct()
    {
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.product.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = "SELECT 
            products.id, 
            products.name,
            products.sku,
            (SELECT JSON_ARRAYAGG(stores.name)  FROM stores) AS store_name,
            (SELECT JSON_ARRAYAGG(stocks.qty) FROM stocks WHERE stocks.product_id = products.id AND stocks.store_id IN (
              SELECT id FROM stores
            ) ORDER BY id LIMIT 1) AS qty
          FROM products 
          LEFT JOIN stocks ON stocks.product_id = products.id
          LEFT JOIN stores ON stores.id = stocks.store_id
        ";
        $data['stocks'] = collect(DB::select(DB::raw($query)))->toArray(); 

        $data['stores'] = Store::get();
        $data['transfer_stocks'] = TransferStock::get();
        $data['titlePage'] = "Manament Stock Product";
        $data['statuses'] = collect(DB::select(DB::raw("SELECT name, description FROM master_data_statuses WHERE master_data_statuses.`type` LIKE '%transfer_stocks%'")))->toArray();

        return view('admin.pages.toko.stock.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['titlePage'] = "Buat Transfer Stock Product";
        $data['stores'] = Store::get();
        return view('admin.pages.toko.stock.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transfer = TransferStock::create([
          'from_store_id' => $request->originStore, 
          'to_store_id' => $request->destinationStore,
          'req_empl_id' => Auth::user()->employee->id,
          'req_date' => Carbon::now()
        ]);
        try {
          foreach ($request->product as $kPro => $product) {

            $product = Product::where('name', $product)->first();
            
            if($request->unit[$kPro] == 'pcs'){
              $totalQty = $request->quantity[$kPro];
            }else if($request->unit[$kPro] == 'pack'){
              $totalQty = 6 * $request->quantity[$kPro];
            }else if($request->unit[$kPro] == 'box'){
              $totalQty = 24 * $request->quantity[$kPro];
            }

            DetailTransferStock::create([
              'transfer_stock_id' => $transfer->id,
              'product_id' => $product->id,
              'request_qty' => $totalQty
            ]);
          }

          return redirect()->route('admin.management-stock.index');
        } catch (QueryException $e) {
          return redirect()->back()->with("error", $e->errorInfo[2]);
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
        $data['transferStock'] = TransferStock::find($id);
        $data['titlePage'] = "Detail Transfer Stock " .  $data['transferStock']->transfer_stock_code;
        return view('admin.pages.toko.stock.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data['transferStock'] = TransferStock::find($id);
      $data['titlePage'] = "Edit Transfer Stock " .  $data['transferStock']->transfer_stock_code;
      $data['stores'] = Store::get();
      return view('admin.pages.toko.stock.create', $data);
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
          $transfer = TransferStock::find($id);
          $transfer->update([
            'from_store_id' => $request->originStore, 
            'to_store_id' => $request->destinationStore,
            'req_empl_id' => Auth::user()->employee->id,
            'req_date' => Carbon::now()
          ]);
          $transfer = TransferStock::find($id);

          $ids = [];

          foreach ($request->product as $kPro => $product) {

            $product = Product::where('name', $product)->first();

            if($request->unit[$kPro] == 'pcs'){
              $totalQty = $request->quantity[$kPro];
            }else if($request->unit[$kPro] == 'pack'){
              $totalQty = 6 * $request->quantity[$kPro];
            }else if($request->unit[$kPro] == 'box'){
              $totalQty = 24 * $request->quantity[$kPro];
            }

            foreach ($transfer->detailItem as $key => $item) {
              if($item->product_id == $product->id){
                $detail = DetailTransferStock::find($item->id)->update([
                  'request_qty' => $totalQty
                ]);
                $detail = DetailTransferStock::find($item->id);
                array_push($ids, $detail->id);
              }else{
                $check = DetailTransferStock::where('transfer_stock_id', $transfer->id)
                                          ->where('product_id', $product->id)->first();
                if(!$check){
                  $detail = DetailTransferStock::create([
                    'transfer_stock_id' => $transfer->id,
                    'product_id' => $product->id,
                    'request_qty' => $totalQty
                  ]);
                  array_push($ids, $detail->id);
                }
              }
            }
          }
          // dd($ids);
          DetailTransferStock::whereNotIn('id', $ids)->delete();

          return redirect()->route('admin.management-stock.index');
        } catch (QueryException $e) {
          dd($e);
          return redirect()->back()->with("error", $e->errorInfo[2]);
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
        $transfer = TransferStock::find($id);

        DetailTransferStock::where('transfer_stock_id', $transfer->id)->delete();
        $transfer->delete();

        return redirect()->back();
    }


    public function confirmTicket($id){
      $transfer = TransferStock::find($id);

      $transfer->update([
        'status_id' => 4
      ]);

      return redirect()->back();
    }
}

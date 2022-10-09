<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\DetailTransferStock;
use App\Models\MasterDataStatus;
use App\Models\Product;
use App\Models\Store;
use App\Models\TransferStock;
use App\Repositories\ProductStockRepositories;
use App\Repositories\TransferStockRepository;
use App\Services\HistoryTransferStockService;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagementStockController extends BaseAdminController
{

    public function __construct()
    {
        parent::__construct();
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
        $data['stocks'] = (new ProductStockRepositories())->indexStock();
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
      try {
          DB::beginTransaction();
          $transfer = TransferStock::create([
            'from_store_id' => $request->originStore, 
            'to_store_id' => $request->destinationStore,
            'req_empl_id' => Auth::user()->employee->id,
            'req_date' => Carbon::now()
          ]);

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
              'product_id' => $product->productId,
              'request_qty' => $product->quantity
            ]);
          }

          DB::commit();
          return redirect()->route('admin.management-stock.index');
        } catch (QueryException $e) {
          DB::rollBack();
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
        $data['statuses'] = MasterDataStatus::where('type', 'like', '%transfer_stocks%')->get();
        $data['availableStock'] = TransferStockRepository::getItemFromId($id);
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
      return view('admin.pages.toko.stock.edit', $data);
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
      HistoryTransferStockService::update('Approved Ticket', $id);
      return redirect()->back();
    }

    public function startTicket($id){
      HistoryTransferStockService::update('Ordering', $id);
      return redirect()->back();
    }

    public function rejectTicket($id){
      $transferStock = TransferStock::find($id);
      HistoryTransferStockService::update("reject", $id);
      return redirect()->back();
    }
}

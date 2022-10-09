<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Models\DetailOrderSupplier;
use App\Models\MasterDataStatus;
use App\Models\OrderSupplier;
use App\Models\Product;
use App\Models\Store;
use App\Models\Supplier;
use App\Repositories\OrderSupplierRepository;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderSupplierController extends Controller
{
    public function __construct()
    {
        // parent::__construct();
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
        $data['orderSuppliers'] = OrderSupplier::latest()->get();
        $data['titlePage'] = "Management Order Supplier";
        $data['statuses'] = collect(DB::select(DB::raw("SELECT name, description FROM master_data_statuses WHERE master_data_statuses.`type` LIKE '%order_suppliers%'")))->toArray();

        return view('admin.pages.toko.order-supplier.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['titlePage'] = "Buat Pesanan ke Supplier";
        $data['stores'] = Store::get();
        $data['suppliers'] = Supplier::get();
        return view('admin.pages.toko.order-supplier.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $transfer = OrderSupplier::create([
    //       'supplier_id' => $request->supplierId, 
    //       'to_store_id' => $request->destinationStore,
    //       'req_empl_id' => Auth::user()->employee->id, 
    //       'order_date' => Carbon::now(), 
    //       'note' => $request->note ? $request->note : ""
    //     ]);
    //     try {
    //       foreach ($request->product as $kPro => $product) {

    //         $product = Product::where('name', $product)->first();
            
    //         if($request->unit[$kPro] == 'pcs'){
    //           $totalQty = $request->quantity[$kPro];
    //         }else if($request->unit[$kPro] == 'pack'){
    //           $totalQty = 6 * $request->quantity[$kPro];
    //         }else if($request->unit[$kPro] == 'box'){
    //           $totalQty = 24 * $request->quantity[$kPro];
    //         }

    //         DetailOrderSupplier::create([
    //           'order_supplier_id' => $transfer->id,
    //           'product_id' => $product->id,
    //           'request_qty' => $totalQty
    //         ]);
    //       }

    //       return redirect()->route('admin.order-supplier.index');
    //     } catch (QueryException $e) {
    //       return redirect()->back()->with("error", $e->errorInfo[2]);
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['orderSupplier'] = OrderSupplier::find($id);
        $data['titlePage'] = "Detail Order Supplier " .  $data['orderSupplier']->order_supplier_code;
        $data['statuses'] = MasterDataStatus::where('type', 'like', '%order_suppliers%')->get();
        return view('admin.pages.toko.order-supplier.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data['orderSupplier'] = OrderSupplier::find($id);
      $data['titlePage'] = "Edit Order Supplier " .  $data['orderSupplier']->order_supplier_code;
      $data['stores'] = Store::get();
      $data['suppliers'] = Supplier::get();
      return view('admin.pages.toko.order-supplier.edit', $data);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
      
    //   try {
    //       $orderSupplier = OrderSupplier::find($id);
    //       $orderSupplier->update([
    //         'supplier_id' => $request->originStore, 
    //         'to_store_id' => $request->destinationStore,
    //         'req_empl_id' => Auth::user()->employee->id,
    //         'req_date' => Carbon::now()
    //       ]);
    //       $orderSupplier = OrderSupplier::find($id);

    //       $ids = [];

    //       foreach ($request->product as $kPro => $product) {

    //         $product = Product::where('name', $product)->first();

    //         if($request->unit[$kPro] == 'pcs'){
    //           $totalQty = $request->quantity[$kPro];
    //         }else if($request->unit[$kPro] == 'pack'){
    //           $totalQty = 6 * $request->quantity[$kPro];
    //         }else if($request->unit[$kPro] == 'box'){
    //           $totalQty = 24 * $request->quantity[$kPro];
    //         }

    //         foreach ($orderSupplier->detailItem as $key => $item) {
    //           if($item->product_id == $product->id){
    //             $detail = DetailOrderSupplier::find($item->id)->update([
    //               'request_qty' => $totalQty
    //             ]);
    //             $detail = DetailOrderSupplier::find($item->id);
    //             array_push($ids, $detail->id);
    //           }else{
    //             $check = DetailOrderSupplier::where('order_supplier_id', $orderSupplier->id)
    //                                       ->where('product_id', $product->id)->first();
    //             if(!$check){
    //               $detail = DetailOrderSupplier::create([
    //                 'order_supplier_id' => $orderSupplier->id,
    //                 'product_id' => $product->id,
    //                 'request_qty' => $totalQty
    //               ]);
    //               array_push($ids, $detail->id);
    //             }
    //           }
    //         }
    //       }
    //       // dd($ids);
    //       OrderSupplier::whereNotIn('id', $ids)->delete();

    //       return redirect()->route('admin.order-supplier.index');
    //     } catch (QueryException $e) {
    //       dd($e);
    //       return redirect()->back()->with("error", $e->errorInfo[2]);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderSupplier = OrderSupplier::find($id);

        DetailOrderSupplier::where('transfer_stock_id', $orderSupplier->id)->delete();
        $orderSupplier->delete();

        return redirect()->back();
    }


    

    public function confirmTicket($id){
      $status = MasterDataStatus::where('name', 'Approved Ticket')->first();
      $orderSupplier = OrderSupplier::find($id);
      $orderSupplier->status_id = $status->id;
      $orderSupplier->save();
      return redirect()->back();
    }

    public function startTicket($id){
      //ordering
      $status = MasterDataStatus::where('name', 'Ordering')->first();
      $orderSupplier = OrderSupplier::find($id);
      $orderSupplier->status_id = $status->id;
      $orderSupplier->save();
      return redirect()->back();
    }

    public function rejectTicket($id){
      //reject
      $status = MasterDataStatus::where('name', 'reject')->first();
      $orderSupplier = OrderSupplier::find($id);
      $orderSupplier->status_id = $status->id;
      $orderSupplier->save();
      return redirect()->back();
    }

    public function receiveView($id){
      $data['orderSupplier'] = OrderSupplier::find($id);
      $data['titlePage'] = "Edit Order Supplier " .  $data['orderSupplier']->order_supplier_code;
      $data['detail'] = (new OrderSupplierRepository())->getItemFromId($id);
      $data['detailStringify'] = json_encode(collect($data['detail'])->toArray());
      $data['margin'] = ApplicationSetting::where('name', 'minimum_margin_price')->first();
      $data['margin'] = $data['margin']->content;
      return view('admin.pages.toko.order-supplier.receive', $data);
    }
}

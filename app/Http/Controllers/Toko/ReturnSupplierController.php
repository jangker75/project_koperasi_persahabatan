<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\MasterDataStatus;
use App\Models\OpnameDetail;
use App\Models\ReturnSupplier;
use App\Models\ReturnSupplierDetail;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['titlePage'] = 'Kelola Data Return';
        $data['returnSupplier'] = ReturnSupplier::latest()->get();

        return view('admin.pages.toko.return-supplier.index', $data);
    }

    public function create(){
        $data['opnames'] = DB::table('opname_details')
                                ->select(
                                  'opname_details.*',
                                  'products.name as productName', 
                                  'opnames.created_at as opnameDate',
                                  'opnames.opname_code as opnameCode'
                                  )
                                ->leftJoin('products', 'opname_details.product_id', 'products.id')
                                ->leftJoin('opnames', 'opname_details.opname_id', 'opnames.id')
                                ->whereBetween('opnames.created_at', [Carbon::now()->subDays(30), Carbon::now()])
                                ->where('opname_details.is_returned', '!=', 1)
                                ->latest()->get();
        $data['titlePage'] = "Buat Data Return Stock";
        $data['suppliers'] = Supplier::latest()->get();
        return view('admin.pages.toko.return-supplier.create', $data);
    }

    public function store(Request $request){
      $input = $request->all();
      $status = MasterDataStatus::where('name', 'waiting')->first();
      $input['status_return_id'] = $status->id;
      $input['status_ticket_id'] = $status->id;

      $returnSupplier = ReturnSupplier::create($input);

      $idOpnameDetail = array_keys($input['opnameDetail']);

      foreach ($idOpnameDetail as $key => $idOpname) {
        $opnameDetail = OpnameDetail::find($idOpname);

        ReturnSupplierDetail::create([
          'return_supplier_id' => $returnSupplier->id,
          'product_id' => $opnameDetail->product_id,
          'qty' => $opnameDetail->quantity,
        ]);
      }

      return redirect()->route('admin.return-supplier.show', $returnSupplier->id);
    }

    public function show($id){
      $returnSupplier = ReturnSupplier::find($id);
      dd($returnSupplier);
    }
}

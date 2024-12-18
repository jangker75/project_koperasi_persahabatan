<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\MasterDataStatus;
use App\Models\OpnameDetail;
use App\Models\ReturnSupplier;
use App\Models\ReturnSupplierDetail;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Supplier;
use App\Services\HistoryStockService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
        $data['titlePage'] = "Buat Data Return Stock";
        $data['stores'] = Store::get();
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
      $data['returnSupplier'] = ReturnSupplier::findOrFail($id);
      $data['titlePage'] = "Detail Return Stock " . $data['returnSupplier']->return_supplier_code;
      return view("admin.pages.toko.return-supplier.show", $data);
    }

    public function getIndexDatatables()
    {
        $query = ReturnSupplier::query()
        ->select(
          'return_suppliers.*',
          DB::raw('IF(employees.first_name is null, "-", concat(employees.first_name, " ", employees.last_name)) as employee'),
          'stores.name as storeName',
          DB::raw('SUM(return_supplier_details.qty) as totalQty')
          )
        ->leftJoin('employees', 'return_suppliers.submit_employee_id', '=', 'employees.id')
        ->leftJoin('return_supplier_details', 'return_suppliers.id', '=', 'return_supplier_details.return_supplier_id')
        ->leftJoin('stores', 'return_suppliers.store_id', '=', 'stores.id')
        ->groupBy('return_suppliers.id');
        
        $datatable = new DataTables();

        return $datatable->eloquent($query)
          ->addIndexColumn(true)
          ->addColumn('actions', function($row){
              $btn = '<a href="'.route('admin.return-supplier.show', $row).'"
                class="btn btn-primary btn-sm me-1" data-toggle="tooltip" data-placement="top"
                target="_blank" title="Lihat Detail Produk">Lihat Detail</a>';
              return $btn;
          })
          ->filterColumn('employee', function($query, $keyword) {
              $sql = "CONCAT(employees.first_name,'-',employees.last_name) like ?";
              $query->whereRaw($sql, ["%{$keyword}%"]);
          })
          // ->filterColumn('supplierName', function($query, $keyword) {
          //     $sql = "suppliers.name like ?";
          //     $query->whereRaw($sql, ["%{$keyword}%"]);
          // })
          ->filterColumn('storeName', function($query, $keyword) {
              $sql = "stores.name like ?";
              $query->whereRaw($sql, ["%{$keyword}%"]);
          })
          ->filterColumn('status', function($query, $keyword) {
              if(str($keyword)->lower() == "commit"){
                $sql = "return_suppliers.is_commit = 1";
                $query->whereRaw($sql);
              }else{
                $sql = "return_suppliers.is_commit != 1";
                $query->whereRaw($sql);
              }
          })
          ->rawColumns(['actions'])
          ->make(true);
    }

    public function destroy($id){
      $returnSupplier = ReturnSupplier::findOrFail($id);

      foreach ($returnSupplier->details as $key => $detail) {
        $stock = Stock::where('product_id', $detail->product_id)
                      ->where('store_id', $returnSupplier->store_id)
                      ->first();
        $stock->qty = $stock->qty + $detail->qty;
        $stock->save();

        (new HistoryStockService)->update('cancel-return', [
          'returnCode' => $returnSupplier->return_supplier_code,
          'productId' => $detail->product_id,
          'qty' => $detail->qty
        ]);
      }

      ReturnSupplierDetail::where('return_supplier_id', $returnSupplier->id)->delete();

      ReturnSupplier::find($id)->delete();

      return redirect()->route('admin.return-supplier.index');
    }
}

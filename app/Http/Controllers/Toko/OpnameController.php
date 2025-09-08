<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Store;
use App\Repositories\ProductStockRepositories;
use App\Services\HistoryStockService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
        // $data['stocks'] = (new ProductStockRepositories())->indexStock();
        $data['stores'] = Store::get();
        $data['categories'] = Category::latest()->get();
        $data['opnames'] = Opname::latest()->get();
        // ambil produk yg hanya memiliki stok lebih dari 0
        $data['products'] = Product::with(['stock' => function($query) {
            $query->select('product_id', 'store_id', DB::raw('SUM(qty) as qty'))
                  ->groupBy('product_id', 'store_id');
        }])->has('stock')->get(); 
        // $data['products'] = Product::latest()->get();
        // $data['stocks'] = Stock::latest()->get();
        // $stock = $data['stocks']->where('store_id', 1)
        //             ->where('product_id', 5)
        //             ->first();
        // dd($stock);

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
        $data['stores'] = Store::get();
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
        $data['titlePage'] = 'Kelola Data Opname Stock';
        $data['opname'] = Opname::find($id);
        

        return view('admin.pages.toko.opname.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['titlePage'] = 'Edit Opname Stock';
        $data['opname'] = Opname::find($id);
        $data['type'] = ['minus', 'plus'];
        $data['stores'] = Store::where('is_warehouse', '!=', true)->get();

        return view('admin.pages.toko.opname.edit', $data);
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

    public function getIndexDatatables()
    {
        $query = Opname::query()
        ->select(
          'opnames.*',
          DB::raw('if(opnames.is_commit = 1, "Commit", "Placed") as status'), 
          DB::raw('COUNT(opname_details.id) as countDetail'),
          'stores.name as storeName',
          DB::raw('IF(employees.first_name is null, "-", concat(employees.first_name, " ", employees.last_name)) as employee')
          )
        ->leftJoin('opname_details', 'opnames.id', '=', 'opname_details.opname_id')
        ->leftJoin('employees', 'opnames.employee_id', '=', 'employees.id')
        ->leftJoin('stores', 'opnames.store_id', '=', 'stores.id')
        ->groupBy('opnames.id');
        
        $datatable = new DataTables();
        return $datatable->eloquent($query)
          ->addIndexColumn(true)
          ->addColumn('actions', function($row){
              $btn = '<a href="'.route('admin.opname.show', $row).'"
                class="btn btn-primary btn-sm me-1" data-toggle="tooltip" data-placement="top"
                target="_blank" title="Lihat Detail Produk">Lihat Detail</a>';
              return $btn;
          })
          ->rawColumns(['actions'])
          ->make(true);
    }

    public function printFormOpname(Request $request){

      $data['location'] = Store::find($request->storeId);
      if($request->mode == "orderToday"){
        $data['opname'] = (new ProductStockRepositories())->getProdukFromOrderToday($request->storeId);
        $data['title'] = "Opname berdasarkan Order Harian";
      }elseif ($request->mode == "category") {
        $data['opname'] = (new ProductStockRepositories())->getProductByCategoryId($request->storeId, $request->categoryId);
        $category = Category::find($request->categoryId);
        $data['title'] = "Opname berdasarkan Kategori Produk (" . $category->name . ")";
      }elseif ($request->mode == "allProduct") {
        $data['opname'] = (new ProductStockRepositories())->indexStockByStore($request->storeId);
        $data['title'] = "Opname berdasarkan Semua Produk";
      }
      else{
        $data['opname'] = [];
      }
      return view('admin.export.PDF.opname', $data);
      // $pdf = Pdf::loadView('admin.export.PDF.opname', $data);
      // return $pdf->download("opname-". date("Ymd") .".pdf");
    }
}

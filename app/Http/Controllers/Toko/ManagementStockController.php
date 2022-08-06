<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\TransferStock;
use Illuminate\Http\Request;
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
        //
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
        //
    }
}

<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\ApplicationSetting;
use App\Models\Brand;
use App\Models\Category;
use App\Models\HistoryStock;
use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Supplier;
use App\Repositories\ProductStockRepositories;
use App\Services\DynamicImageService;
use App\Services\HistoryStockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProductController extends BaseAdminController
{

    public function __construct()
    {
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.product.index');
        $this->data['limitMargin'] = ApplicationSetting::where("name", "minimum_margin_price")->first();
        $this->data['limitMargin'] = $this->data['limitMargin']->content;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = $this->data;
      $data['titlePage'] = 'Kelola Data Produk';
      $data['products'] = Product::limit(50)->get();
      
      return view('admin.pages.toko.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->data;
        $data['categories'] = Category::pluck('name','id');
        $data['brand'] = Brand::pluck('name','id');
        $data['suppliers'] = Supplier::get();
        $data['stores'] = Store::get();
        $data['titlePage'] = 'Formulir Produk Baru';
        return view('admin.pages.toko.product.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
      // dd($request->all());
      $inputProduct = $request->validated();

      // check for brand
      if($request->brand_id !== null){
        $inputProduct['brand_id'] = $request->brand_id;
      }else if(isset($request->new_brand)){
        // dd($request->new_brand);
        $brand_id = Brand::create([
          'name' => $request->new_brand
        ]);
        $inputProduct['brand_id'] = $brand_id->id;
      }else{
        $inputProduct['brand_id'] = null;
      }

      // upload image
      if($request->hasFile('cover')){
        $imgSrvc = new DynamicImageService();
        $inputProduct['cover'] = $imgSrvc->upload('cover', $request, 'product', $inputProduct['name'])['path'];
      }

      // insert product
      $product = Product::create($inputProduct);

      // attaching product to categories
      $product->categories()->attach($request->categories);

      // createing price to product
      $price = Price::create([
        'product_id' => $product->id,
        'cost' => str($request->price['cost'])->replace('.',''),
        'revenue' => str($request->price['revenue'])->replace('.',''),
        'profit' => str($request->price['profit'])->replace('.',''),
        'margin' => $request->price['margin'],
      ]);

      // creating stock to product
      foreach($request->stock as $kStock => $stockRequest){
        $stock = Stock::create([
          'product_id' => $product->id,
          'store_id' => $kStock,
          'qty' => $stockRequest
        ]);
      }

      return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->data;
        $data['product'] = Product::find($id);
        $data['price'] = $data['product']->price[count($data['product']->price)-1];
        $data['titlePage'] = 'Detail Produk ' . $data['product']->name;
        return view('admin.pages.toko.product.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->data;
        $data['categories'] = Category::pluck('name','id');
        $data['brand'] = Brand::pluck('name','id');
        $data['suppliers'] = Supplier::get();
        $data['titlePage'] = 'Formulir Produk Baru';
        $data['product'] = Product::find($id);
        $data['product']['categories'] = collect($data['product']->categories->pluck('id'))->toArray();
        $data['product']['categories'] = implode(',', $data['product']['categories']);
        return view('admin.pages.toko.product.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
      $inputProduct = $request->validated();
      $product = Product::find($id);
      // check for brand
      if($request->brand_id !== null){
        $inputProduct['brand_id'] = $request->brand_id;
      }else if(isset($request->new_brand)){
        $brand_id = Brand::create([
          'name' => $request->new_brand
        ]);
        $inputProduct['brand_id'] = $brand_id->id;
      }else{
        // $inputProduct['brand_id'] = null;
      }

      // upload image
      if($request->hasFile('cover')){
        $imgSrvc = new DynamicImageService();
        $inputProduct['cover'] = $imgSrvc->update('cover', $request, 'product', $inputProduct['name'], $product->cover)['path'];
      }

      // update product
      $product->update($inputProduct);
      $product->save();

      // attaching product to categories
      $product->categories()->sync($request->categories);

      return redirect()->route('admin.product.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        Price::where('product_id', $product->id)->delete();
        Stock::where('product_id', $product->id)->delete();
        $product->delete();

        return redirect()->route('admin.product.index');
    }

    public function getIndexDatatables()
    {
        $query = Product::query()
        ->select(
          'products.*',
          DB::raw('if(brands.name IS NULL, "-", brands.name) as brandName'), 
          DB::raw('concat("Rp. ", format(prices.revenue, 0)) as price'))
        ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->leftJoin('prices', function($join){
          $join->on('products.id', '=', 'prices.product_id');
          $join->on('prices.is_active','=', DB::raw("'". 1 . "'"));
        })
        ->groupBy('products.id');
        
        $datatable = new DataTables();
        return $datatable->eloquent($query)
          ->addIndexColumn(true)
          ->addColumn('actions', function($row){
              $btn = '<a href="'.route('admin.product.show', $row).'"
                class="btn btn-primary btn-sm me-1" data-toggle="tooltip" data-placement="top"
                target="_blank" title="Lihat Detail Produk">Lihat Detail</a>';
              return $btn;
          })
          ->rawColumns(['actions'])
          ->make(true);
    }

    public function updateManualStock($productId, Request $request){
      $product = Product::find($productId);
      foreach ($request->stock as $stockId => $value) {
        $stockBefore = Stock::where('id', $stockId)->first();
        Stock::where('id', $stockId)->update(['qty' => $value]);

        $input = [
          "title" => "Edit Manual Stok produk sku : " . $product->sku . " dari stok " . $stockBefore->qty . " menjadi " . $value . " | by: " . auth()->user()->employee->full_name,
          "product_id" => $productId
        ];

        if($stockBefore->qty > (int) $value){
          $input['type'] = 'deduction';
          $input['qty'] = $stockBefore->qty - (int) $value;
        }else{
          $input['type'] = 'induction';
          $input['qty'] = (int) $value - $stockBefore->qty;
        }
        
        HistoryStock::create($input);
      }

      return redirect()->route("admin.product.show", $productId);
    }

    public function getIndexDatatablesLabel()
    {
        $query = Product::query()
        ->select(
          'products.id',
          'products.name',
          'products.sku',
          DB::raw('IFNULL(brands.name, "--") as brand'), 
          DB::raw('IFNULL(GROUP_CONCAT(categories.name),"--") as category'),
          DB::raw('concat("Rp. ", format(prices.revenue, 0)) as price')
        )
        ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->leftJoin('prices', function($join){
          $join->on('products.id', '=', 'prices.product_id');
          $join->on('prices.is_active','=', DB::raw("'". 1 . "'"));
        })
        ->join('category_has_product','products.id','=','category_has_product.product_id')
        ->join('categories','category_has_product.category_id','=','categories.id')
        ->groupBy('products.id');
        
        $datatable = new DataTables();
        return $datatable->eloquent($query)
          ->addIndexColumn(true)
          ->addColumn('checkbox', function ($item) {
            return '<input type="checkbox" id="manual_entry_'.$item->id.'" class="manual_entry_cb" value="'.$item->id.'" />';
          })
          ->filterColumn('brand', function($query, $keyword) {
              $sql = "brands.name like ?";
              $query->whereRaw($sql, ["%{$keyword}%"]);
          })
          ->filterColumn('category', function($query, $keyword) {
              $sql = "categories.name like ?";
              $query->whereRaw($sql, ["%{$keyword}%"]);
          })
          ->rawColumns(['action', 'checkbox'])
          ->make(true);
    }
}

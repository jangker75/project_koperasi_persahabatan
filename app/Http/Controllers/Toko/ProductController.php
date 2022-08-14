<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Supplier;
use App\Services\DynamicImageService;
use Illuminate\Http\Request;

class ProductController extends BaseAdminController
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
      $data = $this->data;
      $data['titlePage'] = 'Kelola Data Produk';
      $data['products'] = Product::latest()->get();
      
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

      // attaching product to suppliers
      if(isset($request->supplier)){
        $product->suppliers()->attach($request->supplier);
      }else{
        $supplier = Supplier::create([
          'name' => $request->new_supplier['name'],
          'contact_name' => $request->new_supplier['contact_name'],
          'contact_address' => $request->new_supplier['contact_address'],
          'contact_phone' => $request->new_supplier['contact_phone'],
          'contact_link' => $request->new_supplier['contact_link'],
        ]);
        $product->suppliers()->attach($supplier->id);
      }

      // createing price to product
      $price = Price::create([
        'product_id' => $product->id,
        'cost' => str($request->price['cost'])->replace('.',''),
        'revenue' => str($request->price['revenue'])->replace('.',''),
        'profit' => str($request->price['profit'])->replace('.',''),
        'margin' => $request->price['margin'],
      ]);

      // creating stock to product
      $stock = Stock::create([
        'product_id' => $product->id,
        'store_id' => 1,
        'qty' => 0
      ]);

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
        ->with('price')
        ->get();

        dd($query);
        // $datatable = new DataTables();
        // return $datatable->eloquent($query)
        //   ->addIndexColumn(true)
        //   ->editColumn('salary', function($row){
        //       return format_uang($row->salary);
        //   })
        //   ->addColumn('actions', function($row){
        //       $btn = '<div class="btn-list align-center d-flex justify-content-center">';
        //       $btn = $btn . '<a class="btn btn-sm btn-warning badge" href="'. route("admin.employee.show", [$row]) .'" type="button">View</a>';
        //       $btn = $btn . '<a class="btn btn-sm btn-primary badge" href="'. route("admin.employee.edit", [$row]) .'" type="button">Edit</a>';
        //       $btn = $btn . '<a class="btn btn-sm btn-danger badge delete-button" type="button">
        //                   <i class="fa fa-trash"></i>
        //               </a>
        //               <form method="POST" action="' . route('admin.employee.destroy', [$row]) . '">
        //                   <input name="_method" type="hidden" value="delete">
        //                   <input name="_token" type="hidden" value="' . Session::token() . '">
        //               </form>';
        //       $btn = $btn . '</div>';
        //       return $btn;
        //   })
        //   ->rawColumns(['actions'])
        //   ->make(true);
    }
}

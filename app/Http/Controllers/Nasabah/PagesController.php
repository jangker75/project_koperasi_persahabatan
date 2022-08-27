<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home(){
      $data['categories'] = Category::get();
      $data['stores'] = Store::where('is_warehouse', false)->get();

      return view('nasabah.pages.home', $data);
    }

    public function product(Request $request){
      $data['categories'] = Category::get();
      $data['stores'] = Store::where('is_warehouse', false)->get();

      return view('nasabah.pages.product.index', $data);
    }

    public function productDetail($sku){
      $data['stores'] = Store::where('is_warehouse', false)->get();
      return view('nasabah.pages.product.show', $data);
    }
}

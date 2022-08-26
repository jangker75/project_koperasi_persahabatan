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
      // $data['product'] = Product::latest()->limit(20)->get();
      $data['categories'] = Category::get();
      $data['stores'] = Store::where('is_warehouse', false)->get();

      return view('nasabah.pages.home', $data);
    }

    public function product(Request $request){
      $data['product'] = Product::latest()->paginate(20);
      $data['categories'] = Category::get();

      return view('nasabah.pages.product.index', $data);
    }

    public function productDetail($slug){
      $data['product'] = Product::where('slug', $slug)->first();

      return view('nasabah.pages.product.show', $data);
    }
}

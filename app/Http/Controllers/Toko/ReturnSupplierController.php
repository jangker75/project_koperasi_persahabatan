<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\OpnameDetail;
use App\Models\ReturnSupplier;
use Illuminate\Http\Request;

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
        $data['opname'] = OpnameDetail::where('is_returned', '!=', true)->latest()->get();
        $data['titlePage'] = "Buat Data Return Stock";
        dd($data);
        return view();
    }
}

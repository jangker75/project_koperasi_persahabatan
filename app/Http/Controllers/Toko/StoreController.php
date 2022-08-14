<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.store.index');
        $this->data['link'] = url('api/store');
    }

    public function index(){
      $data = $this->data;
      $data['titlePage'] = 'Data Toko';
      $data['stores'] = Store::latest()->get();
      $data['employees'] = Employee::get(); 
      return view('admin.pages.toko.store.index', $data);
    }

    public function destroy($id)
    {
        $Store = Store::find($id);

        $Store->delete();

        return redirect()->route('admin.store.index');
    }
}

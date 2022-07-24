<?php

namespace App\Http\Controllers\Share;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JqueryEditableController extends Controller
{
    public function renderTable(Request $request){
      $data['link'] = $request->get('link');
      return view('components.jquery-data-table-editable',$data)->render();
    }
}

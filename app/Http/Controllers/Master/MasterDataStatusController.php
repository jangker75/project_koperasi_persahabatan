<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\MasterDataStatus;
use Illuminate\Http\Request;

class MasterDataStatusController extends BaseAdminController
{
    public function __construct()
    {
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.master-status.index');
        $this->data['link'] = url('api/master-data-status');
    }

    public function index(){
      $data = $this->data;
      $data['titlePage'] = 'Master Data Status';
      return view('admin.pages.master-data-status.index', $data);
    }
}

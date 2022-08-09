<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;

class BaseAdminController extends Controller
{
    protected $data = [];
    protected $limit = 10;
    public function __construct()
    {
            $urlPath = str_replace([
                '/store','/edit','/create','/index'
            ],'', request()->path());
            $urlPath = explode('/', $urlPath);
            $url = $urlPath[count($urlPath)-1];
            $this->middleware("can:read ${url}", ['only' => ['index','show']]);
            // $this->middleware("can:create ${url}", ['only' => ['create','store']]);
            // $this->middleware("can:edit ${url}", ['only' => ['edit','update']]);
            // $this->middleware("can:delete ${url}", ['only' => ['destroy']]);
        
        $this->data['titlePage'] = 'No Name Page';
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = url('/');
    }
}

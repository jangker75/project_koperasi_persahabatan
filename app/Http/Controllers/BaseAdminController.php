<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BaseAdminController extends Controller
{
    protected $data = [];
    protected $limit = 10;
    public function __construct()
    {
        $this->data['titlePage'] = 'No Name Page';
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = url('/');
    }
}

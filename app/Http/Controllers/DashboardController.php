<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends BaseAdminController
{
    public function __construct()
    {
        $this->data['currentIndex'] = route('admin.company-balance.index');
    }
    public function index()
    {
        $data = $this->data;
        $data['titlePage'] = 'Dashboard';
        return view('admin.pages.dashboard.index', $data);
    }
}

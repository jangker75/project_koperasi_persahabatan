<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $data['employee'] = auth()->user()->employee;
        return view('nasabah.pages.profile.index', $data);
    }
}

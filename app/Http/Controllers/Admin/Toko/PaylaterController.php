<?php

namespace App\Http\Controllers\Admin\Toko;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Transaction;
use App\Repositories\PaylaterRepository;
use Illuminate\Http\Request;

class PaylaterController extends Controller
{
    public function index(){
      $data['paylaters'] = PaylaterRepository::calculateEmployeePaylater();
      $data['titlePage'] = "History Paylater";
      $data['totalNotPaid'] = Transaction::where('is_paylater',true)
                                ->where('status_paylater_id', "=", 9)->where('is_paid', "!=", true)->sum('amount');
      $data['totalPaid'] = Transaction::where('is_paylater',true)
                                ->where('status_paylater_id', "=", 9)->where('is_paid', true)->sum('amount');
      return view('admin.pages.toko.paylater.index', $data);
    }

    public function show($staffId){
      $data['employee'] = Employee::find($staffId);
      $data['titlePage'] = "History Paylater staff " . $data['employee']->full_name;
      $data['paylaters'] = PaylaterRepository::getDataPaylaterFromStaffId($staffId);
      $data['totalNotPaid'] = Transaction::where('is_paylater',true)
                                ->where('status_paylater_id', 9)
                                ->where('requester_employee_id', $staffId)
                                ->where('is_paid', "!=", true)->sum('amount');
      $data['totalPaid'] = Transaction::where('is_paylater',true)
                                ->where('status_paylater_id', 9)
                                ->where('requester_employee_id', $staffId)
                                ->where('is_paid', true)->sum('amount');
      return view('admin.pages.toko.paylater.show', $data);
    }

    public function paidPaylater(){
      Transaction::where('is_paylater', true)
                ->where('status_paylater_id', 9)
                ->update(['is_paid' => true]);
    }
}

<?php

namespace App\Http\Controllers\Umum\API;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeRepository;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function findEmployee(Request $request){
      try {
        $employee = EmployeeRepository::findEmployeeByNameOrNik($request->keyword);
        $data['message'] = "Success searching Data";
        $data['employee'] = $employee;

        return response()->json($data, 200);
      } catch (QueryException $e) {
        $data['message'] = "Success searching Data";
        $data['error'] = $e;

        return response()->json($data, 500);
      }
    }
}

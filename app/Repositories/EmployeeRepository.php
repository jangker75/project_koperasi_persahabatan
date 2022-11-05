<?php 
  
namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeRepository{

  public static function findEmployee($filters){
    $whereClause = "";

    foreach ($filters as $filter) {
      if($filter['field'] == 'name'){
        $whereClause .= " AND (employees.first_name LIKE '%" . $filter['value'] . "%' OR employees.last_name LIKE '%" . $filter['value'] . "%')";
      }
      elseif($filter['field'] == 'nik'){
        $whereClause .= " AND employees.nik LIKE '" . $filter['value'] . "%'";
      }
    }

    $sql = '
        SELECT 
          employees.id,
          CONCAT(employees.first_name, " ", employees.last_name, " - ", employees.nik) AS fullname,
          employees.nik as nik
        FROM employees
        WHERE employees.deleted_at IS NULL 
        ' . $whereClause . '
        ORDER BY employees.first_name ASC LIMIT 4
    ';

    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public static function findEmployeeByNameOrNik($keyword){
    $sql = '
        SELECT 
          employees.id,
          CONCAT(COALESCE(employees.first_name,""), " ", COALESCE(employees.last_name,""), " - ", COALESCE(employees.nik,"")) AS fullname,
          employees.nik as nik
        FROM employees
        WHERE employees.deleted_at IS NULL 
        AND (employees.nik LIKE "' . $keyword . '%" OR employees.first_name LIKE "' . $keyword . '%" OR employees.last_name LIKE "' . $keyword . '%")
        ORDER BY employees.first_name ASC LIMIT 4
    ';

    $data = DB::select(DB::raw($sql));

    return $data;
  }
  public static function getListDropdown(){
    $q = Employee::active()
        ->select(DB::raw('concat(COALESCE(first_name,""), " ", COALESCE(last_name,"")," (", nik, ")") as name'), 'id')
        ->pluck('name', 'id');
      return $q;
  }
  

}
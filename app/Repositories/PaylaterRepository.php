<?php 
  
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PaylaterRepository{

  public static function checkPaylaterFromEmployeeId($staffId){
    $sql = "
      SELECT
        employees.id,
        orders.id AS orderId,
        orders.order_code AS order_code,
        transactions.id AS transactionId,
        transactions.amount AS amount,
        transactions.request_date AS requestDate,
        master_data_statuses.name AS status
      FROM employees
      LEFT JOIN transactions ON transactions.requester_employee_id = employees.id
      LEFT JOIN orders ON transactions.order_id = orders.id
      LEFT JOIN master_data_statuses ON transactions.status_paylater_id = master_data_statuses.id
      WHERE employees.id = " . $staffId ." AND transactions.status_paylater_id = 4
      ORDER BY transactions.id DESC
    ";
    
    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public static function getDataPaylaterFromStaffId($staffId){
    $sql = "
      SELECT
        employees.id,
        orders.id AS orderId,
        orders.order_code AS order_code,
        transactions.id AS transactionId,
        transactions.amount AS amount,
        transactions.request_date AS requestDate,
        master_data_statuses.name AS status	
      FROM employees
      LEFT JOIN transactions ON transactions.requester_employee_id = employees.id
      LEFT JOIN orders ON transactions.order_id = orders.id
      LEFT JOIN master_data_statuses ON transactions.status_paylater_id = master_data_statuses.id
      WHERE employees.id = ".$staffId."
      ORDER BY transactions.id DESC
    ";

    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public static function indexPaylater(){
    $sql = "
      SELECT
        orders.id AS orderId,
        orders.order_code AS orderCode,
        transactions.id AS transactionId,
        transactions.amount AS amount,
        CONCAT(employees.first_name, ' ', employees.last_name) AS requesterName,
        transactions.request_date AS requestDate,
        master_data_statuses.name AS status,	
        master_data_statuses.color_button AS statusColor
      FROM transactions
      LEFT JOIN orders ON transactions.order_id = orders.id
      LEFT JOIN master_data_statuses ON transactions.status_paylater_id = master_data_statuses.id
      LEFT JOIN employees ON transactions.requester_employee_id = employees.id
      WHERE
      transactions.is_paylater = 1
      ORDER BY 
      transactions.status_paylater_id ASC,
      transactions.transaction_date DESC
      LIMIT 100
    ";

    $data = DB::select(DB::raw($sql));

    return $data;
  }
}
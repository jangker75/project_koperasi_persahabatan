<?php 
  
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OrderRepository{

  public static function getOrderFromEmployee($employeeId = null){
    if($employeeId == null){
      $where = "transactions.requester_employee_id IS NOT NULL";
    }else{
      $where = "transactions.requester_employee_id = " . $employeeId;
    }

    $sql = "
      SELECT
        orders.id AS orderId,
        orders.order_code AS orderCode,
        orders.subtotal AS subtotal,
        orders.total AS total,
        orders.note AS note,
        orders.order_date AS orderDate,
        statusOrder.name AS statusOrderName,
        statusOrder.color_button AS statusOrderColorButton,
        statusPaylater.name AS statusPaylaterName,
        statusPaylater.color_button AS statusPaylaterColorButton,
        transactions.is_paid AS isPaid,
        transactions.is_paylater AS isPaylater,
        transactions.is_delivery AS isDelivery,
        transactions.delivery_fee AS deliveryFee,
        CONCAT(employees.first_name, ' ', employees.last_name) AS requesterName,
        transactions.transaction_date AS requestDate
      FROM orders
      LEFT JOIN transactions ON orders.id = transactions.order_id and transactions.deleted_at IS NULL
      LEFT JOIN master_data_statuses statusOrder ON transactions.status_transaction_id = statusOrder.id
      LEFT JOIN master_data_statuses statusPaylater ON transactions.status_paylater_id = statusPaylater.id
      LEFT JOIN employees ON transactions.requester_employee_id = employees.id and employees.deleted_at IS NULL
      WHERE 
        " . $where . " AND
        transactions.status_transaction_id = 4 AND
        orders.deleted_at IS NULL
      ORDER BY transactions.transaction_date DESC, orders.id DESC
      LIMIT 100
    ";

    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public function getAllOrders($startDate = null, $endDate = null){

    $sql = "
      SELECT
        orders.id AS orderId,
        orders.order_code AS orderCode,
        orders.subtotal AS subtotal,
        orders.total AS total,
        orders.note AS note,
        orders.order_date AS orderDate,
        statusOrder.name AS statusOrderName,
        statusOrder.color_button AS statusOrderColorButton,
        statusPaylater.name AS statusPaylaterName,
        statusPaylater.color_button AS statusPaylaterColorButton,
        transactions.is_paid AS isPaid,
        transactions.is_paylater AS isPaylater,
        transactions.is_delivery AS isDelivery,
        transactions.delivery_fee AS deliveryFee,
        CONCAT(employees.first_name, ' ', employees.last_name) AS requesterName,
        transactions.transaction_date AS requestDate,
        SUM(order_details.qty) as totalQtyProduct
      FROM orders
      LEFT JOIN order_details ON orders.id = order_details.order_id AND orders.deleted_at IS NULL
      LEFT JOIN transactions ON orders.id = transactions.order_id and transactions.deleted_at IS NULL
      LEFT JOIN master_data_statuses statusOrder ON transactions.status_transaction_id = statusOrder.id
      LEFT JOIN master_data_statuses statusPaylater ON transactions.status_paylater_id = statusPaylater.id
      LEFT JOIN employees ON transactions.requester_employee_id = employees.id and employees.deleted_at IS NULL
      WHERE 
        orders.deleted_at IS NULL
      GROUP BY
        orders.id
      ORDER BY 
        transactions.transaction_date DESC, orders.id DESC
      LIMIT 100
    ";
    
    $data = DB::select(DB::raw($sql));

    return $data;
  }
}
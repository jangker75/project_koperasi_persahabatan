<?php 
  
namespace App\Repositories;

use Carbon\Carbon;
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

  public function getAllOrders($params){
    $where = "";
    $page = 1;

    foreach ($params as $key => $param) {
      if($param['key'] == "date"){
        if($param['value']['startDate'] !== null && $param['value']['endDate'] !== null){
          $start = Carbon::parse(strtotime($param['value']['startDate']))->format('Y-m-d');
          $end = Carbon::parse(strtotime($param['value']['endDate']))->format('Y-m-d');
        }
        $where .= " AND orders.order_date BETWEEN '" . $start . " 00:00:00' AND '" . $end . " 23:59:59'";
      }
      
      else if($param['key'] == "employeeId"){
        $where .= " AND transactions.requester_employee_id = '" . $param['value'] . "'";
      }
      else if($param['key'] == "page"){
        $page = (int) $param['value'];
      }
      else{
        $where .= " AND orders." . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $param['key'])) . " = '" . $param['value'] . "'";
      }
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
        transactions.transaction_date AS requestDate,
        SUM(order_details.qty) as totalQtyProduct
      FROM orders
      LEFT JOIN order_details ON orders.id = order_details.order_id AND orders.deleted_at IS NULL
      LEFT JOIN transactions ON orders.id = transactions.order_id and transactions.deleted_at IS NULL
      LEFT JOIN master_data_statuses statusOrder ON transactions.status_transaction_id = statusOrder.id
      LEFT JOIN master_data_statuses statusPaylater ON transactions.status_paylater_id = statusPaylater.id
      LEFT JOIN employees ON transactions.requester_employee_id = employees.id and employees.deleted_at IS NULL
      WHERE 
        orders.deleted_at IS NULL". $where ."
      GROUP BY
        orders.id
      ORDER BY 
        orders.id DESC
      LIMIT 20 OFFSET " . ($page - 1)*100 . "
    ";
    // dd($sql);
    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public function calculateReportCloseCashier($storeId){
    $sql = "
      SELECT
        payment_methods.name,
        SUM(transactions.amount) as amount,
        COUNT(transactions.id) as totalOrder,
        SUM(orders.discount) as totalDiscount
      FROM
        transactions
        LEFT JOIN payment_methods ON transactions.payment_method_id = payment_methods.id
        LEFT JOIN orders ON transactions.order_id = orders.id
      WHERE 
        transactions.deleted_at IS NULL AND
        date(transactions.transaction_date) = CURDATE() AND
        orders.store_id = " . $storeId . "
      GROUP BY 
        transactions.payment_method_id
    ";

    $data = DB::select(DB::raw($sql));

    return $data;
  }

  public function itemReportCloseCashier($storeId){
    $sql = "
      SELECT
        product_name AS productName,
        products.sku AS productSKU,
        SUM(order_details.qty) AS qty,
        SUM(order_details.subtotal) AS subtotal
      FROM
        transactions
        LEFT JOIN orders ON transactions.order_id = orders.id
        LEFT JOIN order_details ON orders.id = order_details.id
        LEFT JOIN products ON products.name = order_details.product_name
      WHERE 
        transactions.deleted_at IS NULL AND
        date(transactions.transaction_date) = CURDATE() AND
        orders.store_id = " . $storeId . "
      GROUP BY 
        order_details.product_name
    ";

    $data = DB::select(DB::raw($sql));

    return $data;
  }
}
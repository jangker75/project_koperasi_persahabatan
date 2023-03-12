<?php 
  
namespace App\Repositories;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;

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

  public function getAllOrders($page, $params, $getTotal = 0) {
  
    $where = "";
    if($page == NULL){
      $page = 1;
    }

    $date = array_filter($params, function($param){
      return $param['key'] == "date";
    });

    if(count($date) == 0){
      $where .= " AND orders.order_date BETWEEN '" . date("Y-m-d") . " 00:00:00' AND '" . date("Y-m-d") . " 23:59:59'";
    }

    foreach ($params as $key => $param) {
      if($param['key'] == "date"){
        if($param['value']['startDate'] !== null && $param['value']['endDate'] !== null){
          $start = Carbon::parse(strtotime($param['value']['startDate']))->format('Y-m-d');
          $end = Carbon::parse(strtotime($param['value']['endDate']))->format('Y-m-d');
          $where .= " AND orders.order_date BETWEEN '" . $start . " 00:00:00' AND '" . $end . " 23:59:59'";
        }
      }
      
      else if($param['key'] == "employeeId"){
        $where .= " AND transactions.requester_employee_id = '" . $param['value'] . "'";
      }
      else if($param['key'] == "employee"){
        $employeeId = (new EmployeeRepository())->findEmployeeByNameOrNik($param['value']);
        $employeeId = implode(",",array_values(array_column($employeeId, 'id')));
        $where .= " AND transactions.requester_employee_id IN (" . $employeeId . ")";
      }
      
      else if($param['key'] == "isPaylater"){
        if($param['value'] == 1){
          $where .= " AND transactions.is_paylater = 1";
        }else{
          $where .= " AND transactions.is_paylater = 0";
        }
      }
      else if($param['key'] == "isDelivery"){
        if($param['value'] == 1){
          $where .= " AND transactions.is_delivery = 1";
        }else{
          $where .= " AND (transactions.is_delivery != 1 OR transactions.is_delivery IS NULL)";
        }
      }
      else if($param['key'] == "isPaid"){
        if($param['value'] == 1){
          $where .= " AND transactions.is_paid = 1";
        }else{
          $where .= " AND (transactions.is_paid != 1 OR transactions.is_paid IS NULL)";
        }
      }
      else if($param['key'] == "totalPrice"){
        $where .= " AND orders.total like '%" . $param['value'] . "%'";
      }
      else{
        $where .= " AND orders." . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $param['key'])) . " = '" . $param['value'] . "'";
      }
    }

    $sql = "SELECT";
      
    if($getTotal == 0){
      $sql .= "
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
        IFNULL(CONCAT(IFNULL(employees.first_name, ''), ' ', IFNULL(employees.last_name, '')), '-') AS requesterName,
        transactions.transaction_date AS requestDate,
        SUM(order_details.qty) as totalQtyProduct
      ";
    } else{
      $sql .= "
        IFNULL(SUM(orders.total), 0) as grandTotal,
        IFNULL(SUM(IF(transactions.is_paylater = 1, orders.total, 0)), 0) as totalPaylater
      ";
    }
      
    $sql .= "
      FROM orders";

    if($getTotal == 0){
      $sql .= " 
      LEFT JOIN order_details ON orders.id = order_details.order_id AND orders.deleted_at IS NULL";
    }
    $sql .= " 
      LEFT JOIN transactions ON orders.id = transactions.order_id and transactions.deleted_at IS NULL
      LEFT JOIN master_data_statuses statusOrder ON transactions.status_transaction_id = statusOrder.id
      LEFT JOIN master_data_statuses statusPaylater ON transactions.status_paylater_id = statusPaylater.id
      LEFT JOIN employees ON transactions.requester_employee_id = employees.id and employees.deleted_at IS NULL
      WHERE
        orders.deleted_at IS NULL
        ". $where;
    if($getTotal == 0){
      $sql .=  " GROUP BY
          orders.id";
    }
    $sql .= " ORDER BY 
        orders.id DESC";

    if($getTotal == 0){
      $sql .= "
        LIMIT 10 OFFSET " . ($page - 1)*10 . "
      ";
    }
    // dd($sql);
    $data = json_decode(json_encode(DB::select(DB::raw($sql))), true);

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

  public function paginateOrder($page, $params){
    $sql = Order::query()->select(
      'orders.*',
      DB::raw('concat("Rp. ", format(orders.total, 0)) as totalPrice'),
      DB::raw('IF(employees.first_name is null, "-", concat(employees.first_name, " ", employees.last_name)) as employee'),
      DB::raw('SUM(order_details.qty) as totalQtyProduct'),
      DB::raw('IF(transactions.is_paylater = 1, "ya", "tidak") as isPaylater'),
      DB::raw('IF(transactions.is_delivery = 1, "ya", "tidak") as isDelivery'),
      DB::raw('IF(transactions.is_paid = 1, "Lunas", "Belum Lunas") as isPaid'),
      'master_data_statuses.name as statusOrder'
    )
    ->leftJoin('transactions', 'orders.id', '=', 'transactions.order_id')
    ->leftJoin('employees', 'transactions.requester_employee_id', '=', 'employees.id')
    ->leftJoin('order_details', 'orders.id', '=','order_details.order_id')
    ->leftJoin('master_data_statuses', 'orders.status_id', '=', 'master_data_statuses.id');
    // ->where('orders.status_id', "6");
    
    if(count($params) > 0){
      foreach ($params as $key => $param) {
        if($param['key'] == 'order_code'){
          $sql->where('orders.order_code', $param['value']);
        }
        else if($param['key'] == "date"){
          $start = Carbon::parse(strtotime($param['value']['startDate']))->format('Y-m-d');
          $end = Carbon::parse(strtotime($param['value']['endDate']))->format('Y-m-d');
          $sql->whereBetween('orders.order_date', [$start ." 00:00:00", $end ." 23:59:59"]);
        }
        else if($param['key'] == "employee"){
          $employeeId = (new EmployeeRepository())->findEmployeeByNameOrNik($param['value']);
          $employeeId = array_values(array_column($employeeId, 'id'));
          // $where .= " AND transactions.requester_employee_id IN (" . $employeeId . ")";
          $sql->whereIn("transactions.requester_employee_id", $employeeId);
        }
        else if($param['key'] == "isPaylater"){
          if($param['value'] = 1){
            $sql->where('transactions.is_paylater', 1);
          }else{
            $sql->whereNot('transactions.is_paylater', 1);
          }
        }
        else if($param['key'] == "isDelivery"){
          if($param['value'] = 1){
            $sql->where('transactions.is_delivery', 1);
          }else{
            $sql->whereNot('transactions.is_delivery', 1);
          }
        }
        else if($param['key'] == "isPaid"){
          if($param['value'] = 1){
            $sql->where('transactions.is_paid', 1);
          }else{
            $sql->whereNot('transactions.is_paid', 1);
          }
        }
        else if($param['key'] == "total"){
          $sql->where("orders.total", "like", "%" . $param['value'] . "%");
        }
        // else{
        //   $where .= " AND orders." . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $param['key'])) . " = '" . $param['value'] . "'";
        // }
      }
    }

    $date = array_filter($params, function($param){
      return $param['key'] == "date";
    });

    if(count($date) == 0){
      $sql->whereBetween('orders.order_date', [date("Y-m-d")." 00:00:00", date("Y-m-d")." 23:59:59"]);
    }

    if($page != NULL){
      $page == 1;
    }

    $sql->groupBy('orders.id');
    $paginate = $sql->paginate(10)->toArray();

    $data = [
      'current' => $paginate['current_page'],
      'total' => $paginate['total'],
      'perPage' => $paginate['per_page'],
      'first' => $paginate['from'],
      'last' => $paginate['to'],
      'links' => $paginate['links']
    ];

    return $data;
  }
}
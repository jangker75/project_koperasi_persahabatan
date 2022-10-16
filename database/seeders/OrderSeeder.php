<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 50; $i++) { 
          $d = str_pad((string)rand(1,28), 2, "0", STR_PAD_LEFT); 
          $m = str_pad((string)rand(8,10), 2, "0", STR_PAD_LEFT); 

          $order = Order::create([
            'status_id' => 6,
            'store_id' => 2,
            'employee_onduty_id' => rand(1,10),
            'order_date' => '2022/' . $m . "/" . $d
          ]);
          
          $countItem = rand(1,6);
          $subtotal = 0;

          for ($j=0; $j < $countItem; $j++) { 
            $productInItem = $product = Product::find(rand(1,15));
            $qty = rand(1,5);
            $orderItem = OrderDetail::create([
              'order_id' => $order->id,
              'product_name' => $productInItem->name,
              'price' => $productInItem->activePrice()->latest()->first()->revenue,
              'qty' => $qty,
              'subtotal' => (int) $productInItem->activePrice()->latest()->first()->revenue * $qty
            ]);

            $subtotal += $orderItem->subtotal;
          }
          $order->subtotal = $subtotal;
          $order->total = $subtotal;
          $order->save();

          Transaction::create([
            'order_id' => $order->id,
            'amount' => $order->total,
            'status_transaction_id' => 6,
            'is_paid' => true,
            'requester_employee_id' => rand(1,10),
            'transaction_date' => '2022/' . $m . "/" . $d
          ]);
        }
    }
}

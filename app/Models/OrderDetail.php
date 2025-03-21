<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'order_id','product_name', 'price', 'qty', 'discount', 'subtotal'
    ];

    public function Order(){
      return $this->belongsTo(Order::class, 'order_id');
    }
}

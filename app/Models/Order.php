<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'order_code', 'order_date', 'is_paylater',
      'subtotal', 'tax', 'total', 
      'cash', 'exchange', 'transaction_id', 'status_id'
    ];
}

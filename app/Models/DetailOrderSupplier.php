<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailOrderSupplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'order_supplier_id', 'product_id', 'send_qty',
      'receive_qty', 'reject_qty'
    ];
    
}

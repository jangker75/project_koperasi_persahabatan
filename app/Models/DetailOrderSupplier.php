<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailOrderSupplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'order_supplier_id', 'product_id', 'request_qty', 'available_qty', 'receive_qty'
    ];

    public function orderSupplier(){
      return $this->belongsTo(OrderSupplier::class, 'order_supplier_id');
    }

    public function product(){
      return $this->belongsTo(Product::class, "product_id");
    }
    
}

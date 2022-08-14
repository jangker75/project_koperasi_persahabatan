<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransferStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'transfer_stock_id', 'product_id', 'request_qty', 'available_qty', 'receive_qty'
    ];

    public function transferStock(){
      return $this->belongsTo(TransferStock::class, 'transfer_stock_id');
    }

    public function product(){
      return $this->belongsTo(Product::class, "product_id");
    }
}

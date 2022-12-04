<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnSupplierDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'return_supplier_id', 'product_id', 'product_name','product_sku', 'qty', 'description'
    ];

    public function returnSupplier(){
      return $this->belongsTo(ReturnSupplier::class, 'return_supplier_id');
    }
}

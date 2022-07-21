<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'product_id', 'store_id', 'qty'
    ];

    public function Product(){
      return $this->belongsTo(Product::class, 'product_id');
    }

    public function Store(){
      return $this->belongsTo(Store::class, 'store_id');
    }
    
}

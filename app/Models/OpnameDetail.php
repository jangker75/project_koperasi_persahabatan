<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpnameDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'opname_id', 'product_id', 'quantity','type' , 'description', 'price', 'amount', 'is_expired', 'is_returned'
    ];

    public function opname(){
      return $this->belongsTo(Opname::class, 'opname_id');
    }

    public function product(){
      return $this->belongsTo(Product::class, 'product_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'name', 'description', 'cover', 'status'
    ];

    public function Products(){
      return $this->belongsToMany(Product::class, 'category_has_product','category_id', 'product_id' );
    }
}

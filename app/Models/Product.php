<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'name', 'slug', 'sku', 'upc', 'description', 'unit_measurement', 'cover', 'brand_id'
    ];

    public function Categories(){
      return $this->belongsToMany(Category::class, 'category_has_product','product_id','category_id');
    }
}

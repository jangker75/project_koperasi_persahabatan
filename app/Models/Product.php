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

    public function categories(){
      return $this->belongsToMany(Category::class, 'category_has_product','product_id','category_id');
    }

    public function suppliers(){
      return $this->belongsToMany(Supplier::class, 'supplier_has_product','product_id','supplier_id');
    }

    public function brand(){
      return $this->belongsTo(Brand::class);
    }

    public function price(){
      return $this->hasMany(Price::class);
    }

    public function stock(){
      return $this->hasMany(Stock::class);
    }

    public function activePrice(){
      return $this->price()->where("is_active", "=", "1");
    }
}

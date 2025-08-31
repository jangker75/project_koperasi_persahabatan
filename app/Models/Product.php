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

    // Get the stock for the product in a specific store.
    public function stockInStore($storeId)
    {
        return $this->stock()->where('store_id', $storeId);
    }

    /**
     * Get the total stock quantity for the product across all stores.
     *
     * @return int
     */
    public function totalStock(): int
    {
        // Sum the 'quantity' column from all related stock records.
        // If there are no stock records, sum() will return 0, which is appropriate.
        return $this->stock()->sum('qty');
    }
}

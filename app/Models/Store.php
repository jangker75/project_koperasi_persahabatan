<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'name', 'store_code', 'location', 'image', 'manager_id'
    ];

    public function Manager(){
      return $this->belongsTo(Employee::class, 'manager_id');
    }
}

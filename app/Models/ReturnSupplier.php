<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnSupplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'return_supplier_code','store_id', 'submit_employee_id', 'note'
    ];

    public function details(){
      return $this->hasMany(ReturnSupplierDetail::class);
    }

    public function employee(){
      return $this->belongsTo(Employee::class, "submit_employee_id");
    }
}

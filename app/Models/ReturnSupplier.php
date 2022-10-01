<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnSupplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'return_supplier_code', 'submit_employee_id', 'supplier_id', 
      'note', 'status_return_id', 'status_ticket_id', 'order_supplier_id'
    ];
}

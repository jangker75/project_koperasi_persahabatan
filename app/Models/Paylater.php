<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paylater extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'order_id', 'employee_id', 'total', 'req_date',
      'paid_date', 'status_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'order_code', 'order_date', 'discount',
      'subtotal', 'total', 'employee_onduty_id',
      'status_id'
    ];

    public function detail(){
      return $this->hasMany(OrderDetail::class);
    }

    public function status(){
      return $this->belongsTo(MasterDataStatus::class, 'status_id');
    }
    public function employeeOnduty(){
      return $this->belongsTo(Employee::class, 'employee_onduty_id');
    }
}

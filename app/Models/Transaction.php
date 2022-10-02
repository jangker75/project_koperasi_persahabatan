<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'order_id', 'amount', 'is_paylater',
      'status_transaction_id', 'status_paylater_id', 'transaction_date',
      'type', 'payment_method_id',  'payment_code', 'requester_employee_id',
      'is_delivery', 'delivery_fee', 'is_paid', 'approval_employee_id', 
      'request_date', 'approve_date', 'evidance', 'cash', 'change'
    ];
    
    public function requester(){
      return $this->belongsTo(Employee::class, 'requester_employee_id');
    }

    public function statusPaylater(){
      return $this->belongsTo(MasterDataStatus::class, "status_paylater_id");
    }

    public function statusTransaction(){
      return $this->belongsTo(MasterDataStatus::class, 'status_transaction_id');
    }
}

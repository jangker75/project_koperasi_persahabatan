<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
      'order_id', 'amount', 'is_paylater',
      'status_transaction_id', 'status_paylater_id', 'transaction_date',
      'type', 'payment_method_id',  'payment_code', 'requester_employee_id',
      'approval_employee_id', 'request_date', 'approve_date', 'evidance'
    ];
    
    public function requester(){
      return $this->belongsTo(Employee::class, 'requester_employee_id');
    }
}

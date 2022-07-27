<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBalanceHistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'balance_id', 'balance_type', 'transaction_type','description',
        'transaction_date','amount', 'balance_before', 'balance_after',
    ];
    public function scopeLoanBalance($query)
    {
        return $query->where('transaction_type', 'loan_balance');
    }
}

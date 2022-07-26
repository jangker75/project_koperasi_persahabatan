<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanHistory extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'loan_id',
        'transaction_type',
        'transaction_date',
        'total_payment',
        'interest_amount',
        'loan_amount_before',
        'loan_amount_after',
        'profit_company_amount',
        'profit_employee_amount',
        'description',
    ];
    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'id');
    }
}

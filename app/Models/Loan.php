<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'employee_id', 'total_loan_amount', 'remaining_amount',
        'received_amount', 'contract_type_id', 'transaction_number',
        'loan_date', 'interest_amount', 'interest_amount_type',
        'interest_scheme_type_id', 'profit_company_ratio',
        'profit_employee_ratio', 'total_pay_month', 'pay_per_x_month',
        'first_payment_date', 'notes', 'loan_approval_status_id',
        'response_date', 'response_user', 'admin_fee', 'created_by'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function loanhistory()
    {
        return $this->hasMany(LoanHistory::class, 'loan_id', 'id');
    }
    public function contracttype()
    {
        return $this->hasOne(ContractType::class, 'id', 'contract_type_id');
    }
    public function approvalstatus()
    {
        return $this->hasOne(MasterDataStatus::class, 'id','loan_approval_status_id');
    }
    public function interestscheme()
    {
        return $this->hasOne(InterestSchemeType::class, 'id', 'interest_scheme_type_id');
    }
}

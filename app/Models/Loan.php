<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'employee_id', 'total_loan_amount', 'remaining_amount',
        'received_amount', 'contract_type_id', 'transaction_number',
        'loan_date', 'interest_amount', 'interest_amount_yearly', 'interest_amount_type',
        'interest_scheme_type_id', 'profit_company_ratio',
        'profit_employee_ratio', 'total_pay_month', 'pay_per_x_month',
        'first_payment_date', 'notes', 'loan_approval_status_id','is_lunas',
        'response_date', 'response_user', 'admin_fee', 'created_by',
        'attachment', 'is_pelunasan_manual'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id','created_by');
    }
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

    public function getPaymentTenorAttribute()
    {
        $tenor = $this->total_loan_amount / $this->total_pay_month;
        return $tenor;
    }

    public function getActualInterestAmountAttribute()
    {
        $interest_amount = ($this->interest_amount_type == 'percentage') 
        ? $this->interest_amount / 100 * (
            ($this->interest_scheme_type_id == 1) 
            ? $this->total_loan_amount  
            : $this->remaining_amount 
            )
        : $this->interest_amount;
        return $interest_amount;
    }
    public function getFirstPaymentAmountAttribute()
    {
        $interest_amount = ($this->interest_amount_type == 'percentage') 
        ? $this->interest_amount / 100 * ($this->total_loan_amount)
        : $this->interest_amount;
        $totalFirstPayment = $this->payment_tenor + $interest_amount;
        return $totalFirstPayment;
    }

    public function getLastPeriodAttribute()
    {
        $a = Carbon::parse($this->first_payment_date)->addMonth($this->total_pay_month * $this->pay_per_x_month)->subMonth()->format('Y-m-d');
        return $a;
    }

    public function scopeWaitingApproval($query)
    {
        return $query->whereHas('approvalstatus', function($q){
            $q->statusLoanApproval()->where('name', 'Waiting');
        });
    }
    public function scopeApproved($query)
    {
        return $query->whereHas('approvalstatus', function($q){
            $q->statusLoanApproval()->where('name', 'Approved');
        });
    }
    public function scopeRejected($query)
    {
        return $query->whereHas('approvalstatus', function($q){
            $q->statusLoanApproval()->where('name', 'Rejected');
        });
    }
}

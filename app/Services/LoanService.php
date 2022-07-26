<?php
namespace App\Services;

use App\Models\Loan;

class LoanService{

    public function createLoanHistory($LoanId, $interest_amount = 0)
    {
        $loan = Loan::findOrFail($LoanId);
        $interest_amount = ($loan->interest_amount_type == 'percentage') ? $loan->interest_amount / 100 * $loan->total_loan_amount : $loan->interest_amount;
        $loan->loanhistory()->create([
            'transaction_type' => 'credit',
            'transaction_date' => now(),
            'total_payment' => $loan->total_loan_amount,
            'interest_amount' => $interest_amount,
            'loan_amount_before' => 0,
            'loan_amount_after' => $loan->total_loan_amount,
            'profit_company_amount' => $loan->profit_company_ratio / 100 * $interest_amount,
            'profit_employee_amount' => $loan->profit_employee_ratio / 100 * $interest_amount,
        ]);
    }
}
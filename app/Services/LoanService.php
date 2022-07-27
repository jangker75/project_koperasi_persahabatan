<?php

namespace App\Services;

use App\Models\Loan;

class LoanService
{

    public function createLoanHistory($LoanId, $value, $interest_amount = 0)
    {
        $loan = Loan::findOrFail($LoanId);
        $interest_amount = ($loan->interest_amount_type == 'percentage') ? $loan->interest_amount / 100 * $loan->total_loan_amount : $loan->interest_amount;
        $profitEmployee = $loan->profit_employee_ratio / 100 * $interest_amount;
        $profitCompany = $loan->profit_company_ratio / 100 * $interest_amount;
        $loan->loanhistory()->create([
            'transaction_type' => 'credit',
            'transaction_date' => now(),
            'total_payment' => $value,
            'interest_amount' => $interest_amount,
            'loan_amount_before' => $loan->remaining_amount,
            'loan_amount_after' => $loan->remaining_amount - $value,
            'profit_company_amount' => $profitCompany,
            'profit_employee_amount' => $profitEmployee,
        ]);
        (new CompanyService())->addCreditBalance($profitCompany, 'loan_balance');
        (new EmployeeService())->addCreditBalance($loan->employee->savings->id, $profitEmployee, 'activity_savings_balance');
    }
}

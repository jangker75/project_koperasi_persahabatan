<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\LoanHistory;
use Carbon\Carbon;

class LoanService
{
    protected $profitCompany;
    protected $profitEmployee;
    
    public function addDebitLoanHistory($loanId, $value, $description)
    {
        $loan = Loan::findOrFail($loanId);
        $this->saveToLoanHistory('debit', $loan, $value, $description);
        (new CompanyService())->addCreditBalance($this->profitCompany, 'loan_balance', $description);
        (new EmployeeService())->addCreditBalance($loan->employee->savings->id, $this->profitEmployee, 'activity_savings_balance', $description);
    }

    public function addCreditLoanHistory($loanId, $value, $description)
    {
        $loan = Loan::findOrFail($loanId);
        $this->saveToLoanHistory('credit', $loan, $value, $description);
        (new CompanyService())->addDebitBalance($this->profitCompany, 'loan_balance');
        (new EmployeeService())->addDebitBalance($loan->employee->savings->id, $this->profitEmployee, 'activity_savings_balance');
    }

    public function fullPayment($loanId, $description = '')
    {
        $loan = Loan::findOrFail($loanId);
        $loan->loanhistory()->create([
            'transaction_type' => 'debit',
            'transaction_date' => now(),
            'total_payment' => $loan->remaining_amount,
            'interest_amount' => 0,
            'loan_amount_before' => $loan->remaining_amount,
            'loan_amount_after' => $loan->remaining_amount - $loan->remaining_amount,
            'profit_company_amount' => 0,
            'profit_employee_amount' => 0,
            'description' => "Pelunasan Oleh Nasabah (Notes Pelunasan : ${description})",
        ]);
        $loan->update([
            'is_pelunasan_manual' => 1,
            'is_lunas' => 1,
            'remaining_amount' => $loan->remaining_amount - $loan->remaining_amount,
            'notes' => $loan->notes. " (Notes Pelunasan : ${description})",
        ]);
    }
    
    public function somePayment($loanId, $value, $description = '')
    {
        $loan = Loan::findOrFail($loanId);
        $userResponsible = auth()->user()->employee->full_name;
        $loan->loanhistory()->create([
            'transaction_type' => 'credit',
            'transaction_date' => now(),
            'total_payment' => $value,
            'interest_amount' => 0,
            'loan_amount_before' => $loan->remaining_amount,
            'loan_amount_after' => $loan->remaining_amount + $value,
            'profit_company_amount' => 0,
            'profit_employee_amount' => 0,
            'description' => "Revisi pembayaran oleh ${userResponsible}. (Notes : ${description})",
        ]);
        $loan->update([
            'remaining_amount' => $loan->remaining_amount + $value,
        ]);
    }

    protected function saveToLoanHistory($debitOrCredit, $loan, $value, $description){
        // $interest_amount = ($loan->interest_amount_type == 'percentage') 
        // ? $loan->interest_amount / 100 * (
        //     ($loan->interest_scheme_type_id == 1) 
        //     ? $loan->total_loan_amount  
        //     : $loan->remaining_amount 
        //     )
        // : $loan->interest_amount;
        $interest_amount = $loan->actual_interest_amount;
        $this->profitEmployee = $loan->profit_employee_ratio / 100 * $interest_amount;
        $this->profitCompany = $loan->profit_company_ratio / 100 * $interest_amount;
        
        $total_payment = $value - $interest_amount; //Total payment = allpayment - interest
        $loan->loanhistory()->create([
            'transaction_type' => $debitOrCredit,
            'transaction_date' => now(),
            'total_payment' => $total_payment,
            'interest_amount' => $interest_amount,
            'loan_amount_before' => $loan->remaining_amount,
            'loan_amount_after' => ($debitOrCredit == 'credit') 
                                    ? $loan->remaining_amount + $total_payment
                                    : $loan->remaining_amount - $total_payment,
            'profit_company_amount' => $this->profitCompany,
            'profit_employee_amount' => $this->profitEmployee,
            'description' => $description,
        ]);
    }

    public function runMonthlyPaymentLoan()
    {
        
        $loans = Loan::with('approvalstatus')
        ->approved()
        ->where('is_lunas', 0)
        ->get();
        $countLunas = 0;
        $loanNumber = [];
        $sisaPembulatan = 50;   /**Variable untuk pembulatan pembayaran jika sisa pembayaran dibawah 
        nilai ini maka akan lgsg dilunasi
        **/
        foreach ($loans as $loan) {
            //Get Cicilan ke-#
            $payNumber = (LoanHistory::where('loan_id', $loan->id)
            ->where('transaction_type','debit')->count()) + 1;

            $notes = __('loan.notes_monthly_payment', [
                'month' => now()->subMonth()->format('M'),
                'year' => now()->locale('id')->format('Y'),
                'transaction_number' => $loan->transaction_number. " Cicilan ke-${payNumber}",
            ]);
            
            $value = (($loan->remaining_amount <= ($loan->payment_tenor + $sisaPembulatan))
                                                        ? $loan->remaining_amount
                                                        : $loan->payment_tenor);
            
            //add debit loan history
            $total_payment = $value + $loan->actual_interest_amount;
            $this->addDebitLoanHistory(
                loanId: $loan->id, 
                value: $total_payment, 
                description: $notes
            );
            
            
            //Update remaining amount
            $loan->update([
                'remaining_amount' => $loan->remaining_amount - $value,
            ]);

            //update "Lunas" if remaining amount <= 100
            if ($loan->remaining_amount <= 100) {
                $loan->update([
                    'is_lunas' => 1,
                ]);
                $countLunas += 1;
                //add to loan number for result
                array_push($loanNumber, (string)$loan->transaction_number." Cicilan ke-${payNumber} (Lunas)");
            }else{
                //add to loan number for result
                array_push($loanNumber, (string)$loan->transaction_number. " Cicilan ke-${payNumber}");
            }

            
        }
        $result['count'] = $loans->count();
        $result['countLunas'] = $countLunas;
        $result['loans'] = $loanNumber;
        
        return $result;
    }
}

<?php
namespace App\Services;

use App\Models\CompanyBalance;
use App\Models\CompanyBalanceHistory;
class CompanyService {
    public function addDebitBalance($value, $balance_type, $description = '')
    {
        $this->saveToHistoryBalance(
            debitOrCredit: "debit",
            value: $value,
            balance_type: $balance_type,
            description: $description);
    }

    public function addCreditBalance($value, $balance_type, $description = '')
    {
        $this->saveToHistoryBalance(
            debitOrCredit: 'credit',
            value: $value,
            balance_type: $balance_type,
            description: $description);
    }

    protected function saveToHistoryBalance($debitOrCredit ,$value, $balance_type, $description = ''){
        $companyBalance = CompanyBalance::findOrFail(1);
        $savedHistory = CompanyBalanceHistory::create([
            'balance_id' => $companyBalance->id,
            'balance_type' => $balance_type,
            'transaction_type' => $debitOrCredit,
            'transaction_date' => now(),
            'amount' => $value,
            'balance_before' => $companyBalance->{$balance_type},
            'balance_after' => ($debitOrCredit == 'debit') 
                            ? (string) ($companyBalance->{$balance_type} - $value)
                            : (string) ($companyBalance->{$balance_type} + $value),
            'description' => $description,
        ]);
        $cek['companyBalance'] = $companyBalance;
        $companyBalance->update([
            "{$balance_type}" => $savedHistory->balance_after,
            // "total_balance" => $savedHistory->balance_after,
        ]);
        $this->calculateTotalBalance();

    }
    protected function calculateTotalBalance(){
        $companyBalance = CompanyBalance::findOrFail(1);   
        $total = $companyBalance->loan_balance + $companyBalance->store_balance + $companyBalance->other_balance ;
            $companyBalance->update([
                'total_balance' => (string) $total
            ]);
    }
}
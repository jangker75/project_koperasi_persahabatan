<?php
namespace App\Services;

use App\Models\CompanyBalance;
use App\Models\CompanyBalanceHistory;

class CompanyService {
    public function addDebitBalance($value, $balance_type, $description = '')
    {
        $this->saveToHistoryBalance(
            debitOrCredit: 'debit', 
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
                            ? $companyBalance->{$balance_type} - $value 
                            : $companyBalance->{$balance_type} + $value,
            'description' => $description,
        ]);
        $companyBalance->update([
            "{$balance_type}" => $savedHistory->balance_after,
            "total_balance" => $savedHistory->balance_after,
        ]);
    }
}
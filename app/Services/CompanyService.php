<?php
namespace App\Services;

use App\Models\CompanyBalance;
use App\Models\CompanyBalanceHistory;

class CompanyService {
    public function addDebitBalance($balance_id, $value, $balance_type, $description = '')
    {
        $companyBalance = CompanyBalance::findOrFail($balance_id);
        $savedHistory = CompanyBalanceHistory::create([
            'balance_id' => $companyBalance->id,
            'balance_type' => $balance_type,
            'transaction_type' => 'debit',
            'transaction_date' => now(),
            'amount' => $value,
            'balance_before' => $companyBalance->{$balance_type},
            'balance_after' => $companyBalance->{$balance_type} - $value,
            'description' => $description,
        ]);
        $companyBalance->update([
            "{$balance_type}" => $savedHistory->balance_after
        ]);
    }
    public function addCreditBalance($balance_id, $value, $balance_type, $description = '')
    {
        $companyBalance = CompanyBalance::findOrFail($balance_id);
        $savedHistory = CompanyBalanceHistory::create([
            'balance_id' => $companyBalance->id,
            'balance_type' => $balance_type,
            'transaction_type' => 'credit',
            'transaction_date' => now(),
            'amount' => $value,
            'balance_before' => $companyBalance->{$balance_type},
            'balance_after' => $companyBalance->{$balance_type} + $value,
            'description' => $description,
        ]);
        $companyBalance->update([
            "{$balance_type}" => $savedHistory->balance_after
        ]);
    }
}
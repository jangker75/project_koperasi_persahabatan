<?php
namespace App\Services;

use App\Models\SavingHistory;
use App\Models\Savings;

class EmployeeService {
    public function addDebitBalance($saving_id, $value, $saving_type)
    {
        $saving = Savings::findOrFail($saving_id);
        $savedHistory = SavingHistory::create([
            'saving_id' => $saving_id,
            'saving_type' => $saving_type,
            'transaction_type' => 'debit',
            'amount' => $value,
            'balance_before' => $saving->{$saving_type},
            'balance_after' => $saving->{$saving_type} - $value,
            'transaction_date' => now()
        ]);
        $saving->update([
            "{$saving_type}" => $savedHistory->balance_after
        ]);
    }
    public function addCreditBalance($saving_id, $value, $saving_type)
    {
        $saving = Savings::findOrFail($saving_id);
        $savedHistory = SavingHistory::create([
            'saving_id' => $saving_id,
            'saving_type' => $saving_type,
            'transaction_type' => 'credit',
            'amount' => $value,
            'balance_before' => $saving->{$saving_type},
            'balance_after' => $saving->{$saving_type} + $value,
            'transaction_date' => now()
        ]);
        $saving->update([
            "{$saving_type}" => $savedHistory->balance_after
        ]);
    }
}
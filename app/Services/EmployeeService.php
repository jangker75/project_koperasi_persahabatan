<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\SavingHistory;
use App\Models\Savings;

class EmployeeService {
    public function addDebitBalance($saving_id, $value, $saving_type, $description = '')
    {
        $this->saveToHistorySavings('debit', $saving_id, $value, $saving_type, $description);
    }

    public function addCreditBalance($saving_id, $value, $saving_type, $description = '')
    {
        $this->saveToHistorySavings('credit', $saving_id, $value, $saving_type, $description);
    }

    protected function saveToHistorySavings($debitOrCredit, $saving_id, $value, $saving_type, $description){
        $saving = Savings::findOrFail($saving_id);
        $savedHistory = SavingHistory::create([
            'saving_id' => $saving_id,
            'saving_type' => $saving_type,
            'transaction_type' => $debitOrCredit,
            'amount' => $value,
            'balance_before' => $saving->{$saving_type},
            'balance_after' => ($debitOrCredit == 'debit')
                            ? (string) ($saving->{$saving_type} - $value)
                            : (string)($saving->{$saving_type} + $value),
            'transaction_date' => now(),
            'description' => $description,
        ]);
        $saving->update([
            "{$saving_type}" => $savedHistory->balance_after
        ]);
    }

    public function checkDataProfile($employeeId){
        $employee = Employee::findOrFail($employeeId);
        $colEmpl = array_diff(getTableColumn('employees'), [
            'id','created_at', 'updated_at','deleted_at'
            ,'resign_date', 'resign_reason','salary','resign_notes']);
        $rtn = [];
        foreach ($colEmpl as $value) {
            if($employee->$value == '' || $employee->$value == null){
                $rtn[$value] = 'Masih kosong';
            }
        }
        return $rtn;
    }
}
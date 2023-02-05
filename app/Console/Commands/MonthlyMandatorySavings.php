<?php

namespace App\Console\Commands;

use App\Models\Savings;
use App\Services\CompanyService;
use App\Services\EmployeeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MonthlyMandatorySavings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kokarda:monthly-pay-mandatory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command untuk bayar wajib iuran bulanan';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $savings = Savings::whereHas('employee', function($q){
            $q->whereNull('employees.resign_date');
            // ->whereIn("employees.id",[]);
        })
        ->get();
        $amount_to_savings = 25000;
        Log::channel("kokardamonthlymandatory")->info("====Start monthly mandatory savings====");
        foreach ($savings as $key => $value) {
            (new EmployeeService())->addCreditBalance(
                saving_id: $value->id,
                value: $amount_to_savings,
                saving_type: 'mandatory_savings_balance',
                description: "Iuran wajib Bulanan"
            );
            // (new CompanyService())->addCreditBalance($amount_to_savings , 'other_balance', "Iuran wajib Bulanan ". $value->employee->full_name);
            Log::channel("kokardamonthlymandatory")->info("Iuran wajib bulanan ".$amount_to_savings." : employee_id=". $value->employee_id);
        }
        $this->info("Success iuran wajib bulanan : ". $savings->count(). " row affected");
        Log::channel("kokardamonthlymandatory")->info("Success iuran wajib bulanan : ". $savings->count(). " row affected");
        Log::channel("kokardamonthlymandatory")->info("====END monthly mandatory savings====");
    }
}

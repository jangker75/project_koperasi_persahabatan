<?php

namespace App\Console\Commands;

use App\Models\Savings;
use App\Services\CompanyService;
use App\Services\EmployeeService;
use Illuminate\Console\Command;

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
            $q->whereNull('resign_date');
        })
        ->get();
        $amount_to_savings = 25000;
        foreach ($savings as $key => $value) {
            (new EmployeeService())->addCreditBalance(
                saving_id: $value->id,
                value: $amount_to_savings,
                saving_type: 'mandatory_savings_balance',
                description: "Iuran wajib Bulanan"
            );
            (new CompanyService())->addCreditBalance($amount_to_savings , 'other_balance', "Iuran wajib Bulanan ". $value->employee->full_name);
        }
        $this->info("Success iuran wajib bulanan : ". $savings->count(). " row affected");
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Savings;
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
        foreach ($savings as $key => $value) {
            (new EmployeeService())->addCreditBalance(
                saving_id: $value->id,
                value: 25000,
                saving_type: 'mandatory_savings_balance',
                description: "Iuran wajib Bulanan"
            );
        }
        $this->info("Success iuran wajib bulanan : ". $savings->count(). " row affected");
    }
}

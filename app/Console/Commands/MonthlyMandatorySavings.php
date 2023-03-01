<?php

namespace App\Console\Commands;

use App\Models\Savings;
use App\Services\CompanyService;
use App\Services\EmployeeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
        $today = now()->format("Y-m-d");
        
        $tod = $today. "%";
        $savingsHistories = DB::table('saving_histories')
        ->where('transaction_date', 'like', $tod)
        ->where('saving_type', 'mandatory_savings_balance')
        ->whereNull('deleted_at')
        ->pluck('saving_id');
        
        if($savingsHistories->count() > 0){
            $savings = Savings::join('employees', 'savings.employee_id', '=','employees.id')
            ->whereNull('employees.resign_date')
            ->whereNotIn("savings.id", $savingsHistories->toArray())
            // ->whereNotIn('savings.id',$savingsHistories->toArray())
            ->get(["savings.*"]);
        }else{
            $savings = Savings::whereHas('employee', function($q){
                $q->whereNull('employees.resign_date');
            // ->whereIn("employees.id",[
            // ]);
            // ->where("employees.id", ">",656);
            });
        }
        // dd($savings[0]);
        $amount_to_savings = 25000;
        if($savings->count() <= 0){
            Log::channel("kokardamonthlymandatory")->info("====Data Iuran already added====");
            $this->info("Success iuran wajib bulanan : 0 row affected");
        }else{
            Log::channel("kokardamonthlymandatory")->info("====Start monthly mandatory savings====");
            $total = 0;
            foreach ($savings as $key => $value) {
                $total++;
                (new EmployeeService())->addCreditBalance(
                    saving_id: $value->id,
                    value: $amount_to_savings,
                    saving_type: 'mandatory_savings_balance',
                    description: "Iuran wajib Bulanan"
                );
                // (new CompanyService())->addCreditBalance($amount_to_savings , 'other_balance', "Iuran wajib Bulanan ". $value->employee->full_name);
                Log::channel("kokardamonthlymandatory")->info("Iuran wajib bulanan ".$amount_to_savings." : employee_id=". $value->employee_id);
            }
            $this->info("Success iuran wajib bulanan : ". $total. " row affected");
            Log::channel("kokardamonthlymandatory")->info("Success iuran wajib bulanan : ". $total. " row affected");
            Log::channel("kokardamonthlymandatory")->info("====END monthly mandatory savings====");
        }
        
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\CompanyService;
use Illuminate\Console\Command;

class PaidPaylaterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kokarda:paylater-paid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'paid all paylater in the end of month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $transaction = Transaction::where('is_paylater', true)
                ->where('status_paylater_id', 9)
                ->where('is_paid', '!=', true)->sum('amount');
        if($transaction > 0){
          Transaction::where('is_paylater', true)
                  ->where('status_paylater_id', 9)
                  ->update(['is_paid' => true]);
          (new CompanyService())->addCreditBalance($transaction, 'store_balance', 'paylater');
        }
    }
}

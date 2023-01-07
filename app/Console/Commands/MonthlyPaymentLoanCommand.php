<?php

namespace App\Console\Commands;

use App\Services\LoanService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MonthlyPaymentLoanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kokarda:monthly-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command untuk menjalankan pembayaran bulanan semua pinjaman';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = collect((new LoanService())->runMonthlyPaymentLoan());
        Log::channel("kokardamonthlyloan")->info("====Start monthly payment loan====");
        if($result['count'] != 0){
            $this->info("Total Pinjaman : " . $result['count']);
            $this->info("Total Pinjaman (Lunas) : " . $result['countLunas']);
            foreach ($result['loans'] as $key => $loan) {
                $this->info($key + 1 . ". Pembayaran nomor kontrak berhasil : ". $loan);
                Log::channel("kokardamonthlyloan")->info($key + 1 . ". Pembayaran nomor kontrak berhasil : ". $loan);
            }
        }
        else{
            $this->info('Tidak ada pinjaman yg dibayar');
            Log::channel("kokardamonthlyloan")->info('Tidak ada pinjaman yg dibayar');
        }
        Log::channel("kokardamonthlyloan")->info("====END monthly payment loan====");
    }
}

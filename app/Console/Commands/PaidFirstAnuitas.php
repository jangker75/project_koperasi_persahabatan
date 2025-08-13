<?php

namespace App\Console\Commands;

use App\Services\LoanService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PaidFirstAnuitas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kokarda:paid-first-anuitas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Paid all first anuitas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = collect((new LoanService())->runMonthlyPaymentAnuitasCustom());
        Log::channel("kokardapaidfirstanuitas")->info("====Start monthly payment loan====");
        if($result['count'] != 0){
            $this->info("Total Pinjaman : " . $result['count']);
            $this->info("Total Pinjaman (Lunas) : " . $result['countLunas']);
            foreach ($result['loans'] as $key => $loan) {
                $this->info($key + 1 . ". Pembayaran nomor kontrak berhasil : ". $loan);
                Log::channel("kokardapaidfirstanuitas")->info($key + 1 . ". Pembayaran nomor kontrak berhasil : ". $loan);
            }
        }
        else{
            $this->info('Tidak ada pinjaman yg dibayar');
            Log::channel("kokardapaidfirstanuitas")->info('Tidak ada pinjaman yg dibayar');
        }
        Log::channel("kokardapaidfirstanuitas")->info("====END monthly payment loan====");
    }
}

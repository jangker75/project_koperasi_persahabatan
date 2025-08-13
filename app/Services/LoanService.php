<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\LoanHistory;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;

class LoanService
{
    protected $profitCompany;
    protected $profitEmployee;
    
    public function addDebitLoanHistory($loanId, $value, $description, $date = null)
    {
        $loan = Loan::findOrFail($loanId);
        $this->saveToLoanHistory('debit', $loan, $value, $description, $date);
        (new CompanyService())->addCreditBalance($this->profitCompany, 'loan_balance', $description);
        (new EmployeeService())->addCreditBalance($loan->employee->savings->id, $this->profitEmployee, 'activity_savings_balance', $description);
    }

    // public function addCreditLoanHistory($loanId, $value, $description)
    // {
    //     $loan = Loan::findOrFail($loanId);
    //     $this->saveToLoanHistory('credit', $loan, $value, $description);
    //     (new CompanyService())->addDebitBalance($this->profitCompany, 'loan_balance');
    //     (new EmployeeService())->addDebitBalance($loan->employee->savings->id, $this->profitEmployee, 'activity_savings_balance');
    // }

    public function fullPayment($loanId, $description = '')
    {
        $loan = Loan::findOrFail($loanId);
        $loan->loanhistory()->create([
            'transaction_type' => 'debit',
            'transaction_date' => now(),
            'total_payment' => $loan->remaining_amount,
            'interest_amount' => 0,
            'loan_amount_before' => $loan->remaining_amount,
            'loan_amount_after' => $loan->remaining_amount - $loan->remaining_amount,
            'profit_company_amount' => 0,
            'profit_employee_amount' => 0,
            'description' => "Pelunasan Oleh Nasabah (Notes Pelunasan : ${description})",
        ]);
        $loan->update([
            'is_pelunasan_manual' => 1,
            'is_lunas' => 1,
            'remaining_amount' => $loan->remaining_amount - $loan->remaining_amount,
            'notes' => $loan->notes. " (Notes Pelunasan : ${description})",
        ]);
    }
    
    public function somePayment($loanId, $value, $description = '')
    {
        $loan = Loan::findOrFail($loanId);
        $userResponsible = auth()->user()->employee->full_name;
        $loan->loanhistory()->create([
            'transaction_type' => 'credit',
            'transaction_date' => now(),
            'total_payment' => $value,
            'interest_amount' => 0,
            'loan_amount_before' => $loan->remaining_amount,
            'loan_amount_after' => $loan->remaining_amount + $value,
            'profit_company_amount' => 0,
            'profit_employee_amount' => 0,
            'description' => "Revisi pembayaran oleh ${userResponsible}. (Notes : ${description})",
        ]);
        $loan->update([
            'remaining_amount' => $loan->remaining_amount + $value,
        ]);
    }

    protected function saveToLoanHistory($debitOrCredit, $loan, $value, $description, $date = null){
        // $interest_amount = ($loan->interest_amount_type == 'percentage') 
        // ? $loan->interest_amount / 100 * (
        //     ($loan->interest_scheme_type_id == 1) 
        //     ? $loan->total_loan_amount  
        //     : $loan->remaining_amount 
        //     )
        // : $loan->interest_amount;
        if($loan->interest_scheme_type_id == 3){ //anuitas
            $interest_amount = $this->hitungAngsuranAnuitas(
                $loan->total_loan_amount,
                $loan->interest_amount_yearly,
                $loan->total_pay_month,
                $loan->loan_date,
                $date ? Carbon::parse($date) : null
            );

            //add debit loan history
            $interest_amount = round($interest_amount['bunga']);
        }else{
            $interest_amount = $loan->actual_interest_amount;
        }

        $this->profitEmployee = $loan->profit_employee_ratio / 100 * $interest_amount;
        $this->profitCompany = $loan->profit_company_ratio / 100 * $interest_amount;
        
        $total_payment = $value - $interest_amount; //Total payment = allpayment - interest
        $loan->loanhistory()->create([
            'transaction_type' => $debitOrCredit,
            'transaction_date' => $date ? $date : now(),
            'total_payment' => $total_payment,
            'interest_amount' => $interest_amount,
            'loan_amount_before' => $loan->remaining_amount,
            'loan_amount_after' => ($debitOrCredit == 'credit') 
                                    ? $loan->remaining_amount + $total_payment
                                    : $loan->remaining_amount - $total_payment,
            'profit_company_amount' => $this->profitCompany,
            'profit_employee_amount' => $this->profitEmployee,
            'description' => $description,
        ]);
    }

    public function runMonthlyPaymentLoan()
    {
        
        $loans = Loan::with('approvalstatus')
        ->approved()
        ->where('is_lunas', 0)
        ->get();
        $countLunas = 0;
        $loanNumber = [];
        $sisaPembulatan = 50;   /**Variable untuk pembulatan pembayaran jika sisa pembayaran dibawah 
        nilai ini maka akan lgsg dilunasi
        **/
        foreach ($loans as $loan) {
            //Get Cicilan ke-#
            $payNumber = (LoanHistory::where('loan_id', $loan->id)
            ->where('transaction_type','debit')->count()) + 1;
            if(now()->subMonth()->format('M') == "Dec"){
                $year = now()->subMonth()->locale('id')->format('Y');
            }else{
                $year = now()->locale('id')->format('Y');
            }
            $notes = __('loan.notes_monthly_payment', [
                'month' => now()->subMonth()->format('M'),
                'year' => $year,
                'transaction_number' => $loan->transaction_number. " Cicilan ke-${payNumber}",
            ]);
            
            if($loan->interest_scheme_type_id == 3){ //anuitas

                $value = $this->hitungAngsuranAnuitas(
                    $loan->total_loan_amount,
                    $loan->interest_amount_yearly,
                    $loan->total_pay_month,
                    $loan->loan_date,
                    Carbon::now()
                );
                //add debit loan history
                $value = round($value['angsuran']);
                $total_payment = $value;
            }else{
                $value = (($loan->remaining_amount <= ($loan->payment_tenor + $sisaPembulatan))
                                                            ? $loan->remaining_amount
                                                            : $loan->payment_tenor);
                //add debit loan history
                $total_payment = $value + $loan->actual_interest_amount;
            }
            
            $this->addDebitLoanHistory(
                loanId: $loan->id, 
                value: $total_payment, 
                description: $notes
            );
            
            
            //Update remaining amount
            $loan->update([
                'remaining_amount' => $loan->remaining_amount - $value,
            ]);

            //update "Lunas" if remaining amount <= 100
            if ($loan->remaining_amount <= 100) {
                $loan->update([
                    'is_lunas' => 1,
                ]);
                $countLunas += 1;
                //add to loan number for result
                array_push($loanNumber, (string)$loan->transaction_number." Cicilan ke-${payNumber} (Lunas)");
            }else{
                //add to loan number for result
                array_push($loanNumber, (string)$loan->transaction_number. " Cicilan ke-${payNumber}");
            }
        }
        $result['count'] = $loans->count();
        $result['countLunas'] = $countLunas;
        $result['loans'] = $loanNumber;
        
        return $result;
    }

    public function runMonthlyPaymentAnuitasCustom()
    {
        
        $loans = Loan::with('approvalstatus')
        ->approved()
        ->where('is_lunas', 0)
        ->where("loans.interest_scheme_type_id","=", 3) //Custom running
        ->get();
        $countLunas = 0;
        $loanNumber = [];
        $sisaPembulatan = 50;   /**Variable untuk pembulatan pembayaran jika sisa pembayaran dibawah 
        nilai ini maka akan lgsg dilunasi
        **/
        foreach ($loans as $loan) {
            $tanggalAwal = Carbon::parse($loan->first_payment_date);
            $tanggalSekarang = Carbon::now();
            $rentang = $this->getTanggalSatuPerBulan($tanggalAwal, $tanggalSekarang);
            Log::channel("kokardapaidfirstanuitas")->info("Rentang tanggal untuk pinjaman : ", $rentang);

            foreach($rentang as $rent) { 
                //Get Cicilan ke-#
                $payNumber = (LoanHistory::where('loan_id', $loan->id)
                ->where('transaction_type','debit')->count()) + 1;
                if(Carbon::parse($rent)->subMonth()->format('M') == "Dec"){
                    $year = Carbon::parse($rent)->subMonth()->locale('id')->format('Y');
                }else{
                    $year = Carbon::parse($rent)->locale('id')->format('Y');
                }
                $notes = __('loan.notes_monthly_payment', [
                    'month' => Carbon::parse($rent)->subMonth()->format('M'),
                    'year' => $year,
                    'transaction_number' => $loan->transaction_number. " Cicilan ke-${payNumber}",
                ]);
                
                if($loan->interest_scheme_type_id == 3){ //anuitas
    
                    $value = $this->hitungAngsuranAnuitas(
                        $loan->total_loan_amount,
                        $loan->interest_amount_yearly,
                        $loan->total_pay_month,
                        $loan->loan_date,
                        Carbon::parse($rent)
                    );
                    //add debit loan history
                    $value = round($value['angsuran']);
                    $total_payment = $value;
                }else{
                    $value = (($loan->remaining_amount <= ($loan->payment_tenor + $sisaPembulatan))
                                                                ? $loan->remaining_amount
                                                                : $loan->payment_tenor);
                    //add debit loan history
                    $total_payment = $value + $loan->actual_interest_amount;
                }
                
                
                $this->addDebitLoanHistory(
                    loanId: $loan->id, 
                    value: $total_payment, 
                    description: $notes,
                    date: $rent
                );
                
                
                //Update remaining amount
                $loan->update([
                    'remaining_amount' => $loan->remaining_amount - $value,
                ]);
    
                //update "Lunas" if remaining amount <= 100
                if ($loan->remaining_amount <= 100) {
                    $loan->update([
                        'is_lunas' => 1,
                    ]);
                    $countLunas += 1;
                    //add to loan number for result
                    array_push($loanNumber, (string)$loan->transaction_number." Cicilan ke-${payNumber} (Lunas)");
                }else{
                    //add to loan number for result
                    array_push($loanNumber, (string)$loan->transaction_number. " Cicilan ke-${payNumber}");
                }
            }
        }
        $result['count'] = $loans->count();
        $result['countLunas'] = $countLunas;
        $result['loans'] = $loanNumber;
        
        return $result;
    }

    // public function calculateLoanSimulation($firstPaymentDate, $totalLoanAmount, $interestType, $interestScheme, $totalPayMonth, $payPerXMonth, $totalInterestAmount, $profitCompanyRatio)
    // {
    //     $totalPrincipalAmount = round($totalLoanAmount / $totalPayMonth);
    //     $currentTotalLoanAmount = $totalLoanAmount;
    //     $totalInterest = 0;
    //     $totalIncome = 0;
    //     $currentInterest = 0;
    //     $result = [];
        
    //     for ($index = 0; $index <= $totalPayMonth; $index++) {
    //         if ($index != 0) {
    //             $currentTotalLoanAmount -= $totalPrincipalAmount;
    //         }
    //         //if last month still have pay under 50 rupiah, then payment will be deducted in last month
    //         if(($currentTotalLoanAmount - $totalPrincipalAmount) <= 50){
    //             $totalPrincipalAmount = $currentTotalLoanAmount;
    //         }
    //         //calculate current interest based on percentage/value and scheme menurun/flat
    //         if ($interestType == 'percentage') {
    //             if ($interestScheme == 'Menurun') {
    //                 $currentInterest = round($currentTotalLoanAmount * $totalInterestAmount / 100);
    //             } else {
    //                 $currentInterest = round($totalLoanAmount * $totalInterestAmount / 100);
    //             }
    //         } else {
    //             $currentInterest = $totalInterestAmount;
    //         }
            
    //         if ($index == $totalPayMonth) {
    //            $currentInterest = $totalPrincipalAmount = 0;
    //         }
    //         //Margin KOP and Employee
    //         $companyPercent = ($profitCompanyRatio / 100);
    //         $employeePercent = ((100 - $profitCompanyRatio) / 100);
    //         $margin_kop = $companyPercent * $currentInterest; 
    //         $margin_employee = $employeePercent * $currentInterest; 
    //         //calculate for row total
    //         $totalInterest += $currentInterest;
    //         $totalIncome = ($totalIncome + $currentInterest + $totalPrincipalAmount);
    //         $tgl_tagih = Carbon::parse($firstPaymentDate)->addMonths($index * $payPerXMonth);
    //         $result["data"][] = [
    //             "cicilan_ke" => $index +1,
    //             "tgl_tagih_raw" => $tgl_tagih,
    //             "tgl_tagih" => format_tanggal_bulan_tahun($tgl_tagih),
    //             "saldo_hutang" => format_uang_no_prefix($currentTotalLoanAmount),
    //             "pokok" => format_uang_no_prefix($totalPrincipalAmount),
    //             "bunga" => format_uang_no_prefix($currentInterest),
    //             "margin_kop" => format_uang_no_prefix($margin_kop),
    //             "margin_employee" => format_uang_no_prefix($margin_employee),
    //             "total_cicilan" => format_uang_no_prefix($currentInterest + $totalPrincipalAmount),
    //         ];
    //     }
    //     $result["lastrow"] = [
    //         "total_bunga" => format_uang_no_prefix($totalInterest),
    //         "total_cicilan" => format_uang_no_prefix($totalIncome)
    //     ];
    //     return $result;
    // }

    public function calculateLoanSimulation($firstPaymentDate, $totalLoanAmount, $interestType, $interestScheme, $totalPayMonth, $payPerXMonth, $totalInterestAmount, $profitCompanyRatio)
    {
        $currentTotalLoanAmount = $totalLoanAmount;
        $totalInterest = 0;
        $totalIncome = 0;
        $currentInterest = 0;
        $result = [];

        // Hitung angsuran tetap jika skema Anuitas
        if (strtolower($interestScheme) == 'anuitas' && $interestType == 'percentage') {
            $monthlyRate = ($totalInterestAmount / 100); // as decimal
            $angsuranTetap = round(
                $totalLoanAmount *
                ($monthlyRate * pow(1 + $monthlyRate, $totalPayMonth)) /
                (pow(1 + $monthlyRate, $totalPayMonth) - 1)
            );
        }

        for ($index = 0; $index <= $totalPayMonth; $index++) {
            // skip row terakhir hanya untuk penutup (semua 0)
            // if ($index == $totalPayMonth) {
            //     $result["data"][] = [
            //         "cicilan_ke" => $index + 1,
            //         "tgl_tagih_raw" => null,
            //         "tgl_tagih" => null,
            //         "saldo_hutang" => format_uang_no_prefix(0),
            //         "pokok" => format_uang_no_prefix(0),
            //         "bunga" => format_uang_no_prefix(0),
            //         "margin_kop" => format_uang_no_prefix(0),
            //         "margin_employee" => format_uang_no_prefix(0),
            //         "total_cicilan" => format_uang_no_prefix(0),
            //     ];
            //     break;
            // }

            $tgl_tagih = Carbon::parse($firstPaymentDate)->addMonths($index * $payPerXMonth);

            if (strtolower($interestScheme) == 'anuitas' && $interestType == 'percentage') {
                // Bunga dihitung dari sisa pinjaman
                $currentInterest = round($currentTotalLoanAmount * $monthlyRate);
                $principalPayment = $angsuranTetap - $currentInterest;
                // Avoid overpay
                if ($principalPayment > $currentTotalLoanAmount) {
                    $principalPayment = $currentTotalLoanAmount;
                }
                $currentTotalLoanAmount -= $principalPayment;
            } else {
                // Skema lain (Flat/Menurun) default behavior
                $principalPayment = round($totalLoanAmount / $totalPayMonth);

                if ($index != 0) {
                    $currentTotalLoanAmount -= $principalPayment;
                }

                if (($currentTotalLoanAmount - $principalPayment) <= 50) {
                    $principalPayment = $currentTotalLoanAmount;
                }

                if ($interestType == 'percentage') {
                    if ($interestScheme == 'Menurun') {
                        $currentInterest = round($currentTotalLoanAmount * $totalInterestAmount / 100);
                    } else {
                        $currentInterest = round($totalLoanAmount * $totalInterestAmount / 100);
                    }
                } else {
                    $currentInterest = $totalInterestAmount;
                }

                if ($index == $totalPayMonth) {
                    $currentInterest = $principalPayment = 0;
                }
            }

            // Margin KOP and Employee
            $companyPercent = ($profitCompanyRatio / 100);
            $employeePercent = ((100 - $profitCompanyRatio) / 100);
            $margin_kop = $companyPercent * $currentInterest;
            $margin_employee = $employeePercent * $currentInterest;

            $totalInterest += $currentInterest;
            $totalIncome += $currentInterest + $principalPayment;

            if(($principalPayment + $currentInterest) > 0){
                $result["data"][] = [
                    "cicilan_ke" => $index + 1,
                    "tgl_tagih_raw" => $tgl_tagih,
                    "tgl_tagih" => format_tanggal_bulan_tahun($tgl_tagih),
                    "saldo_hutang" => format_uang_no_prefix($currentTotalLoanAmount),
                    "pokok" => format_uang_no_prefix($principalPayment),
                    "bunga" => format_uang_no_prefix($currentInterest),
                    "margin_kop" => format_uang_no_prefix($margin_kop),
                    "margin_employee" => format_uang_no_prefix($margin_employee),
                    "total_cicilan" => format_uang_no_prefix($principalPayment + $currentInterest),
                ];
            }
        }

        $result["lastrow"] = [
            "total_bunga" => format_uang_no_prefix($totalInterest),
            "total_cicilan" => format_uang_no_prefix($totalIncome),
        ];

        return $result;
    }

    public function hitungAngsuranAnuitas($pinjaman, $bungaTahunan, $tenor, $tanggalPeminjaman, $tanggalSekarang = null) {
        $bungaBulanan = $bungaTahunan / 12 / 100;
        $angsuranBulanan = $pinjaman * $bungaBulanan / (1 - pow(1 + $bungaBulanan, -$tenor));

        $awal = Carbon::parse($tanggalPeminjaman);
        $sekarang = ($tanggalSekarang ? Carbon::parse($tanggalSekarang) : Carbon::now());
        $bulanKe = $awal->diffInMonths($sekarang);

        if ($bulanKe >= $tenor) {
            return [
                "angsuran" => 0,
                "pokok" => 0,
                "bunga" => 0,
                "keterangan" => "Tenor telah berakhir"
            ];
        }

        $saldo = $pinjaman;
        $pokokBulanIni = 0;
        $bungaBulanIni = 0;

        for ($i = 0; $i <= $bulanKe; $i++) {
            $bunga = $saldo * $bungaBulanan;
            $pokok = $angsuranBulanan - $bunga;
            $saldo -= $pokok;

            if ($i == $bulanKe) {
                $pokokBulanIni = $pokok;
                $bungaBulanIni = $bunga;
            }
        }

        return [
            "angsuran" => round($angsuranBulanan, 2),
            "pokok" => round($pokokBulanIni, 2),
            "bunga" => round($bungaBulanIni, 2),
            "bulan_ke" => $bulanKe + 1
        ];
    }

    function getTanggalSatuPerBulan($startDate, $endDate): array
    {
        $start = Carbon::parse($startDate)->startOfMonth();
        $end = Carbon::parse($endDate)->endOfMonth();

        $period = CarbonPeriod::create($start, '1 month', $end);

        $result = [];
        foreach ($period as $date) {
            $result[] = $date->copy()->startOfMonth()->format('Y-m-d');
        }

        return $result;
    }
}

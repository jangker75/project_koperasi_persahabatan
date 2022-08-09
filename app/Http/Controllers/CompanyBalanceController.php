<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyBalanceHistory;
use App\Models\Loan;
use App\Models\LoanHistory;
use Illuminate\Support\Str;

class CompanyBalanceController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['currentIndex'] = route('admin.company-balance.index');
    }
    public function index()
    {
        $data = $this->data;
        $data['titlePage'] = 'Saldo Koperasi';
        $data['company'] = Company::with('balance', 'balance.balancehistory')->find(1);
        $data['loanWaiting'] = Loan::waitingApproval()->count();
        $data['loanApproved'] = Loan::approved()->count();
        $data['loanRejected'] = Loan::rejected()->count();
        $data['loan'] = Loan::with('loanhistory')->approved()->get();
        $data['loanPaid'] = LoanHistory::where('transaction_type', 'debit')->get();
        return view('admin.pages.company_balance.index', $data);
    }
    public function getCompanyBalanceHistory($balance_type)
    {
        $history = CompanyBalanceHistory::where('balance_id', 1)
        ->{Str::camel($balance_type)}()->get();
        $history->map(function($data){
            $data->balance_before = format_uang($data->balance_before);
            $data->balance_after = format_uang($data->balance_after);
            $data->amount = format_uang($data->amount);
            $data->transaction_date = format_hari_tanggal_jam($data->transaction_date);
            return $data;
        });
        return response()->json([
            'message' => 'success',
            'type' => __("balance_company.{$balance_type}"),
            'data' => $history,
        ]);
    }
}

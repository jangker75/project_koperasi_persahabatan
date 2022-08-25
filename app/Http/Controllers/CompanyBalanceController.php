<?php

namespace App\Http\Controllers;

use App\Enums\ConstantEnum;
use App\Models\Company;
use App\Models\CompanyBalanceHistory;
use App\Models\Loan;
use App\Models\LoanHistory;
use App\Services\CompanyService;
use Illuminate\Http\Request;
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
    public function create()
    {
        $data = $this->data;
        $data['titlePage'] = 'Transfer Saldo';
        return view('admin.pages.company_balance.transfer_saldo_form', $data);
    }
    public function store(Request $request)
    {
        $input = $request->validate([
            'source_balance' => 'required',
            'destination_balance' => 'required',
            'description' => '',
            'amount' => 'required|numeric'
        ]);
        $notes = 'Transfer Saldo From '.ConstantEnum::BALANCE_COMPANY[$input['source_balance']]. ' To '. ConstantEnum::BALANCE_COMPANY[$input['destination_balance']] . (($input['description'] != null) ? ' : '. $input['description'] : '');
        (new CompanyService())->addDebitBalance($input['amount'] , $input['source_balance'], $notes);
        (new CompanyService())->addCreditBalance($input['amount'] , $input['destination_balance'], $notes);
        return redirect()->route('admin.company-balance.index')->with('success', 'Transfer Saldo sukses');
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

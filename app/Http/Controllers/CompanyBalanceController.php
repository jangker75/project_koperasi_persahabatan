<?php

namespace App\Http\Controllers;

use App\Enums\ConstantEnum;
use App\Models\Company;
use App\Models\CompanyBalanceHistory;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanHistory;
use App\Repositories\EmployeeRepository;
use App\Services\CompanyService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        ->{Str::camel($balance_type)}()->orderBy('created_at', 'desc')->get();
        $history->map(function($data){
            $data->balance_before = format_uang($data->balance_before);
            $data->balance_after = format_uang($data->balance_after);
            $data->amount = format_uang($data->amount);
            $data->transaction_date_order = $data->transaction_date;
            $data->transaction_date = format_hari_tanggal_jam($data->transaction_date);
            return $data;
        });
        return response()->json([
            'message' => 'success',
            'type' => __("balance_company.{$balance_type}"),
            'data' => $history,
        ]);
    }
    public function createTransferSaldoEmployee()
    {
        $data = $this->data;
        $data['employeeList'] = EmployeeRepository::getListDropdown();
        $data['titlePage'] = 'Tarik Saldo dari Nasabah';
        return view('admin.pages.company_balance.transfer_saldo_employee_form', $data);   
    }
    public function storeTransferSaldoEmployee(Request $request)
    {
        $input = $request->validate([
            "employee_id" => "required",
            "employee_savings_type" => "required",
            "company_balance" => "required",
            "amount" => "required",
            "description" => "",
        ]);
        $typeEmployeeBalance = __('savings_employee.'.$input['employee_savings_type']);
        $employee = Employee::findOrFail($input["employee_id"]);
        $notes = 'Transfer Saldo From '.$employee->full_name. ' ('.$typeEmployeeBalance.') To KOPERASI ('. __('balance_company.'.$input["company_balance"]) . (($request->input('description') != null) ? '). Description : '. $input['description'] : '');
        (new EmployeeService())->addDebitBalance(
            saving_id: $employee->savings->id,
            value: $input['amount'],
            saving_type: $input['employee_savings_type'],
            description: $notes);
        (new CompanyService())->addCreditBalance($input['amount'] , $input['company_balance'], $notes);
        return redirect()->route('admin.company-balance.index')->with('success', 'Transfer Saldo sukses');
    }

    public function createTransferSimpSukarela()
    {
        $data = $this->data;
        $data['employeeList'] = EmployeeRepository::getListDropdown();
        $data['titlePage'] = 'Tambah/Tarik saldo simpanan Nasabah';
        $data['transactionType'] = [
            'debit' => 'Pencairan',
            'credit' => 'Simpan',
        ];
        return view('admin.pages.company_balance.transfer_saldo_simp_sukarela_form', $data);   
    }
    public function storeTransferSimpSukarela(Request $request)
    {
        $input = $request->validate([
            "employee_id" => "required",
            "transaction_type" => "required",
            "company_balance" => "required",
            "amount" => "required",
            "description" => "",
        ]);
        $employee = Employee::find($input['employee_id']);
        $typeTrans = "Pencairan";
        if($input['transaction_type'] == 'debit'){
            $notes = $typeTrans . ' Simpanan Sukarela From KOPERASI ('. __('balance_company.'.$input["company_balance"]) . ') To '.$employee->full_name. (($request->input('description') != null) ? '. Description : '. $input['description'] : '');
            (new EmployeeService())->addDebitBalance(
                saving_id: $employee->savings->id,
                value: $input['amount'],
                saving_type: "voluntary_savings_balance",
                description: $notes);
            (new CompanyService())->addDebitBalance($input['amount'] , $input['company_balance'], $notes);
        }else{
            $typeTrans = "Penambahan";
            $notes = $typeTrans. ' Simpanan Sukarela From '.$employee->full_name. ' To KOPERASI ('. __('balance_company.'.$input["company_balance"]) . (($request->input('description') != null) ? '). Description : '. $input['description'] : '');
            (new EmployeeService())->addCreditBalance(
                saving_id: $employee->savings->id,
                value: $input['amount'],
                saving_type: "voluntary_savings_balance",
                description: $notes);
            (new CompanyService())->addCreditBalance($input['amount'] , $input['company_balance'], $notes);
        }
        return redirect()->route('admin.company-balance.index')->with('success', $typeTrans. ' Simpanan Sukarela sukses');
    }
}

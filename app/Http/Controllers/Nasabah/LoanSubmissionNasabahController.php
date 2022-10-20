<?php

namespace App\Http\Controllers\Nasabah;

use App\Enums\ConstantEnum;
use App\Http\Controllers\Controller;
use App\Models\ContractType;
use App\Models\InterestSchemeType;
use App\Models\Loan;
use App\Services\CodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanSubmissionNasabahController extends Controller
{
    public function index()
    {
        
        $data['contractTypeList'] = ContractType::query()
        ->select(DB::raw('concat(name, " (", contract_type_code, ")") as name'), 'id')
        ->pluck('name', 'id');
        $data['interestTypeList'] = ConstantEnum::INTEREST_AMOUNT_TYPE;
        $data['interestSchemeList'] = InterestSchemeType::pluck('name', 'id');
        $loan = Loan::where('employee_id', auth()->user()->employee->id)
        ->approved()->where('is_lunas', 0)->first();
        $data['isAnyLoan'] = $loan ? true : false;
        return view('nasabah.pages.loan.form', $data);
    }
    public function store(Request $request)
    {
        $data['transaction_number'] = (new CodeService())->generateCode('KOP');
        $data['remaining_amount'] = $request->input('total_loan_amount');
        $data['created_by'] = auth()->user()->id;
        $data['employee_id'] = auth()->user()->employee->id;
        $data['loan_approval_status_id'] = 50;
        $data['interest_amount_type'] = 'percentage';
        $data['interest_amount'] = 2;
        $data['profit_company_ratio'] = 50;
        $data['profit_employee_ratio'] = 50;
        $data['interest_scheme_type_id'] = 2;
        Loan::create($request->merge($data)->all());
        
        return redirect()->route('nasabah.home');
    }
}

<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanNasabahController extends Controller
{
    public function index()
    {
        $employeeId = auth()->user()->employee->id;
        $data['waitingLoans'] = Loan::where('employee_id', $employeeId)
        ->waitingApproval()->orderBy('id','desc')->get();
        $data['ongoingLoan'] = Loan::where('employee_id', $employeeId)
        ->approved()->where('is_lunas', 0)->orderBy('id', 'desc')->first();
        $data['loansHistory'] = Loan::where('employee_id', $employeeId)
        ->where('loan_approval_status_id', '!=',50)
        ->orderBy('id', 'desc')->get();
        return view('nasabah.pages.loan.index', $data);
    }
    public function show(Loan $loan)
    {
        $data['loan'] = $loan;
        return view('nasabah.pages.loan.loan_history_payment', $data);
    }
}

<?php

namespace App\Http\Controllers\Usipa;

use App\Enums\ConstantEnum;
use App\Http\Controllers\BaseAdminController;
use App\Http\Requests\LoanStoreRequest;
use App\Models\ContractType;
use App\Models\Employee;
use App\Models\InterestSchemeType;
use App\Models\Loan;
use App\Repositories\EmployeeRepository;
use App\Services\CodeService;
use App\Services\CompanyService;
use App\Services\EmployeeService;
use App\Services\LoanService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class LoanSubmissionController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.loan-submission.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data['titlePage'] = 'Pengajuan Pinjaman';
        return view('admin.pages.loan_submission.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->data;
        $data['titlePage'] = 'Pengajuan Pinjaman';
        $data['employeeList'] = EmployeeRepository::getListDropdown();
        $data['contractTypeList'] = ContractType::query()
        ->select(DB::raw('concat(name, " (", contract_type_code, ")") as name'), 'id')
        ->pluck('name', 'id');
        $data['interestTypeList'] = ConstantEnum::INTEREST_AMOUNT_TYPE;
        $data['interestSchemeList'] = InterestSchemeType::pluck('name', 'id');
        return view('admin.pages.loan_submission.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanStoreRequest $request)
    {
        $input = $request->safe();
        $data['transaction_number'] = (new CodeService())->generateCode('KOP');
        $data['remaining_amount'] = $input->total_loan_amount;
        $data['created_by'] = auth()->user()->employee->id;
        $data['loan_approval_status_id'] = 50;
        $input->received_amount = str_replace(',','',$input->received_amount);
        Loan::create($input->merge($data)->all());
        
        return redirect()->route('admin.loan-submission.index')->with('success', __('general.notif_add_new_data_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan_submission)
    {
        $data = $this->data;
        $data['titlePage'] = 'Detail Data';
        $data['loan'] = $loan_submission;
        return view('admin.pages.loan_submission.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('admin.loan-submission.index')->with('success', __('general.notif_delete_data_success'));
    }
    public function getIndexDatatables()
    {
        $query = Loan::query()
        ->with('approvalstatus','user.employee')
        ->select('loans.*')
        ->waitingApproval();
        // ->where('loan_approval_status_id', 50)
        ;
        $datatable = new DataTables();
        return $datatable->eloquent($query)
            ->addIndexColumn(true)
            ->editColumn('total_loan_amount', function($row){
                return format_uang($row->total_loan_amount);
            })
            ->addColumn('full_name', function($row){
                return $row->employee->full_name;
            })
            ->addColumn('status', function($row){
                $class = ($row->approvalstatus->name == 'Waiting') ? 'bg-warning' : (($row->approvalstatus->name == 'Approved') ? 'bg-success' : 'bg-danger');
                $btn = '<span class="badge '.$class.' rounded-pill text-white fw-bold p-2 px-3">'.$row->approvalstatus->name.'</span>';
                return $btn;
            })
            ->addColumn('actions', function($row){
                $btn = '<div class="btn-group btn-list d-flex justify-content-center">';
                if($row->approvalstatus->name == 'Waiting'){
                    $btn = $btn . '<div class="dropdown">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-bs-toggle="dropdown">
                                Action
                            </button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item action-button" href="'. route('admin.loan-submission.action.approval', ['status' => 51, 'loan' => $row->id]) .'">Approve</a>
                            <a class="dropdown-item action-button" href="'. route('admin.loan-submission.action.approval', ['status' => 52, 'loan' => $row->id]) .'">Reject</a>
                        </div>
                    </div>';
                }
                $btn = $btn . '<a class="btn btn-sm btn-warning" href="'. route("admin.loan-submission.show", [$row]) .'" type="button">View</a>';
                // $btn = $btn . '<a class="btn btn-sm btn-primary badge" href="'. route("admin.loan-submission.edit", [$row]) .'" type="button">Edit</a>';
                $btn = $btn . '<a class="btn btn-sm btn-danger delete-button" type="button">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form method="POST" action="' . route('admin.loan-submission.destroy', [$row]) . '">
                            <input name="_method" type="hidden" value="delete">
                            <input name="_token" type="hidden" value="' . Session::token() . '">
                        </form>';
                
                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['actions', 'status', 'full_name'])
            ->make(true);
    }

    public function actionSubmissionLoan(Loan $loan, $status)
    {
        $loan->update([
            'loan_approval_status_id' => $status,
            'response_date' => now(),
            'response_user' => auth()->user()->employee->full_name
        ]);
        if($status == 51) {
            $notesLoanHistory = 'Pinjaman Awal';
            $loan->loanhistory()->create([
                'transaction_type' => 'credit',
                'transaction_date' => now(),
                'total_payment' => $loan->total_loan_amount,
                'interest_amount' => 0,
                'loan_amount_before' => 0,
                'loan_amount_after' => $loan->total_loan_amount,
                'profit_company_amount' => 0,
                'profit_employee_amount' => 0,
                'description' => $notesLoanHistory,
            ]);
            $notesEmployeeBalance = __('balance_company.balance_history', ['type' => 'Simpanan Khusus pinjaman baru', 'data' => $loan->transaction_number]);
            // $notesCompanyBalance = __('balance_company.balance_history', ['type' => 'Admin fee', 'data' => $loan->transaction_number]);
            (new EmployeeService())->addCreditBalance(
                saving_id: $loan->employee->savings->id,
                value: $loan->admin_fee,
                saving_type: 'activity_savings_balance',
                description: $notesEmployeeBalance);
            // (new CompanyService())->addCreditBalance($loan->admin_fee, 'loan_balance', $notesCompanyBalance);
        };

        return redirect()->route('admin.loan-submission.index')->with('success', __('general.notif_edit_data_success'));
    }

    public function downloadLoanSimulation(Request $request)
    {
        $return = (new LoanService())->calculateLoanSimulation(
            firstPaymentDate: $request->input("firstPaymentDate"),
            totalLoanAmount: $request->input("totalLoanAmount"),
            interestType: $request->input("interestType"),
            interestScheme: $request->input("interestScheme"),
            totalPayMonth: $request->input("totalPayMonth"),
            payPerXMonth: $request->input("payPerXMonth"),
            totalInterestAmount: $request->input("totalInterestAmount"),
            profitCompanyRatio: $request->input("profitCompanyRatio")
        );
        $data['title'] = 'Simulasi Pinjaman';
        $data['data'] = $return['data'];
        $data['lastrow'] = $return['lastrow'];
        $pdf = Pdf::loadView('admin.export.PDF.loan_simulasi', $data);
        return $pdf->stream($data['title'].'.pdf');
    }
    public function calculateLoanSimulation(Request $request)
    {
        $return = (new LoanService())->calculateLoanSimulation(
            firstPaymentDate: $request->input("firstPaymentDate"),
            totalLoanAmount: $request->input("totalLoanAmount"),
            interestType: $request->input("interestType"),
            interestScheme: $request->input("interestScheme"),
            totalPayMonth: $request->input("totalPayMonth"),
            payPerXMonth: $request->input("payPerXMonth"),
            totalInterestAmount: $request->input("totalInterestAmount"),
            profitCompanyRatio: $request->input("profitCompanyRatio")
        );
        return response()->json($return);
    }
}

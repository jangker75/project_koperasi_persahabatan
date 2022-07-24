<?php

namespace App\Http\Controllers\Usipa;

use App\Enums\ConstantEnum;
use App\Http\Controllers\BaseAdminController;
use App\Http\Requests\LoanStoreRequest;
use App\Models\ContractType;
use App\Models\Employee;
use App\Models\InterestSchemeType;
use App\Models\Loan;
use App\Services\CodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class LoanSubmissionController extends BaseAdminController
{
    public function __construct()
    {
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
        $data['employeeList'] = Employee::active()
        ->select(DB::raw('concat(first_name, " ", last_name," (", nik, ")") as name'), 'id')
        ->pluck('name', 'id');
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
        $data['created_by'] = auth()->user()->employee->full_name;
        $data['loan_approval_status_id'] = 3;
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
    public function show(Loan $loan)
    {
        //
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
        //
    }
    public function getIndexDatatables()
    {
        $query = Loan::query()
        ->with('approvalstatus')
        ->select('loans.*');
        $datatable = new DataTables();
        return $datatable->eloquent($query)
            ->addIndexColumn(true)
            ->editColumn('total_loan_amount', function($row){
                return format_uang($row->total_loan_amount);
            })
            ->addColumn('actions', function($row){
                $btn = '<div class="btn-group align-top">';
                $btn = $btn . '<a class="btn btn-sm btn-warning badge" href="'. route("admin.loan-submission.show", [$row]) .'" type="button">View</a>';
                // $btn = $btn . '<a class="btn btn-sm btn-primary badge" href="'. route("admin.loan-submission.edit", [$row]) .'" type="button">Edit</a>';
                $btn = $btn . '<a class="btn btn-sm btn-danger badge delete-button" type="button">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form method="POST" action="' . route('admin.loan-submission.destroy', [$row]) . '">
                            <input name="_method" type="hidden" value="delete">
                            <input name="_token" type="hidden" value="' . Session::token() . '">
                        </form>';
                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}

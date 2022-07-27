<?php

namespace App\Http\Controllers\Usipa;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LoanListController extends BaseAdminController
{
    public function __construct()
    {
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.loan-list.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data['titlePage'] = 'Data Pinjaman';
        return view('admin.pages.loan_list.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan_list)
    {
        $data = $this->data;
        $data['titlePage'] = 'Detail Data';
        $data['loan'] = $loan_list;
        return view('admin.pages.loan_list.detail', $data);
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
        $keyword = request('keyword');
        $query = Loan::query()
        ->with('approvalstatus', 'employee')
        ->select('loans.*')
        ->where('loan_approval_status_id', '!=', 3);
        $datatable = new DataTables();
        return $datatable->eloquent($query)
            ->addIndexColumn(true)
            ->editColumn('total_loan_amount', function($row){
                return format_uang($row->total_loan_amount);
            })
            ->addColumn('full_name', function($row){
                return $row->employee->full_name;
            })
            ->filterColumn('full_name', function($row) use($keyword){
                return $row->whereHas('employee', function($q) use($keyword){
                    $q->where('employees.first_name', 'like' , ["%$keyword%"])
                    ->orWhere('employees.last_name', 'like' , ["%$keyword%"]);
                });
            })
            ->addColumn('status', function($row){
                $class = ($row->loan_approval_status_id == 3) ? 'btn-warning' : (($row->loan_approval_status_id == 4) ? 'btn-success' : 'btn-danger');
                $btn = '<a disabled class="btn '.$class.' btn-pill text-white fw-600 btn-sm">'.$row->approvalstatus->name.'</a>';
                return $btn;
            })
            ->addColumn('actions', function($row){
                $btn = '<div class="d-flex justify-content-center btn-group btn-list">';
                $btn = $btn . '<a class="btn btn-sm btn-warning" href="'. route("admin.loan-list.show", [$row]) .'" type="button">View</a>';
                $btn = $btn . '<a class="btn btn-sm btn-primary badge" href="'. route("admin.loan-list.edit", [$row]) .'" type="button">Edit</a>';
                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['actions', 'status', 'full_name'])
            ->make(true);
    }
}

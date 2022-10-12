<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class ExEmployeeController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.ex-employee.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data['titlePage'] = 'Data Anggota Keluar';
        return view('admin.pages.ex_employee.index', $data);
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
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $ex_employee)
    {
        $data = $this->data;
        $data['titlePage'] = 'Detail data';
        $data['employee'] = $ex_employee;
        return view('admin.pages.ex_employee.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
    public function getIndexDatatables()
    {
        $query = Employee::query()
        ->with('position')
        ->select('employees.*')
        ->nonActive();
        $datatable = new DataTables();
        return $datatable->eloquent($query)
            ->addIndexColumn(true)
            ->editColumn('salary', function($row){
                return format_uang($row->salary);
            })
            ->addColumn('actions', function($row){
                $btn = '<div class="btn-list align-center d-flex justify-content-center">';
                $btn = $btn . '<a class="btn btn-sm btn-warning badge" href="'. route("admin.ex-employee.show", [$row]) .'" type="button">View</a>';
                $btn = $btn . '<a target="_blank" class="btn btn-sm btn-success badge" href="' . route("admin.ex-employee.download.form-keluar", ['employee' => $row->id]) . '" type="button">Download Form Keluar</a>';
                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function downloadFormKeluar(Employee $employee)
    {
        $data['employee'] = $employee;
        $data['title'] = "Form Anggota Keluar";
        $pdf = Pdf::loadView('admin.export.PDF.form_keluar', $data);
        // return view('admin.export.PDF.form_keluar', $data);
        return $pdf->stream("Form_keluar_".$employee->name.".pdf");
    }
}

<?php

namespace App\Http\Controllers\Umum;

use App\Enums\ConstantEnum;
use App\Exports\BasicReportExport;
use App\Http\Controllers\BaseAdminController;
use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\MasterDataStatus;
use App\Models\Position;
use App\Models\SavingHistory;
use App\Models\Savings;
use App\Models\User;
use App\Services\DynamicImageService;
use App\Services\EmployeeService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EmployeeController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        // $this->middleware('permission:read employee', ['only' => ['index','show']]);
        // $this->middleware('permission:create employee', ['only' => ['create','store']]);
        // $this->middleware('permission:edit employee', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete employee', ['only' => ['destroy']]);
        // Debugbar::info(request()->url());
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.employee.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // auth()->user()->can('view');
        $data = $this->data;
        $data['titlePage'] = 'Data Anggota';
        return view('admin.pages.employee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->data;
        $data['titlePage'] = 'Add New Data';
        $data['positionList'] = Position::notAdmin()->pluck('name', 'id');
        $data['departmentList'] = Department::pluck('name', 'id');
        $data['statusEmployeeList'] = MasterDataStatus::statusEmployee()->pluck('name', 'id');
        return view('admin.pages.employee.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $input = $request->safe();
        $imageService = (new DynamicImageService());
        
        //SAVE User table
        $user = User::make([
            'password' => Hash::make('123456'),
        ]);
        if ($request->hasFile('profile_image')) {
           $user->profile_image = $imageService->uploadImage($request->file('profile_image'), config('constant.USER_IMAGE_PATH'));
        }
        $user->save();

        //SAVE Employee Table
        $employee = $user->employee()->create($input->merge([
            'registered_date' => now()
        ])->all());
        $savings = Savings::factory()->make();
        $employee->savings()->save($savings);
        (new EmployeeService())->addCreditBalance($employee->savings->id, 25000, ConstantEnum::SAVINGS_BALANCE_TYPE['POKOK']);
        $role = checkPositionRole($employee->position->position_code);
        $user->assignRole($role);
        return redirect()->route('admin.employee.index')->with('success', __('general.notif_add_new_data_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $data = $this->data;
        $data['employee'] = $employee;
        return view('admin.pages.employee.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $data = $this->data;
        $data['titlePage'] = 'Edit Data';
        $data['positionList'] = Position::notAdmin()->pluck('name', 'id');
        $data['departmentList'] = Department::pluck('name', 'id');
        $data['statusEmployeeList'] = MasterDataStatus::statusEmployee()->pluck('name', 'id');
        $data['employee'] = $employee;


        return view('admin.pages.employee.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $input = $request->safe();
        $employee->update($input->all());
        $imageService = (new DynamicImageService());
        //Save Image if there is update
        if ($request->hasFile('profile_image')) {
            $imageService->delete($employee->user->profile_image);
            $data['profile_image'] = $imageService->uploadImage($request->file('profile_image'), config('constant.USER_IMAGE_PATH'));
            $employee->user->update($data);
         }
        $role = checkPositionRole($employee->position->position_code);
        $employee->user->syncRoles($role);
        return redirect()->route('admin.employee.index')->with('success', __('general.notif_edit_data_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employee.index');
    }
    public function getIndexDatatables()
    {
        $query = Employee::query()
            ->with('position')
            ->select('employees.*')
            ->active();
        $datatable = new DataTables();
        return $datatable->eloquent($query)
            ->addIndexColumn(true)
            ->editColumn('salary', function ($row) {
                return format_uang($row->salary);
            })
            ->addColumn('actions', function ($row) {
                $btn = '<div class="btn-list align-center d-flex justify-content-center">';
                $btn = $btn . '<a class="btn btn-sm btn-warning badge" href="' . route("admin.employee.show", [$row]) . '" type="button">View</a>';
                $btn = $btn . '<a class="btn btn-sm btn-primary badge" href="' . route("admin.employee.edit", [$row]) . '" type="button">Edit</a>';
                $btn = $btn . '<a class="btn btn-sm btn-danger badge delete-button" type="button">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form method="POST" action="' . route('admin.employee.destroy', [$row]) . '">
                            <input name="_method" type="hidden" value="delete">
                            <input name="_token" type="hidden" value="' . Session::token() . '">
                        </form>';
                        $btn = $btn . '<a class="btn btn-sm btn-primary badge" href="' . route("admin.employee.download.card", ['employee' => $row->id]) . '" type="button">Download Card</a>';
                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function employeeOut()
    {
        $data = $this->data;
        $data['titlePage'] = 'Form Anggota Keluar';
        $data['employeeList'] = Employee::active()
            ->select(DB::raw('concat(first_name, " ", last_name," (", nik, ")") as name'), 'id')
            ->pluck('name', 'id');
        return view('admin.pages.employee.form_resign', $data);
    }
    public function employeeOutStore(Request $request)
    {
        $input = $request->validate([
            "employee_id" => "required",
            "resign_date" => "required|date_format:Y-m-d",
            "resign_reason" => "required",
            "resign_notes" => "",
        ]);
        $employee = Employee::findOrFail($input['employee_id']);
        $employee->update($input);
        return redirect()->route('admin.employee.index')->with('success', __('general.notif_edit_data_success'));
    }
    public function getEmployeeSavingsHistory(Employee $employee_id, $saving_type)
    {
        $history = SavingHistory::where('saving_id', $employee_id->savings->id)->{Str::camel($saving_type)}()->get();
        $history->map(function ($data) {
            $data->balance_after = format_uang($data->balance_after);
            $data->amount = format_uang($data->amount);
            $data->transaction_date = format_hari_tanggal_jam($data->transaction_date);
            return $data;
        });
        return response()->json([
            'message' => 'success',
            'type' => __("savings_employee.{$saving_type}"),
            'data' => $history,
        ]);
    }

    public function checkStatusLoanEmployee(Request $request)
    {
        $data = [
            'status' => 'success',
        ];
        $loan = Loan::where('employee_id', request('employee_id'))
            ->approved()
            ->where('is_lunas', 0)->get();
        $employee = Employee::find(request('employee_id'));
        if (count($loan) != 0) {
            $data['status_loan'] = 'Karyawan ini ada pinjaman yang belum lunas';
            $data['transaction_number'] = $loan->pluck('transaction_number');
        }
        if ($employee->age >= 45) {
            $data['status_age'] = "Umur karyawan ini akan pensiun (" . $employee->age . " Tahun)";
        }
        return response()->json($data);
    }

    public function exportData($type)
    {
        //Header for export file
        $data['title'] = 'Data Nasabah';
        $data['headers'] = ['Nama', 'NIK', 'Status Karyawan', 'Bank', 'Rekening'];
        $employee = Employee::query()
            ->with(['statusEmployee' => function($query){
                $query->select('id', 'name');
            }])    
            ->select(
                DB::raw('concat(first_name, " ", last_name) as fullname'),
                'nik','status_employee_id', 'bank', 'rekening'
            )
            ->get();
        
        //Reformat field
        $employee->map(function ($item) use ($type) {
            if ($type == 'xls') {
                $item['nik'] = convertNumberToStringExcel($item->nik);
                $item['rekening'] = convertNumberToStringExcel($item->rekening);
            }
            $item['status_employee_id'] = $item->statusEmployee->name;
            $item['bank'] = ConstantEnum::BANK[$item->bank];
            unset($item->statusEmployee);
            return $item;
        });
        $data['datas'] = $employee->toArray();

        if ($type == 'pdf') {
            $pdf = Pdf::loadView('admin.export.Excel.basic_report', $data);
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->getCanvas(); 
            $canvas->page_text(500, 18, "Hal {PAGE_NUM} dari {PAGE_COUNT}", null, 11, [0, 0, 0]);
            return $pdf->stream('data_nasabah.pdf');
        }
        elseif ($type == 'xls') {
            return (new BasicReportExport(datas: $data['datas'], headers: $data['headers'], title: $data['title']))
                ->download('data_nasabah.xlsx');
        }
    }

    public function downloadEmployeeCard(Employee $employee)
    {
        // dd($employee);
        $data['employee'] = $employee;
        $scale = 2;
        $customPaper = array(0,0,242.6457 * $scale, 153.01417 * $scale);
        $pdf = Pdf::loadView('admin.export.PDF.kartu_anggota', $data)
        ->setPaper($customPaper);
        
        return $pdf->stream("kartu_anggota_".$employee->name.".pdf");
    }
}

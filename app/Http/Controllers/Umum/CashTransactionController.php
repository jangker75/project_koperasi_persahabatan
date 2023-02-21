<?php

namespace App\Http\Controllers\Umum;

use App\Enums\ConstantEnum;
use App\Http\Controllers\BaseAdminController;
use App\Http\Requests\CashTransactionRequest;
use App\Models\DivisiUmumTransaction;
use App\Services\CompanyService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class CashTransactionController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['isadd'] = false;
        $this->data['currentIndex'] = route('admin.cash-in-out.index');
    }
    public function index()
    {
        $data = $this->data;
        $data['titlePage'] = 'Transaksi Kas Keluar/Masuk';
        return view('admin.pages.cash_transaction.index', $data);
    }
    public function show($cash_in_out)
    {
        dd($cash_in_out);
    }
    public function create()
    {
        $data = $this->data;
        $data['titlePage'] = 'Add New Data';
        return view('admin.pages.cash_transaction.form', $data);
    }
    public function store(CashTransactionRequest $request)
    {
        $input = $request->safe();
        DivisiUmumTransaction::create($input->merge([
            'transaction_date' => now()
        ])->all());
        $input->description = $input->description ?? '';
        if ($input->transaction_type == 'credit') {
            (new CompanyService())->addCreditBalance($input->amount, 'other_balance', $input->description);
        }else{
            (new CompanyService())->addDebitBalance($input->amount, 'other_balance', $input->description);
        }
        return redirect()->route('admin.cash-in-out.index')->with('success', __('general.notif_add_new_data_success'));
    }
    public function edit(DivisiUmumTransaction $cash_in_out)
    {
        $data = $this->data;
        $data['titlePage'] = 'Edit data';
        $data['cashTransaction'] = $cash_in_out;
        return view('admin.pages.cash_transaction.form', $data);

    }
    public function update(CashTransactionRequest $request, DivisiUmumTransaction $cash_in_out)
    {
        $input = $request->safe();
        $cash_in_out->update($input->all());
        return redirect()->route('admin.cash-in-out.index')->with('success', __('general.notif_edit_data_success'));
    }
    public function getIndexDatatables()
    {
        $keyword = request('keyword');
        $query = DivisiUmumTransaction::query()
            ->with('user.employee')
            ->select('divisi_umum_transactions.*');
        $datatable = new DataTables();
        return $datatable->eloquent($query)
            ->addIndexColumn(true)
            ->editColumn('amount', function ($row) {
                return format_uang($row->amount);
            })
            ->editColumn('transaction_type', function($row){
                return ConstantEnum::TRANSACTION_TYPE_DIV_UMUM[$row->transaction_type];
            })
            ->editColumn('transaction_date', function ($row) {
                return format_hari_tanggal_jam($row->transaction_date);
            })
            ->addColumn('full_name', function($row){
                return $row->user->employee->first_name .' ' . $row->user->employee->last_name;
            })
            ->filterColumn('full_name', function($row) use($keyword){
                return $row->whereHas('user.employee', function($q) use($keyword){
                    $q->where('employees.first_name', 'like' , ["%$keyword%"])
                    ->orWhere('employees.last_name', 'like' , ["%$keyword%"]);
                });
            })
            ->addColumn('actions', function ($row) {
                $btn = '<div class="btn-list align-center d-flex justify-content-center">';
                // $btn = $btn . '<a class="btn btn-sm btn-warning badge" href="' . route("admin.cash-in-out.show", [$row]) . '" type="button">View</a>';
                $btn = $btn . '<a class="btn btn-sm btn-primary badge" href="' . route("admin.cash-in-out.edit", [$row]) . '" type="button">Edit</a>';
                $btn = $btn . '<a class="btn btn-sm btn-danger badge delete-button" type="button">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form method="POST" action="' . route('admin.cash-in-out.destroy', [$row]) . '">
                            <input name="_method" type="hidden" value="delete">
                            <input name="_token" type="hidden" value="' . Session::token() . '">
                        </form>';
                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['actions', 'full_name'])
            ->make(true);
    }
    public function downloadReportCashTransaction()
    {
        // dd($request->all());
        $data['title'] = 'Laporan Kas Kokarda';
        $data['date_from'] = request("date_from");
        $data['date_to'] = request("date_to");
        $data["data"] = DivisiUmumTransaction::query()
        ->with('user.employee')
        ->select('divisi_umum_transactions.*')
        ->where("transaction_date", ">=", request("date_from")." 00:00:01")
        ->where("transaction_date", "<=", request("date_to")." 23:59:59")
        ->orderBy('transaction_date', 'asc')
        ->get();
        
        // dd($data["data"]->where('transaction_type','debit')->sum('amount'));
        $pdf = Pdf::loadView('admin.export.PDF.laporan_kas', $data);
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->getCanvas(); 
        $canvas->page_text(520, 810, "Hal {PAGE_NUM} dari {PAGE_COUNT}", null, 11, [0, 0, 0]);
        return $pdf->stream("Laporan Kas Kokarda.pdf");
    }
}

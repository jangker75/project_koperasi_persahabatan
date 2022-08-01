<?php

namespace App\Http\Controllers\Usipa;

use App\Http\Controllers\BaseAdminController;
use App\Models\Loan;
use App\Services\LoanService;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public function show(Loan $loan_list, Request $request)
    {
        if ($request->ajax()) {
            $data['loan'] = $loan_list;
            return view('admin.pages.loan_list.detail_card_loan', $data);
        }
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

    public function fullPayment(Loan $loan)
    {
        $data = $this->data;
        $data['titlePage'] = 'Form Pelunasan';
        $data['loan'] = $loan;
        return view('admin.pages.loan_list.full_payment_form', $data);
    }
    public function fullPaymentStore()
    {
        (new LoanService())->fullPayment(loanId: request('loan_id'), description: request('description'));
        return redirect()->route('admin.loan-list.index')->with('success', 'Edit Lunas berhasil');
    }
    public function somePaymentStore()
    {
        (new LoanService())->somePayment(loanId: request('loan_id'), value: request('amount'), description: request('description'));
        return redirect()->route('admin.loan-list.index')->with('success', 'Revisi berhasil');
    }
    public function downloadKontrakPeminjamanPDF(Loan $loan_id)
    {
        $data['loan'] = $loan_id;
        switch ($loan_id->contract_type_id) {
            case 1: //if contract pinjaman uang
                $pdf = Pdf::loadView('admin.export.PDF.permohonan_pinjaman_uang', $data);
                break;
            case 2: //if contract pinjaman barang
                $pdf = Pdf::loadView('admin.export.PDF.permohonan_kredit_barang', $data);
                break;
            
            default:
                # code...
                break;
        }
        // Instantiate canvas instance 
        $canvas = $pdf->getCanvas(); 
        
        // Get height and width of page 
        $w = $canvas->get_width(); 
        $h = $canvas->get_height(); 
        
        // Specify watermark image 
        $imageURL = asset('assets/images/logo/logo-koperasi-grayscale.png'); 
        $imgWidth = $imgHeight = 430; 
        
        // Set image opacity 
        $canvas->set_opacity(.2); 
        
        // Specify horizontal and vertical position 
        $x = (($w-$imgWidth)/2); 
        $y = (($h-$imgHeight)/2); 
        
        // Add an image to the pdf 
        $canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight); 
        return $pdf->stream('pdf.pdf');
    }
    public function getIndexDatatables()
    {
        $keyword = request('keyword');
        $status = request('status');
        $query = Loan::query()
        ->with('approvalstatus', 'employee')
        ->select('loans.*')
        // ->where('is_lunas', 0)
        ->when($status != '' && $status != 'All', function($row) use($status){
            $row->whereHas('approvalstatus', function($query) use($status){
                $query->statusLoanApproval()->where('name', $status);
            });
        })
        ;
        $datatable = new DataTables();
        return $datatable->eloquent($query)
            ->addIndexColumn(true)
            ->editColumn('total_loan_amount', function($row){
                return format_uang($row->total_loan_amount);
            })
            ->editColumn('loan_date', function($row){
                return format_hari_tanggal($row->loan_date);
            })
            ->editColumn('remaining_amount', function($row){
                return format_uang($row->remaining_amount);
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
                $class = ($row->approvalstatus->name == 'Waiting') ? 'bg-warning' : (($row->approvalstatus->name == 'Approved') ? 'bg-success' : 'bg-danger');
                $btn = '<span class="badge '.$class.' rounded-pill text-white fw-bold p-2 px-3">'.$row->approvalstatus->name.'</span>';
                return $btn;
            })
            ->addColumn('status_lunas', function($row){
                $class = ($row->is_lunas) ? 'bg-success' : 'bg-warning';
                $text = ($row->is_lunas) ? 'Lunas' : 'Belum Lunas';
                $btn = '<span class="badge '.$class.' rounded-pill text-white fw-bold p-2 px-3">'.$text.'</span>';
                return $btn;
            })
            ->addColumn('actions', function($row){
                $btn = '<div class="d-flex justify-content-center btn-group btn-list">';
                $btn = $btn . '<a class="btn btn-sm btn-warning" href="'. route("admin.loan-list.show", [$row]) .'" type="button">View</a>';
                if(!$row->is_lunas && $row->approvalstatus->name == 'Approved'){
                    $btn = $btn . '<a class="btn btn-sm btn-primary badge" href="'. route("admin.loan.fullpayment", [$row]) .'" type="button">Pelunasan/Revisi</a>';
                    $btn = $btn . '<a class="btn btn-sm btn-success" target="_blank" href="'. route("admin.download.kontrak.peminjaman", [$row->id]) .'" type="button">Download Kontrak</a>';
                }
                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['actions', 'status', 'full_name', 'status_lunas'])
            ->make(true);
    }
}

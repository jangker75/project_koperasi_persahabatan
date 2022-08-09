<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class LoanReportExport implements FromView, ShouldAutoSize
{
    use Exportable;
    public function __construct($datas, $headers, $title = null)
    {
        $this->datas = $datas;
        $this->headers = $headers;
        $this->title = $title;
    }
    public function view(): View
    {
        return view('admin.export.Excel.loan_report', [
            'datas' => $this->datas,
            'headers' => $this->headers,
            'title' => $this->title ?? null,
        ]);
    }
}

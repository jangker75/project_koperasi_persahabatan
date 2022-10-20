<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BasicReportExport implements FromView, ShouldAutoSize
{
    use Exportable;
    public function __construct($datas, $headers, $formatColumn = null, $title = null)
    {
        $this->datas = $datas;
        $this->headers = $headers;
        $this->formatColumn = $formatColumn;
        $this->title = $title;
    }
    public function view(): View
    {
        return view('admin.export.Excel.basic_report', [
            'datas' => $this->datas,
            'headers' => $this->headers,
            'title' => $this->title ?? null,
        ]);
    }
    public function columnFormats(): array{
        if ($this->formatColumn != null) {
            return $this->formatColumn;
        }
        return [];
    }
}

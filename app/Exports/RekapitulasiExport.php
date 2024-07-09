<?php

namespace App\Exports;

use App\Repositories\ProductStockRepositories;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapitulasiExport implements FromView
{
    protected $store;

    public function __construct($store)
    {
      $this->store = $store;
    }

    public function view(): View
    {
        return view('admin.export.Excel.rekapitulasi_stok_report', [
            'datas' => (new ProductStockRepositories)->listingRekapitulasiData(true, ['store' => $this->store])
        ]);
    }
}

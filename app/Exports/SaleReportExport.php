<?php

namespace App\Exports;

use App\Models\SaleReport;
use Maatwebsite\Excel\Concerns\FromCollection;

class SaleReportExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $sales = SaleReport::where('type', 'income')->get();
        return collect($sales);
    }
}

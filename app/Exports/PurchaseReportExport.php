<?php

namespace App\Exports;

use App\Models\PurchaseReport;
use Maatwebsite\Excel\Concerns\FromCollection;

class PurchaseReportExport implements FromCollection
{
    public function headings(): array
    {
        // according to users table
        return [
            "User Id",
            "Name",
            "Email Address",
            "Phone No.",
            "Gender",
            "User Type",
            "Registered At"
           ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $purchases = PurchaseReport::where('type', 'purchase')->get();
        return collect($purchases);
    }
}

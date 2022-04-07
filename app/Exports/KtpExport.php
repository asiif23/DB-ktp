<?php

namespace App\Exports;

use App\Models\Ktp;
use Maatwebsite\Excel\Concerns\FromCollection;

class KtpExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ktp::all();
    }
}

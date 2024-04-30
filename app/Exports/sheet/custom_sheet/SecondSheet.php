<?php

namespace App\Exports\sheet\custom_sheet;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class SecondSheet implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}

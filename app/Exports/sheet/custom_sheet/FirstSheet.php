<?php

namespace App\Exports\sheet\custom_sheet;

use Maatwebsite\Excel\Concerns\FromCollection;

class FirstSheet implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}

<?php

namespace App\Http\Controllers\report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\reports\ReportExpireExcel;

class ReportExpireController extends Controller
{
    //

    public function exportExpire(Request $request)
    {
     $expireType = $request->expireType;
     //dd($expireType);
    return Excel::download(new ReportExpireExcel($expireType), 'labour-'.$expireType.'expire-'.date('d-m-Y').'.xlsx');
    }
}

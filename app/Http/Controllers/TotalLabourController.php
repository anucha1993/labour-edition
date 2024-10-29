<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TotalLabourExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TotalLabourController extends Controller
{
    //

    public function index()
    {
        $import = DB::table('import')->get();
        $company = DB::table('company')->where('company_name','!=','')->select('company.company_id','company.company_name')->latest()->get();
        return view('labour_total.index',compact('import','company'));
    }


    public function export() 
    {
        return Excel::download(new TotalLabourExport, 'labour-total.xlsx');
    }
    
}

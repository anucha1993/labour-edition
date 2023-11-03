<?php

namespace App\Http\Controllers\report;

use App\Exports\ExportUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\reports\reportLabourAllExcell;

class ReportLabourAllCOntroller extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $import = DB::table('import')->get();
        $company = DB::table('company')->where('company_name','!=','')->select('company.company_id','company.company_name')->latest()->get();
        return view('reports.form-report-all',compact('company','import'));
    }


        public function exportLabours(Request $request){
        //dd($request);
        $company_id = $request->company_id;
        $status = $request->status;
        $import_id = $request->import_id;
        return Excel::download(new reportLabourAllExcell($company_id,$status,$import_id), 'labour'.date('d-m-Y').'.xlsx');
        
    }
    
   
    

}

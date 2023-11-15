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


        public function exportLabours(Request $request)

        {

        $data = [];
        $company_id = $request->company_id;
        $status = $request->status;
        $import_id = $request->import_id;

        $ninety_day_start = $request->ninety_day_start;
        $ninety_day_end = $request->ninety_day_end;
        $visa_start = $request->visa_start;
        $visa_end = $request->visa_end;
        $work_start = $request->work_start;
        $work_end = $request->work_end;
        $passport_start = $request->passport_start;
        $passport_end = $request->passport_end;


        return Excel::download(new reportLabourAllExcell(
            $data,
            $company_id,
            $status,$import_id,
            $ninety_day_start,
            $ninety_day_end,
            $visa_start,
            $visa_end,
            $work_start,
            $work_end,
            $passport_start,
            $passport_end

        ), 'labour'.date('d-m-Y').'.xlsx');
        
    }
    
   
    

}

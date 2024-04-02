<?php

namespace App\Http\Controllers\dashboards;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Labours\LabourModel;
use App\Http\Controllers\Controller;

class dashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $countLabourTotal = LabourModel::count();
        $countLabourStatusActivateTotal = LabourModel::where('labour.labour_status','N')->count();

        $ExpirePassport = LabourModel::leftJoin('company','company.company_id','=','labour.labour_company')
        ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
        ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
        ->where('labour.labour_passport_date_end','<=',Carbon::now()->addDays(15)) 
        ->where('labour.labour_status','Y')
        ->groupBy('labour.labour_id')
        ->paginate(10);

        $ExpireVisa = LabourModel::leftJoin('company','company.company_id','=','labour.labour_company')
        ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
        ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
        ->where('labour.labour_visa_date_end','<=', Carbon::now()->addDays(15)) 
        ->where('labour.labour_status','Y')
        ->groupBy('labour.labour_id')
        ->paginate(10);

        $ExpireWork = LabourModel::leftJoin('company','company.company_id','=','labour.labour_company')
        ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
        ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
        ->where('labour.labour_work_permit_date_end','<=', Carbon::now()->addDays(15)) 
        ->where('labour.labour_status','Y')
        ->groupBy('labour.labour_id')
        ->paginate(10);

        $Expire90day = LabourModel::leftJoin('company','company.company_id','=','labour.labour_company')
        ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
        ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
        ->where('labour.labour_ninety_date_end','<=', Carbon::now()->addDays(15)) 
        ->where('labour.labour_status','Y')
        ->groupBy('labour.labour_id')
        ->paginate(10);

        return view('dashboards.index',compact('countLabourTotal','ExpirePassport','ExpireVisa','ExpireWork','Expire90day','countLabourStatusActivateTotal'));
    }
}

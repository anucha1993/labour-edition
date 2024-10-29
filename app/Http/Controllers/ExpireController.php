<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Labours\LabourModel;
class ExpireController extends Controller
{
    //

    public function index(Request $request)
    {
        $import = DB::table('import')->get();
        $company = DB::table('company')->where('company_name','!=','')->select('company.company_id','company.company_name')->latest()->get();
          
        $data = 0;

    if($request->company_id){
        $data = LabourModel::leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
            //ตามบริษัท
            ->when($request->company_id != 'all', function ($query) use ($request) {
                return $query->where('company.company_id', $request->company_id);
            })
            //ตามกลุ่มนำเข้า
            ->when($request->import_id != 'all', function ($query)  use ($request){
                return $query->where('labour.import_id', $request->import_id);
            })
            //สถานะทำงาน
            ->when($request->status === 'job', function ($query)  use ($request){
                return $query->where('labour.labour_work', '=', 'Y')
                ->where('labour.labour_resign', '!=', 'Y')
                ->where('labour.labour_status', '=', 'Y');
            })
            //สถานะหลบหนี
            ->when($request->status === 'escape', function ($query) use ($request) {
                return $query->where('labour.labour_escape', 'Y')
                ->where('labour.labour_status', '=', 'Y');
            })
            //สถานะลาออก
            ->when($request->status === 'resign', function ($query) use ($request) {
                return $query->where('labour.labour_resign', 'Y')
                ->where('labour.labour_status', '=', 'Y');
            })

            //Passport CI
            ->when($request->passport_ci === 'CC', function ($query) use ($request) {
                return $query->where('labour.labour_passport_number', 'LIKE', 'CC%');
            })

             //
             ->when($request->status != 'all' , function ($query) use ($request) {
                return $query->where('labour.labour_status', '=', 'Y');
            })

            // 90 วัน
            ->when($request->import_id != 'all', function ($query) use ($request) {
                return $query->where('labour.import_id', $request->import_id);
            })

            ->when($request->ninety_day_start !== null && $request->ninety_day_end !== null, function ($query) use ($request){
                return $query->whereDate('labour_ninety_date_end', '>=', $request->ninety_day_start)
                             ->whereDate('labour_ninety_date_end', '<=', $request->ninety_day_end);
            })

            ->when($request->visa_start !== null && $request->visa_end !== null, function ($query)use ($request) {
                return $query->whereDate('labour_visa_date_end', '>=', $request->visa_start)
                             ->whereDate('labour_visa_date_end', '<=', $request->visa_end);
            })

            ->when($request->work_start !== null && $request->work_end !== null, function ($query) use ($request){
                return $query->whereDate('labour_work_permit_date_end', '>=', $request->work_start)
                             ->whereDate('labour_work_permit_date_end', '<=', $request->work_end);
            })

            ->when($request->passport_start !== null && $request->passport_end !== null, function ($query) use ($request){
                return $query->whereDate('labour_passport_date_end', '>=', $request->passport_start)
                             ->whereDate('labour_passport_date_end', '<=', $request->passport_end);
            })



            ->orderBy('labour.labour_id')
            ->count();
    }else{
        $data = 0;
    }
       
            
        return view('expire.index',compact('company','import','data','request'));
    }
    
}

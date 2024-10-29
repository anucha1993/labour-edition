<?php

namespace App\Http\Controllers\dashboards;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Labours\LabourModel;
use App\Http\Controllers\Controller;
use App\Models\customer\CustomerModel;
use App\Models\laModel;

class dashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $countLabourTotal = LabourModel::count();
        $countLabourStatusActivateTotal = LabourModel::where('labour.labour_status', 'N')->count();


        $ExpirePassport = LabourModel::select('company.company_name', 'company.company_id')
            ->leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
            //กำหนดเวลาแจ้งเตือน Passport ก่อนหมดอายุ 60 วัน
            ->where('labour.labour_passport_date_end', '<=', Carbon::now()->addDays(60))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_passport_company_manage', 'N')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_escape', 'N')
            ->groupBy('company.company_id')
            ->select('company.company_name', 'company.company_id', DB::raw('count(labour.labour_id) as labour_count'));

        // ตรวจสอบว่ามีการค้นหาหรือไม่ หากมีให้กรองข้อมูลตามคำค้นหา
        if (!empty($keyword)) {
            $ExpirePassport = $ExpirePassport->where(function ($query) use ($keyword) {
                $query->where('company.company_name', 'LIKE', "%$keyword%");
            });
        }

        $ExpirePassport  = $ExpirePassport->paginate(10);

        $TotalExpirePassport =  LabourModel::select('labour_id')
            //กำหนดเวลาแจ้งเตือน Passport ก่อนหมดอายุ 60 วัน
            ->where('labour.labour_passport_date_end', '<=', Carbon::now()->addDays(60))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_passport_company_manage', 'N')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_escape', 'N')
            ->count();



        $ExpireVisa = LabourModel::select('company.company_name', 'company.company_id')
            ->leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
            //กำหนดเวลาแจ้งเตือน Visa ก่อนหมดอายุ 30 วัน
            ->where('labour.labour_visa_date_end', '<=', Carbon::now()->addDays(30))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_visa_company_manage', 'N')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_escape', 'N')
            ->groupBy('company.company_id')
            ->select('company.company_name', 'company.company_id', DB::raw('count(labour.labour_id) as labour_count'));

        // ตรวจสอบว่ามีการค้นหาหรือไม่ หากมีให้กรองข้อมูลตามคำค้นหา
        if (!empty($keyword)) {
            $ExpireVisa = $ExpireVisa->where(function ($query) use ($keyword) {
                $query->where('company.company_name', 'LIKE', "%$keyword%");
            });
        }

        $ExpireVisa  = $ExpireVisa->paginate(10);



        $TotalExpireVisa =  LabourModel::select('labour_id')
            //กำหนดเวลาแจ้งเตือน Visa ก่อนหมดอายุ 30 วัน
            ->where('labour.labour_visa_date_end', '<=', Carbon::now()->addDays(30))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_visa_company_manage', 'N')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_escape', 'N')
            ->count();


        $ExpireWork = LabourModel::select('company.company_name', 'company.company_id')
            ->leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
            //กำหนดเวลาแจ้งเตือน Work ก่อนหมดอายุ 30 วัน
            ->where('labour.labour_work_permit_date_end', '<=', Carbon::now()->addDays(30))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_work_permit_company_manage', 'N')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_escape', 'N')
            ->groupBy('company.company_id')
            ->select('company.company_name', 'company.company_id', DB::raw('count(labour.labour_id) as labour_count'));
        // ตรวจสอบว่ามีการค้นหาหรือไม่ หากมีให้กรองข้อมูลตามคำค้นหา
        if (!empty($keyword)) {
            $ExpireWork = $ExpireWork->where(function ($query) use ($keyword) {
                $query->where('company.company_name', 'LIKE', "%$keyword%");
            });
        }

        $ExpireWork  = $ExpireWork->paginate(10);

        $TotalExpireWork =  LabourModel::select('labour_id')
            //กำหนดเวลาแจ้งเตือน Work ก่อนหมดอายุ 30 วัน
            ->where('labour.labour_work_permit_date_end', '<=', Carbon::now()->addDays(30))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_work_permit_company_manage', 'N')
            ->where('labour.labour_escape', 'N')
            ->count();


        $Expire90day = LabourModel::select('company.company_name', 'company.company_id')
            ->leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
            //กำหนดเวลาแจ้งเตือน 90Day ก่อนหมดอายุ 15 วัน
            ->where('labour.labour_ninety_date_end', '<=', Carbon::now()->addDays(15))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_ninety_company_manage', 'N')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_escape', 'N')
            ->groupBy('company.company_id')
            ->select('company.company_name', 'company.company_id', DB::raw('count(labour.labour_id) as labour_count'));
        // ตรวจสอบว่ามีการค้นหาหรือไม่ หากมีให้กรองข้อมูลตามคำค้นหา
        if (!empty($keyword)) {
            $Expire90day = $Expire90day->where(function ($query) use ($keyword) {
                $query->where('company.company_name', 'LIKE', "%$keyword%");
            });
        }

        $Expire90day  = $Expire90day->paginate(10);


        $TotalExpire90day =  LabourModel::select('labour_id')
            //กำหนดเวลาแจ้งเตือน 90Day ก่อนหมดอายุ 15 วัน
            ->where('labour.labour_ninety_date_end', '<=', Carbon::now()->addDays(15))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_ninety_company_manage', 'N')
            ->where('labour.labour_escape', 'N')
            ->count();

        return view('dashboards.index', compact('TotalExpire90day', 'TotalExpirePassport', 'TotalExpireWork', 'TotalExpireVisa', 'countLabourTotal', 'ExpirePassport', 'ExpireVisa', 'ExpireWork', 'Expire90day', 'countLabourStatusActivateTotal'));
    }

    public function ModalshowPassport(Request $request)
    {
        $expireType = $request->ExpireType;
        $labours = LabourModel::where('labour_company', $request->company)
            ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
            ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
            ->where('labour_passport_date_end', '<=', Carbon::now()->addDays(60))
            ->where('labour.labour_passport_company_manage', 'N')
            ->where('labour_status', 'Y')
            ->where('labour_resign', 'N')
            ->where('labour_escape', 'N')
            ->get();
        $company = CustomerModel::select('company_name','company_id')->where('company_id', $request->company)->first();


        return  view('dashboards.modal-passport-expire', compact('labours', 'company'));
    }

    public function ModalshowVisa(Request $request)
    {
        $expireType = $request->ExpireType;
        $labours = LabourModel::where('labour_company', $request->company)
            ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
            ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
            ->where('labour_visa_date_end', '<=', Carbon::now()->addDays(30))
            ->where('labour.labour_visa_company_manage', 'N')
            ->where('labour_status', 'Y')
            ->where('labour_resign', 'N')
            ->where('labour_escape', 'N')
            ->get();
        $company = CustomerModel::select('company_name','company_id')->where('company_id', $request->company)->first();

        return  view('dashboards.modal-visa-expire', compact('labours', 'company'));
    }
    public function ModalshowWork(Request $request)
    {
        $expireType = $request->ExpireType;
        $labours = LabourModel::where('labour_company', $request->company)
            ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
            ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
            ->where('labour_work_permit_date_end', '<=', Carbon::now()->addDays(30))
            ->where('labour.labour_work_permit_company_manage', 'N')
            ->where('labour_status', 'Y')
            ->where('labour_resign', 'N')
            ->where('labour_escape', 'N')
            ->get();
        $company = CustomerModel::select('company_name','company_id')->where('company_id', $request->company)->first();

        return  view('dashboards.modal-work-expire', compact('labours', 'company'));
    }

    public function ModalshowNinety(Request $request)
    {
        $expireType = $request->ExpireType;
        $labours = LabourModel::where('labour_company', $request->company)
            ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
            ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
            ->where('labour_ninety_date_end', '<=', Carbon::now()->addDays(15))
            ->where('labour_status', 'Y')
            ->where('labour.labour_ninety_company_manage', 'N')
            ->where('labour_resign', 'N')
            ->where('labour_escape', 'N')
            ->get();
        $company = CustomerModel::select('company_name','company_id')->where('company_id', $request->company)->first();

        return  view('dashboards.modal-ninety-expire', compact('labours', 'company'));
    }

    public function alertNotifyAction(Request $request)
    {
        $TotalExpirePassport =  LabourModel::select('labour_id')
        //กำหนดเวลาแจ้งเตือน Passport ก่อนหมดอายุ 60 วัน
        ->where('labour.labour_passport_date_end', '<=', Carbon::now()->addDays(60))
        ->where('labour.labour_status', 'Y')
        ->where('labour.labour_resign', 'N')
        ->where('labour.labour_escape', 'N')
        ->count();

      
        $TotalExpireVisa =  LabourModel::select('labour_id')
            //กำหนดเวลาแจ้งเตือน Visa ก่อนหมดอายุ 30 วัน
            ->where('labour.labour_visa_date_end', '<=', Carbon::now()->addDays(30))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_escape', 'N')
            ->count();

            $TotalExpireWork =  LabourModel::select('labour_id')
            //กำหนดเวลาแจ้งเตือน Work ก่อนหมดอายุ 30 วัน
            ->where('labour.labour_work_permit_date_end', '<=', Carbon::now()->addDays(30))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_escape', 'N')
            ->count();

            $TotalExpire90day =  LabourModel::select('labour_id')
            //กำหนดเวลาแจ้งเตือน 90Day ก่อนหมดอายุ 15 วัน
            ->where('labour.labour_ninety_date_end', '<=', Carbon::now()->addDays(15))
            ->where('labour.labour_status', 'Y')
            ->where('labour.labour_resign', 'N')
            ->where('labour.labour_escape', 'N')
            ->count();

            return response()->json(['TotalExpirePassport'=> $TotalExpirePassport, 'TotalExpireWork'=> $TotalExpireWork,'TotalExpire90day'=> $TotalExpire90day,'TotalExpireVisa'=> $TotalExpireVisa]);

    }


}

<?php

namespace App\Http\Controllers\labours;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Models\Labours\LabourModel;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Models\labours\AddressLabourModel;

class LabourController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $keyword = $request->input('search');
        $labours = LabourModel::select(
            'labour.labour_id',
            'labour.labour_name',
            'import.import_name',
            'labour.labour_visa_number',
            'labour.labour_passport_number',
            'labour.labour_passport_date_end',
            'labour.labour_visa_date_end',
            'labour.labour_ninety_date_end',
            'company.company_name',
            'nationality.nationality_flag',
            'labour.labour_status',
            'labour.labour_escape',
            'labour.labour_resign',
        )
            ->leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
            ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
            ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality');
           
        // ตรวจสอบว่ามีการค้นหาหรือไม่ หากมีให้กรองข้อมูลตามคำค้นหา
        if (!empty($keyword)) {
            $labours = $labours->where(function ($query) use ($keyword) {
                $query->where('labour.labour_passport_number', 'LIKE', "%$keyword%")
                    ->orWhere('labour.labour_visa_number', 'LIKE', "%$keyword%")
                    ->orWhere('labour.labour_name', 'LIKE', "%$keyword%")
                    ->orWhere('company.company_name', 'LIKE', "%$keyword%")
                    ->orWhere('labour.labour_passport_date_end', 'LIKE', "%$keyword%")
                    ->orWhere('labour.labour_visa_date_end', 'LIKE', "%$keyword%")
                    ->orWhere('labour.labour_ninety_date_end', 'LIKE', "%$keyword%");
            });
        }
        $labours = $labours->where('labour.labour_passport_number','!=', '');

        $labours = $labours->orderByDesc('labour.labour_id')->paginate(10); // แสดงข้อมูลทีละ 30 รายการ

        return view('labours.index', compact('labours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $import = DB::table('import')->get();
        $agents = DB::table('agent')->get();
        $nationality = DB::table('nationality')->get();
        $companys = DB::table('company')->get();
        $provinces = DB::table('provinces')->get();
        return view('labours.form-add', compact('agents', 'nationality', 'companys','import','provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // เช็ค passport ซ้ำ 
        $pass = LabourModel::where('labour_passport_number',$request->labour_passport_number)->count();
        if($pass > 0)
        {
            return redirect()->back()->with('error','บันทึกข้อมูลล้มเหลว เนื่องจากข้อมูล Passport ซ้ำกันกับระบบ');
        }
        // เช็ค Visa ซ้ำ 
        $visa = LabourModel::where('labour_visa_number',$request->labour_visa_number)->count();
        if($visa > 0)
        {
            return redirect()->back()->with('error','บันทึกข้อมูลล้มเหลว เนื่องจากข้อมูล Visa ซ้ำกันกับระบบ');
        }
        //
        // dd($request);
        $findNumber = LabourModel::latest()->where('labour_number','!=',NULL)->value('labour_number');
        // ถ้าไม่มีข้อมูลในตาราง
        if($findNumber === Null)
        {
           $number = 1;
        }else{
            $explode = explode('-',$findNumber);
            $number = $explode[1] + 1;
        }
        $Seq = substr('00000000'.$number, -8,8);
        $NewNumber = 'CUS-'.$Seq;

        $request->merge(['labour_number'=> $NewNumber]);
        $request->merge(['labour_user_add'=> Auth::user()->name]);

        $labourID = LabourModel::create($request->all());

        if($request->addr_province) 
        {
            AddressLabourModel::create([
                'labour_id'         => $labourID->labour_id,
                'labour_passport'   => $request->labour_passport_number,
                'addr_number'       => $request->addr_number,
                'addr_province'     => $request->addr_province,
                'addr_amphur'       => $request->addr_amphur,
                'addr_distict'      => $request->addr_distict,
                'addr_zipcode'      => $request->addr_zipcode,
                'addr_note'         => $request->addr_note,
                'addr_user_add'     => Auth::user()->name,
                'addr_status'       => 'Y',
            ]);
        }


        return redirect()->route('labour.index')->with('success','เพิ่มข้อมูลคนงานสำเร็จ!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LabourModel $labourModel)
    {
        //
        $import = DB::table('import')->get();
        $agents = DB::table('agent')->get();
        $nationality = DB::table('nationality')->get();
        $companys = DB::table('company')->get();
        $labourAddr = DB::table('address_labour')
        ->where('labour_id',$labourModel->labour_id)
        ->leftJoin('districts', 'districts.DISTRICT_CODE','address_labour.addr_distict')
        ->leftJoin('amphures', 'amphures.AMPHUR_ID','address_labour.addr_amphur')
        ->leftJoin('provinces', 'provinces.PROVINCE_ID','address_labour.addr_province')
        ->first();


        

        $ComAddr = DB::table('company')
        ->where('company_id',$labourModel->labour_company)
        ->leftJoin('districts', 'districts.DISTRICT_CODE','company.company_district')
        ->leftJoin('amphures',  'amphures.AMPHUR_ID',   'company.company_area')
        ->leftJoin('provinces', 'provinces.PROVINCE_ID', 'company.company_province')
        ->first();

        if($ComAddr){
            $AddressCompany =   $ComAddr->company_house_number.' '
                               .($ComAddr->company_alley !== NULL ? $ComAddr->company_alley : '').' '
                               .$ComAddr->DISTRICT_NAME.' '
                               .$ComAddr->AMPHUR_NAME.' '
                               .$ComAddr->PROVINCE_NAME.' '
                               .$ComAddr->company_zipcode;
        }else{
            $AddressCompany = 'ไม่พบข้อมูล';
        }

        if($labourAddr){
            $AddressLabour = $labourAddr->addr_number.' '
                            .$labourAddr->DISTRICT_NAME.' '
                            .$labourAddr->AMPHUR_NAME.' '
                            .$labourAddr->PROVINCE_NAME.' '
                            .$labourAddr->addr_zipcode;
        }else{
            $AddressLabour = 'ไม่พบข้อมูล';
        }

        $provinces = DB::table('provinces')->get();

        return view('labours.form-edit', compact('agents', 'nationality','labourAddr','provinces',
                    'companys','labourModel','import','AddressLabour','AddressCompany','ComAddr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LabourModel $labourModel)
    {
       
        // 
        if($request->labour_escape === null){
            $request->merge(['labour_escape'=> "N"]);
        }
        if($request->labour_resign === null){
            $request->merge(['labour_resign'=> "N"]);
        }
        if($request->labour_work === null){
            $request->merge(['labour_work'=> "N"]);
        }
        if($request->labour_status === null){
            $request->merge(['labour_status'=> "N"]);
        }
        //dd($request->labour_status);
        //dd($request);
        $request->merge(['labour_user_edit'=> Auth::user()->name]);
        $labourModel->update($request->all());
        //บันทึก Log
        activity()
        ->performedOn($labourModel)
        ->tap(function ($activity) use ($labourModel) {
            // กำหนดข้อมูลในฟิลด์ที่ต้องการ
            $activity->causer_type  = Auth::user()->name;
            $activity->log_name     = 'labour';
            $activity->subject_type = 'form-edit';
            $activity->event        = 'updated';
            $activity->properties   = $labourModel;
        })
        ->log($labourModel->labour_name . ',' . $labourModel->labour_passport_number);
      
        $addrLabour = DB::table('address_labour')->where('labour_id',$request->labour_id)->count();

        // ที่อยู่คนงาน
        if($request->addr_province) {
            if($addrLabour > 0)
            {
                AddressLabourModel::where('labour_id',$request->labour_id)
                ->update([
                    'labour_id'         => $request->labour_id,
                    'labour_passport'   => $request->labour_passport_number,
                    'addr_number'       => $request->addr_number,
                    'addr_province'     => $request->addr_province,
                    'addr_amphur'       => $request->addr_amphur,
                    'addr_distict'      => $request->addr_distict,
                    'addr_zipcode'      => $request->addr_zipcode,
                    'addr_note'         => $request->addr_note,
                    'addr_user_update'  => Auth::user()->name,
                    'addr_status'       => 'Y',
                ]);
            }else{
                AddressLabourModel::create([
                    'labour_id'         => $request->labour_id,
                    'labour_passport'   => $request->labour_passport_number,
                    'addr_number'       => $request->addr_number,
                    'addr_province'     => $request->addr_province,
                    'addr_amphur'       => $request->addr_amphur,
                    'addr_distict'      => $request->addr_distict,
                    'addr_zipcode'      => $request->addr_zipcode,
                    'addr_note'         => $request->addr_note,
                    'addr_user_add'     => Auth::user()->name,
                    'addr_status'       => 'Y',
                ]);
            }
        }
        

        return redirect()->back()->with('success','แก้ไขข้อมูลสำเร็จ!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}

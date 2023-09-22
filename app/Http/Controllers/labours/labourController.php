<?php

namespace App\Http\Controllers\labours;

use App\Http\Controllers\Controller;
use App\Models\Labours\LabourModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

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

        // if($request->all())
        // {
        //     $data = DB::table('labour')->select('labour.labour_passport_number')->limit(10);
        //     return Datatables::of($data)
        //     ->make();
        // }



        $keyword = $request->input('search');

        $labours = LabourModel::select(
            'labour.labour_id',
            'labour.labour_name',
            'labour.labour_visa_number',
            'labour.labour_passport_number',
            'labour.labour_passport_date_end',
            'labour.labour_visa_date_end',
            'labour.labour_ninety_date_end',
            'company.company_name'
        )
            ->leftJoin('company', 'company.company_id', '=', 'labour.labour_company');
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

        $labours = $labours->orderByDesc('labour.labour_id')->paginate(20); // แสดงข้อมูลทีละ 30 รายการ

        return view('labours.index', compact('labours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $agents = DB::table('agent')->get();
        $nationality = DB::table('nationality')->get();
        $companys = DB::table('company')->get();
        return view('labours.form-add', compact('agents', 'nationality', 'companys'));
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
        $findNumber = LabourModel::latest()->value('labour_number');
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

        LabourModel::create($request->all());
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

        $agents = DB::table('agent')->get();
        $nationality = DB::table('nationality')->get();
        $companys = DB::table('company')->get();
        return view('labours.form-edit', compact('agents', 'nationality', 'companys','labourModel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LabourModel $labourModel)
    {
        // 
        $request->merge(['labour_user_edit'=> Auth::user()->name]);
        $labourModel->update($request->all());
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

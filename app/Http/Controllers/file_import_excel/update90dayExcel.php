<?php

namespace App\Http\Controllers\file_import_excel;

use Illuminate\Http\Request;
use App\Models\Labours\LabourModel;
use App\Http\Controllers\Controller;
use App\Imports\labours\update90day;
use App\Models\labours\update90dayModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class update90dayExcel extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function index()
    {
        $excelData = [];
        $result = NULL;
        return view('file-import.update90day',compact('excelData','result'));
    }

    public function import(Request $request)
    {
        $labourPassNum = [];
        $result = NULL;
        $file = $request->file('file-excel');
        $import = new update90day();
        Excel::import($import,$file);
        $excelData = $import->getExcelData();
        foreach ($excelData as $key => $v)
        {
            $labourPassNum[] = $v[0];
        }
        
        return view('file-import.update90day',compact('excelData','result'));
    }

    public function update90day(Request $request)
    {
       //dd($request);
       $passP = [];
       foreach ($request->labour_passport_number as $key => $v)
       {
        //labour
         LabourModel::where('labour_passport_number',$request->labour_passport_number[$key])
        ->update([
            'labour_ninety_date_start' => date('Y-m-d', strtotime($request->labour_ninety_date_start[$key])),
            'labour_ninety_date_end'   => date('Y-m-d', strtotime($request->labour_ninety_date_end[$key])),
            'labour_user_edit'         => Auth::user()->name,
        ]);
        // add 90day
        update90dayModel::create([
            'labour_id'        => $request->labour_id[$key],
            'labour_passport'  => $request->labour_passport_number[$key],
            'ninety_date_start'=> date('Y-m-d',strtotime($request->labour_ninety_date_start[$key])),
            'ninety_date_end'  => date('Y-m-d',strtotime($request->labour_ninety_date_end[$key])),
            'ninety_note'      => $request->ninety_note[$key],
            'ninety_user_add'  => Auth::user()->name,
        ]);


        $excelData =NULL;
        $labours =  LabourModel::select('*')->where('labour_passport_number',$request->labour_passport_number[$key])->first();
        $passP[] = $labours->labour_passport_number;

        
         //บันทึก Log
         activity()
         ->performedOn($labours)
         ->tap(function ($activity) use ($labours) {
             // กำหนดข้อมูลในฟิลด์ที่ต้องการ
             $activity->causer_type  = Auth::user()->name;
             $activity->log_name     = 'labour';
             $activity->subject_type = 'import-excel';
             $activity->event        = 'update90day';
             $activity->properties   = $labours;
         })
         ->log($labours->labour_name . ',' . $labours->labour_passport_number);


       }
       $result = LabourModel::whereIn('labour_passport_number',$passP)->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')->get();
      // dd($result);
       return view('file-import.update90day',compact('excelData','result'));
    }
}

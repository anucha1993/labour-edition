<?php

namespace App\Http\Controllers\file_import_excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\labours\labourImportDepartmentEmployeeID;
use App\Models\Labours\LabourModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class labourDepartmantEmployeeIDExcel extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $excelData = NULL;
        $success = NULL;
        return view('file-import.labour-department-employeeid', compact('excelData','success'));
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $import = new labourImportDepartmentEmployeeID();
        Excel::import($import, $file);

        // เอาข้อมูลใน $excelData มาใช้ในการค้นหาข้อมูลในฐานข้อมูล
        $labourPassNum = [];
        $excelData = $import->getExcelData();
        foreach ($excelData as $key => $v) {
            $labourPassNum[] = $v[0];
        }
        $success =  NULL;

        // ดึงข้อมูลจากฐานข้อมูลโดยใช้ passport numbers ที่มาจาก Excel
        $LabourModel = LabourModel::select('labour_passport_number', 'labour_name')->whereIn('labour_passport_number', $labourPassNum)->get();


        return view('file-import.labour-department-employeeid', compact('excelData', 'LabourModel','success'));
    }


    public function update(Request $request)
    {
        // dd($request);
        foreach ($request->labour_passport_number as $key => $value) {
            LabourModel::where('labour_passport_number', $request->labour_passport_number[$key])
                ->update([
                    'labour_code' => $request->labour_code[$key],
                    'labour_department' => $request->labour_department[$key],
                    'labour_user_edit' => Auth::user()->name,
                ]);
        }
        $excelData = [];
        $LabourModel = [];
       
        if($request->labour_passport_number != NULL)
        {
            $success =  'Update Successfully';
        }else{
            $success = NULL;
        }
      

        return view('file-import.labour-department-employeeid', compact('excelData', 'LabourModel','success'));
    }
}

<?php

namespace App\Http\Controllers\file_import_excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\labours\AddressLabourImport;
use App\Models\labours\AddressLabourModel;
use App\Models\Labours\LabourModel;
use Illuminate\Support\Facades\Auth;

class AddressLabourExcel extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $excelData = [];
        $status = NULL;
        return  view('file-import.address-labour',compact('excelData','status'));
    }

    public function import(Request $request)
    {
        $file = $request->file('file-excel');
        $import = new AddressLabourImport();
        Excel::import($import,$file);
        $excelData = $import->getExcelData();
        $status = NULL;

        
        return  view('file-import.address-labour',compact('excelData','status'));

    }

    public function store(Request $request)
    {

      foreach ($request->labour_id as $key => $v)
      {
        $labourCheck = AddressLabourModel::where('labour_passport',$request->labour_passport[$key])->count();
        if ($labourCheck === 0)
        {
             //ถ้าไม่มีข้อมูลให้  Create
            AddressLabourModel::create([
            'labour_id'      => $request->labour_id[$key],
            'labour_passport'=> $request->labour_passport[$key],
            'addr_number'    => $request->addr_number[$key],
            'addr_province'  => $request->addr_province[$key],
            'addr_amphur'    => $request->addr_amphur[$key],
            'addr_distict'   => $request->addr_distict[$key],
            'addr_zipcode'   => $request->addr_zipcode[$key],
            'addr_note'      => $request->addr_note[$key],
            'addr_user_add'  => Auth::user()->name,
            'addr_status'    => "Y",
            ]);
        }else{
            //ถ้าข้อมูลมีอยู่แล้วให้ Update
            AddressLabourModel::where('labour_passport',$request->labour_passport[$key])
            ->update([
                'labour_id'       => $request->labour_id[$key],
                'labour_passport' => $request->labour_passport[$key],
                'addr_number'     => $request->addr_number[$key],
                'addr_province'   => $request->addr_province[$key],
                'addr_amphur'     => $request->addr_amphur[$key],
                'addr_distict'    => $request->addr_distict[$key],
                'addr_zipcode'    => $request->addr_zipcode[$key],
                'addr_note'       => $request->addr_note[$key],
                'addr_user_update'=> Auth::user()->name,
                'addr_status'     => "Y",
            ]);
        }
       
      }
      $excelData = [];
      $status = "success";
      return  view('file-import.address-labour',compact('excelData','status'));
    }

}

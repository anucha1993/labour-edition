<?php

namespace App\Http\Controllers\file_import_excel;

use App\Http\Controllers\Controller;
use App\Imports\labours\labourImport ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\UsersImport;
use App\Models\laModel;
use Maatwebsite\Excel\Facades\Excel;

class labourImportExcel extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $company = DB::table('company')->get();
        $agents = DB::table('agent')->get();
        $nationality = DB::table('nationality')->get();
        return view('file-import.labour-excel-import',compact('company','agents','nationality'));
    }

    public function import(Request $request)
    {
        $company = $request->company;
        $agency  = $request->agency;
        $nationality = $request->nationality;

        $file = $request->file('file-excel');
        $import = new labourImport($company, $agency, $nationality);

        Excel::import($import, $file);

        $importedIds = $import->getImportedIds();
        $IDsimpoert = implode(', ', $importedIds);
    
        return redirect()->route('excelImport.checkLabour', ['importedIds' => $IDsimpoert])->with('success', 'นำเข้าข้อมูลสำเร็จ!');
    }


    public function checkLabour(Request $request)
    {

        $importedIds = $request->input('importedIds');
        $importedIdsArray = explode(', ', $importedIds);
        $las = DB::table('labour')
        ->leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
        ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
        ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
        ->whereIn('labour_id',$importedIdsArray)->get();
    
        // ทำสิ่งที่คุณต้องการกับ $importedIdsArray
        // ตัวอย่าง: ส่งค่า ID ไปยังมุมมอง
        $countLas = $las->count();
        return view('file-import.check-import-labour', compact('las','countLas'));
    }
    

}

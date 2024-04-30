<?php

namespace App\Http\Controllers\file_import_excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\labours\LabourCustomImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportLabourCustomController extends Controller
{
    //
    protected $labourAll = [];
    protected $dataColumn = [];

    public function import(Request $request)
    {
        $file = $request->file('file-excel');
        $import = new LabourCustomImport();
        Excel::import($import, $file);
    
        $labourAll = $import->getExcelData();
        $dataColumn = $import->getExcelColumns();


        return redirect()->route('import.returnForm', compact('labourAll', 'dataColumn'));
    }
    
    public function returnForm(Request $request) 
    {
        $dataColumnThai = [];
        $labourAll = $request->labourAll;
        $dataColumn = $request->dataColumn;
        
        $labour = DB::table('labour')->whereIn('labour_passport_number',$labourAll)
        ->leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
        ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
        ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
        ->get();

        return view('custom_form_import.form-return', compact('labourAll', 'dataColumn','labour'));
    }
}

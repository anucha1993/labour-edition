<?php

namespace App\Http\Controllers\import_custom;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\customer\CustomerModel;
use App\Models\importGroup\importGroupModel;
use App\Exports\create_form_import\createFromExcel;

class createFormImportController extends Controller
{
  //

  public function index(Request $request)
  {
    $customer = CustomerModel::orderBy('company_id','desc')->get();
    $importGroup = importGroupModel::orderBy('import_id','desc')->get();
    $nationality = DB::table('nationality')->orderBy('nationality_id','desc')->get();
    $agent = DB::table('agent')->orderBy('agent_id','desc')->get();
    $provinces = DB::table('provinces')->get();
    return view('custom_form_import.form-custom-import',compact('customer','importGroup','nationality','agent','provinces'));
  }

  public function export(Request $request)
  {
    return Excel::download(new createFromExcel($request->all()), 'form-custom-import-' . date('d-m-Y') . '.xlsx');
  }

}

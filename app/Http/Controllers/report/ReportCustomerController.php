<?php

namespace App\Http\Controllers\report;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\customer\CustomerModel;
use App\Exports\customer\CustomerExcel;

class ReportCustomerController extends Controller
{
    //

    public function index()
    {
        $customers = CustomerModel::all();
        $provinces = DB::table('provinces')->get();
        return view('reports.form-report-customer',compact('provinces','customers'));
    }

    public function export(Request $request) 
    {
    
        $province = $request->province;
        $customer = $request->customer;
        return Excel::download(new CustomerExcel($province,$customer), 'customer-'.date('d-m-Y').'.xlsx');
    }


}

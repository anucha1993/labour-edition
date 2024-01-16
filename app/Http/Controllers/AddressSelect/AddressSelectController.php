<?php

namespace App\Http\Controllers\AddressSelect;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AddressSelectController extends Controller
{
    //
     function provinces(Request $request){
        $province_id =  $request->get('select');
        $amphures = DB::connection('mysql')->table('amphures')->where('PROVINCE_ID', $province_id)->get();
        $output = '<option>Select a amphures</option>';
        foreach ($amphures as $value)
        {
            $output.='<option value="'.$value->AMPHUR_ID.'" >'.$value->AMPHUR_NAME.'</option>';
        }
        return $output;
    }
    
    function amphures(Request $request){

        $districts = DB::connection('mysql')->table('districts')->where('AMPHUR_ID',$request->select)->get();
        $output = '<option>Select a district </option>';
        foreach ($districts as $value){
            $output.='<option value="'.$value->DISTRICT_CODE.'" >'.$value->DISTRICT_NAME.'</option>';
        }

        echo $output;
    }
    function districts(Request $request){
        $districts = DB::connection('mysql')->table('zipcodes')->where('district_code',$request->select)->first();
        $output =  $districts->zipcode;
        echo $output;
    }
 
}

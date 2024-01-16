<?php

namespace App\Http\Controllers\AddressShow;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AddressShowController extends Controller
{
    //

    function address(Request $request){
        $company_id =  $request->get('select');
        $company = DB::table('company')->where('company_id',  $company_id)->first();
        
        $amphur = DB::table('amphures')->select('AMPHUR_NAME')->where('AMPHUR_ID',$company->company_area)->first();
         $district = DB::table('districts')->select('DISTRICT_NAME')->where('DISTRICT_CODE',$company->company_district)->first();
         $province = DB::table('provinces')->select('PROVINCE_NAME')->where('PROVINCE_ID',$company->company_province)->first();
         $zipcodes = DB::table('zipcodes')->where('district_code',$company->company_district)->first();
          
         $output = [
         'company' => $company,
         'amphur' => $amphur,
         'district' => $district,
         'province'=> $province,
         'zipcodes'=> $zipcodes
        ];
        return $output;
    }
}

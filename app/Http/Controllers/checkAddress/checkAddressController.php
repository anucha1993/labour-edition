<?php

namespace App\Http\Controllers\checkAddress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class checkAddressController extends Controller
{
    //

    public function check(Request $request)
    {
        $keywords = $request->parts;
        
        // สร้าง Query Builder จากตาราง provinces
    
        
        // วนลูปคำสำหรับคำค้นหาแต่ละคำ
        foreach ($keywords as $keyword) {
           
            // เพิ่มเงื่อนไข WHERE หรือ WHERE ต่อเนื่องกับคำที่พบ
            $provinces =  DB::table('provinces')->Where('PROVINCE_NAME',  'LIKE', "%$keyword%")->first();
        }

            $amphur = DB::table('amphures')->where('PROVINCE_ID', $provinces->PROVINCE_ID)->whereIn('AMPHUR_NAME',$keywords)->first();
            $district = DB::table('districts')->where('AMPHUR_ID', $amphur->AMPHUR_ID)->whereIn('DISTRICT_NAME',$keywords)->first();

            if($district === NULL) {
                $district = (object)['DISTRICT_CODE' => ''];
            }
            $zipcode =  DB::table('zipcodes')->Where('district_code',$district->DISTRICT_CODE)->first();
            

        return response()->json(['provinces' => $provinces, 'amphur' => $amphur,'district' => $district, 'zipcodes' => $zipcode]);
    }
}

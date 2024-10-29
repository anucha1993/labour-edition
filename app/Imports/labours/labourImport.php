<?php

namespace App\Imports\labours;

use Carbon\Carbon;
use App\Models\laModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Labours\LabourModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\labours\AddressLabourModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class labourImport implements ToCollection, WithStartRow,WithHeadingRow
{
    protected $importedIds = [];
    protected $company = '';
    protected $agency = '';
    protected $nationality = '';


    public function startRow(): int
    {
        return 2; // กำหนดให้เริ่มต้นจากแถวที่ 2
    }

    public function __construct($company, $agency, $nationality)
    {
        $this->company  = $company;
        $this->agency = $agency;
        $this->nationality = $nationality;
        return $this;
    }

    public function collection(Collection $collection)
    {
        $now = Carbon::now();
        //dd($collection);
        foreach ($collection as $row) {

            $PROVINCE_ID = NULL;
            $AMPHUR_ID = NULL;
            $DISTRICT_ID = NULL;
            $zip = NULL;

            if(!empty($row[26])){
                 // จังหวัด 
            $province = DB::table('provinces')->where('PROVINCE_NAME',$row[26])->first();
            if($province === NULL) {
                return redirect()->back()->with('error', 'จังหวัดไม่ถูกต้อง จังหวัด :'.$row[26]);
            }
            $amphur = DB::table('amphures')->where('PROVINCE_ID', $province->PROVINCE_ID)->where('AMPHUR_NAME',$row[25])->first();
            if($amphur === NULL) {
                return redirect()->back()->with('error', 'เขต/อำเภอ ไม่ถูกต้อง เขต/อำเภอ :'.$row[25]);
            }

            $district = DB::table('districts')->where('AMPHUR_ID',$amphur->AMPHUR_ID)->where('DISTRICT_NAME',$row[24])->first();
            if($district === NULL) {
                return redirect()->back()->with('error', 'แขวง/ตำบล ไม่ถูกต้อง แขวง/ตำบล :'.$row[25]);
            }
            $zipcode = DB::table('zipcodes')->where('district_code',$district->DISTRICT_CODE)->first();
            if($zipcode === NULL) {
                return redirect()->back()->with('error', 'รหัสไปรษณีย์ ไม่ถูกต้อง');
            }

            $PROVINCE_ID = $province->PROVINCE_ID;
            $AMPHUR_ID = $amphur->AMPHUR_ID;
            $DISTRICT_CODE = $district->DISTRICT_CODE;
            $zip =  $zipcode->zipcode;
            }
           


            if($row[6] && $row[9] && $row[12] && $row[13])
            {
                $existingRecord = LabourModel::where('labour_passport_number', $row[6])
                ->orwhere('labour_visa_number',$row[9])
                ->orwhere('labour_textid',$row[12])
                ->orwhere('labour_work_permit_number',$row[13])
                ->first();
            }
           
         
            if ($existingRecord) {
                // พบข้อมูลที่ซ้ำ
                dd([$existingRecord->labour_passport_number, $existingRecord->labour_visa_number, $existingRecord->labour_work_permit_number,$existingRecord->labour_textid]);
            } else {
                // ไม่พบข้อมูลที่ซ้ำ
                // dd($request);
                $findNumber = LabourModel::latest()->where('labour_number','!=',NULL)->value('labour_number');
                // ถ้าไม่มีข้อมูลในตาราง
                if ($findNumber === Null) {
                    $number = 1;
                } else {
                    $explode = explode('-', $findNumber);
                    $number = $explode[1] + 1;
                }
                $Seq = substr('00000000' . $number, -8, 8);
                $NewNumber = 'CUS-' . $Seq;

                if($row[6] && $row[9] && $row[12] && $row[13])
                {    
                    $newRecord = LabourModel::create([
                        'labour_number'                => $NewNumber,
                        'labour_code'                  => $row[1],
                        'labour_name'                  => $row[5],
                        'labour_company'               => $this->company,
                        'labour_agent'                 => $this->agency,
                        'labour_date_create'           => date('Y-m-d',strtotime($now)),
                        'labour_nationality'           => $this->nationality,
                        'labour_sex'                   => $row[4],
                        'labour_birth_date'            => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[18]),date('Y-m-d'),
                        'labour_passport_number'       => $row[6],
                        'labour_passport_date_start'   => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7]),date('Y-m-d'),
                        'labour_passport_date_end'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]),date('Y-m-d'),
                        'labour_visa_number'           => $row[9],
                        'labour_visa_date_start'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),date('Y-m-d'),
                        'labour_visa_date_end'         => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[11]),date('Y-m-d'),
                        'labour_visa_run_date'         => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[21]),date('Y-m-d'),
                        'labour_work_permit_number'    => $row[13],
                        'labour_work_permit_date_start'=> \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]),date('Y-m-d'),
                        'labour_work_permit_date_end'  => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),date('Y-m-d'),
                        'labour_work_permit_run_date'  => NULL,
                        'labour_ninety_date_start'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[16]),date('Y-m-d'),
                        'labour_ninety_date_end'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[17]),date('Y-m-d'),
                        'labour_work'                  => 'Y',
                        'labour_work_date'             => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[19]),date('Y-m-d'),
                        'labour_escape'                => 'N',
                        'labour_escape_date'           => NULL,
                        'labour_resign'                => 'N',
                        'labour_resign_date'           => NULL,
                        'labour_note'                  => $row[22],
                        'labour_user_add'              => Auth::user()->name,
                        'labour_user_edit'             => NULL,
                        'labour_department'            => $row[0],
                        'labour_visa_date_start01'     => NULL,
                        'labour_visa_date_end01'       => NULL,
                        'labour_visa_date_start02'     => NULL,
                        'labour_visa_date_end02'       => NULL,
                        'labour_work_permit_date_start01' => NULL,
                        'labour_work_permit_date_end01'   => NULL,
                        'labour_work_permit_date_start02' => NULL,
                        'labour_work_permit_date_end02'   => NULL,
                        'labour_TM_province'          => $row[3],
                        'labour_status'               => "Y",
                        'labour_immigration_number'   => $row[2],
                        'labour_textid'               => $row[12],
                        'import_id'                   => $row[20],
                    ]);

                    activity()
                    ->performedOn($newRecord)
                    ->tap(function ($activity) use ($newRecord) {
                        // กำหนดข้อมูลในฟิลด์ที่ต้องการ
                        $activity->causer_type  = Auth::user()->name;
                        $activity->log_name     = 'labour';
                        $activity->subject_type = 'Uplaod';
                        $activity->event        = 'AddExcel';
                        $activity->properties   = $newRecord;
                    })
                    ->log($newRecord->labour_name . ',' . $newRecord->labour_passport_number);

                  

                    if($PROVINCE_ID && $AMPHUR_ID && $DISTRICT_CODE && $zip ) 
                    {
            
                        AddressLabourModel::create([
                            'labour_id'         => $newRecord->labour_id,
                            'labour_passport'   => $newRecord->labour_passport_number,
                            'addr_number'       => $row[23],
                            'addr_province'     => $PROVINCE_ID, ///$row[26],
                            'addr_amphur'       => $AMPHUR_ID, //$row[25],
                            'addr_distict'      => $DISTRICT_CODE, //$row[24],
                            'addr_zipcode'      => $zip, //$row[27],
                            'addr_note'         => $row[28],
                            'addr_user_add'     => Auth::user()->name,
                            'addr_status'       => 'Y',
                        ]);
                    }
                    

                    $this->importedIds[] = $newRecord->labour_id;
                }
                
               
            }
    
        }
    }

    


    public function getImportedIds()
    {
        return $this->importedIds;
    }
}

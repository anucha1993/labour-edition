<?php

namespace App\Imports\labours;

use App\Models\laModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Labours\LabourModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
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
                        'labour_company_surname'       => $this->company,
                        'labour_company_code'          => $this->company,
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
                        'labour_visa_run_date'         => NULL,
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
                        'labour_installment'           => NULL,
                        'labour_note'                  => $row[21],
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

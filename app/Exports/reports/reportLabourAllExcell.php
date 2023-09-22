<?php

namespace App\Exports\reports;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Labours\LabourModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class reportLabourAllExcell implements FromCollection, WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    

    public function headings(): array
    {
        return [
            'ลำดับ',               //A
            'ชื่อบริษัท',             //B
            'ชื่อแรงงาน',            //C
            'สัญชาติ',              //D
            'วันเกิด',               
            'เลขหนังสือเดินทาง',
            'เลขบัตรประตัวประชาชน',
            'วันออกเล่ม',
            'วันหมดเล่ม',
            'เล่มพาสเหลือ',
            'เลขที่วีซ่า',
            'วันเริ่มวีซ่าล่าสุด',
            'วีซ่าสิ้นสุดล่าสุด',
            'วันเริ่มวีซ่า(รอบที่ 1)',
            'วีซ่าสิ้นสุด(รอบที่ 1)',
            'วันเริ่มวีซ่า(รอบที่ 2)',
            'วีซ่าสิ้นสุด(รอบที่ 2)',
            'วีซ่าเหลือ',
            'เลขที่ใบอนุญาตทำงาน',
            'ใบอนุญาตเริ่มต้น(ล่าสุด)',
            'ใบอนุญาตสิ้นสุด(ล่าสุด)',
            'วันเริ่มวีซ่า(รอบที่ 1)',
            'วีซ่าสิ้นสุด(รอบที่ 1)',
            'วันเริ่มวีซ่า(รอบที่ 2)',
            'วีซ่าสิ้นสุด(รอบที่ 2)',
            'รหัสพนักงาน',
            'แผนก',
            'เวิร์คเหลือ',
            'รายงานตัว90วันเริ่มต้น',
            'รายงานตัว90วันสิ้นสุด',
            '90 วันเหลือ',
            'ข้อมูล ตม.',
            'หมายเหตุ',
        ];
    }
    private $company_id;
    private $status;
    public function __construct($company_id,$status)
    {
        $this->company_id = $company_id;
        $this->status = $status;
    }

    public function collection()
    {
         $chunkSize = 1000; // จำนวนแถวในแต่ละช่วง
         $labourData = DB::table('labour')->leftJoin('company','company.company_id','=','labour.labour_company')
         ->leftJoin('nationality','nationality.nationality_id','=','labour.labour_nationality')
         ->select('labour.labour_name','labour.labour_birth_date','labour.labour_passport_number','labour.labour_textid','labour.labour_passport_date_start',
                   'labour.labour_passport_date_end','labour.labour_visa_number','labour.labour_visa_number','labour.labour_visa_date_start','labour.labour_visa_date_end',
                   'labour.labour_visa_date_start01','labour.labour_visa_date_end01','labour.labour_visa_date_start02','labour.labour_visa_date_end02',
                   'labour.labour_work_permit_number','labour.labour_work_permit_date_start','labour.labour_work_permit_date_end','labour.labour_work_permit_date_start01','labour.labour_work_permit_date_end01',
                   'labour.labour_work_permit_date_start02','labour_work_permit_date_end02','labour_work_permit_date_end02','labour.labour_work','labour.labour_escape',
                   'labour.labour_department','labour.labour_code','labour.labour_ninety_date_start','labour.labour_ninety_date_end','labour.labour_note',
                   'company.company_name',
                   'nationality.nationality_name')
        ->when($this->company_id, function ($query){
            return $query->where('company.company_id',$this->company_id);
        })
        ->when($this->status === 'job', function ($query) {
            return $query->where('labour.labour_escape','!=' ,'Y')->where('labour.labour_resign','!=' ,'Y');
        })
        ->when($this->status === 'escape', function ($query) {
            return $query->where('labour.labour_escape', 'Y');
        })
        ->when($this->status === 'resign', function ($query) {
            return $query->where('labour.labour_resign', 'Y');
        })
        
        ->orderBy('labour.labour_id')
        ->get();
         return $labourData;
    }



    private $No = 0;
    public function map($labourData): array
    {
      $chunkSize = 10000; // จำนวนแถวในแต่ละช่วง
      return [
        ++$this->No,                     
        $labourData->company_name,       
        $labourData->labour_name,        
        $labourData->nationality_name,   
        date('d-m-Y',strtotime($labourData->labour_birth_date)), 
        $labourData->labour_passport_number, 
        "'".$labourData->labour_textid, 
        $labourData->labour_passport_date_start, 
        $labourData->labour_passport_date_end,
        $this->getRemainingPassportDays($labourData->labour_passport_date_end),
        $labourData->labour_visa_number,
        $labourData->labour_visa_date_start,
        $labourData->labour_visa_date_end,
        $labourData->labour_visa_date_start01,
        $labourData->labour_visa_date_end01,
        $labourData->labour_visa_date_start02,
        $labourData->labour_visa_date_end02,
        $this->getRemainingPassportDays($labourData->labour_visa_date_end),
        "'".$labourData->labour_work_permit_number,
        $labourData->labour_work_permit_date_start,
        $labourData->labour_work_permit_date_end,
        $labourData->labour_work_permit_date_start01,
        $labourData->labour_work_permit_date_end01,
        $labourData->labour_work_permit_date_start02,
        $labourData->labour_work_permit_date_end02,
        $labourData->labour_code,
        $labourData->labour_department,
        $this->getRemainingPassportDays($labourData->labour_work_permit_date_end),
        $labourData->labour_ninety_date_start,
        $labourData->labour_ninety_date_end,
        $this->getRemainingPassportDays($labourData->labour_ninety_date_end),
        $labourData->labour_note,
      ];
    }
    private function getRemainingPassportDays($expiryDate) {
        $today = Carbon::now();
        $expiryDate = Carbon::parse($expiryDate);
        return $expiryDate->diffInDays($today);
    }
    

   
}

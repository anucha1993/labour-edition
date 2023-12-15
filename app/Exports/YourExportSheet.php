<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class YourExportSheet implements FromCollection,WithTitle,WithHeadings,WithMapping
{
    private $data;
    private $labourCompany;

    public function __construct($data, $labourCompany)
    {
        $this->data = $data;
        $this->labourCompany = $labourCompany;
    }

    public function collection()
    {
        return $this->data;
    }

    private static $i_com = 0;
    public function title(): string {
        $firstData = $this->data->first();
        if ($firstData !== null && isset($firstData->company_name)) {
            return (string) $firstData->company_name;
        } else {
            return 'NULL-' . ++self::$i_com; // ใช้ self::$i เพื่อให้เก็บค่าต่อเนื่องทุกครั้งที่เข้าสู่ else
        }
    }

    public function headings(): array
    {
        return [
            'ลำดับ',              
            'ชื่อบริษัท',            
            'กลุ่มการนำเข้า',           
            'ชื่อแรงงาน',            
            'สัญชาติ',              
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

    private $No = 0;
    public function map($data): array
    {
      $chunkSize = 10000; // จำนวนแถวในแต่ละช่วง
      return [
        ++$this->No,                     
        $data->company_name,       
        ($data->import_name == '' ? "ไม่พบข้อมูล" : $data->import_name),       
        $data->labour_name,        
        $data->nationality_name,   
        date('d-m-Y',strtotime($data->labour_birth_date)), 
        $data->labour_passport_number, 
        "'".$data->labour_textid, 
        date('d-m-Y',strtotime($data->labour_passport_date_start)), 
        date('d-m-Y',strtotime($data->labour_passport_date_end)),
        $this->getRemainingPassportDays($data->labour_passport_date_end),
        $data->labour_visa_number,
        date('d-m-Y',strtotime($data->labour_visa_date_start)),
        date('d-m-Y',strtotime($data->labour_visa_date_end)),
        date('d-m-Y',strtotime($data->labour_visa_date_start01)),
        date('d-m-Y',strtotime($data->labour_visa_date_end01)),
        date('d-m-Y',strtotime($data->labour_visa_date_start02)),
        date('d-m-Y',strtotime($data->labour_visa_date_end02)),
        $this->getRemainingPassportDays($data->labour_visa_date_end),
        "'".$data->labour_work_permit_number,
        date('d-n-Y',strtotime($data->labour_work_permit_date_start)),
        date('d-n-Y',strtotime($data->labour_work_permit_date_end)),
        date('d-n-Y',strtotime($data->labour_work_permit_date_start01)),
        date('d-n-Y',strtotime($data->labour_work_permit_date_end01)),
        date('d-n-Y',strtotime($data->labour_work_permit_date_start02)),
        date('d-n-Y',strtotime($data->labour_work_permit_date_end02)),
        "'".$data->labour_code,
        $data->labour_department,
        $this->getRemainingPassportDays($data->labour_work_permit_date_end),
        date('d-m-Y',strtotime($data->labour_ninety_date_start)),
        date('d-m-Y',strtotime($data->labour_ninety_date_end)),
        $this->getRemainingPassportDays($data->labour_ninety_date_end),
        $data->labour_immigration_number,
        $data->labour_note,
      ];
    }
    private function getRemainingPassportDays($expiryDate) {
        $today = Carbon::now();
        $expiryDate = Carbon::parse($expiryDate);
        return $expiryDate->diffInDays($today);
    }



}

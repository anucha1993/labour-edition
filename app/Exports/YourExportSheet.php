<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;



class YourExportSheet implements FromCollection,WithTitle,WithHeadings,WithMapping,WithColumnWidths,WithEvents,WithColumnFormatting
{
    private $data;
    private $labourCompany;
    private $companyName;

    public function __construct($data, $labourCompany)
    {
        $this->data = $data;
        $this->labourCompany = $labourCompany;
     
    }

    public function collection()
    {
        return $this->data;
    }

     //จัดตัวหนังสือให้อยู้ตรงกลาง
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('K')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('K')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('L')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('M')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('N')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('O')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('P')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('Q')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('R')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('S')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('L')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('U')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
               

                $fontStyle = new Font();
                $fontStyle->setName('THSarabunNew'); // ระบุชื่อแบบอักษรที่ต้องการ เช่น Arial, Times New Roman
                $fontStyle->setSize(14); // กำหนดขนาดของแบบอักษร
                $fontStyle->setBold(false); // กำหนดเป็นตัวหนาหรือไม่ตัวหนา
                $fontStyle = [
                    'font' => [
                        'name' => 'THSarabunNew', // ระบุชื่อแบบอักษรที่ต้องการ เช่น Arial, Times New Roman
                        'size' => 14, // กำหนดขนาดของแบบอักษร
                        'bold' => false, // กำหนดให้เป็นตัวหนาหรือไม่ตัวหนา
                    ],
                ];

                $event->sheet->getDelegate()->getStyle('A:Z')->applyFromArray($fontStyle);
                // กำหนดแบบอักษรให้กับเซลล์ในช่วง A:Z ด้วยเมธอด applyFromArray()
                $event->sheet->insertNewRowBefore(1, 1);
                $event->sheet->setCellValue('B1', $this->companyName);
                $event->sheet->getDelegate()->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Apply font styles for cell B1
                $fontStyleB1 = new Font();
                $fontStyleB1->setName('THSarabunNew');
                $fontStyleB1->setSize(16);
                $fontStyleB1->setBold(true);
                $event->sheet->getDelegate()->getStyle('B1')->applyFromArray([
                    'font' => [
                        'name' => $fontStyleB1->getName(),
                        'size' => $fontStyleB1->getSize(),
                        'bold' => true, 

                    ],
                ]);




                
            },
        ];
    }



    

    public function columnWidths(): array
    {
        
        return [
            'A' => 5,
            'B' => 45,            
            'C' => 25,            
            'D' => 25,            
            'E' => 30,            
            'F' => 15,            
            'G' => 15,            
            'H' => 25,            
            'I' => 25,            
            'J' => 15,            
            'K' => 15,            
            'L' => 15,            
            'M' => 15,            
            'N' => 23,            
            'O' => 23,            
            'P' => 23,            
            'Q' => 20,            
            'R' => 20,            
            'S' => 20,            
            'T' => 20,            
            'U' => 20,            
            'V' => 40,            
            'W' => 40,            
            'X' => 80, 
            'Y' => 40,            
            'Z' => 60,                     
        ];
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
          
            'ลำดับ', //1
            'กลุ่มการนำเข้า',//2
            'รหัสพนักงาน', //3
            'แผนก',//4
            'สถานที่ทำงาน',//5
            'ชื่อแรงงาน',//6
            'ชื่อภาษาไทย',//7
            'สัญชาติ',//8
            'วันเกิด',//9
            'เลขหนังสือเดินทาง',//10
            'เลขบัตรประตัวประชาชน',//10
            'วันออกเล่ม',//10
            'วันหมดเล่ม',//11
            'เลขที่วิซ่า',//12
            'วันเริ่มวีซ่าล่าสุด',//12
            'วีซ่าสิ้นสุดล่าสุด',//13
            'เลขที่ใบอนุญาตทำงาน',//14
            'ใบอนุญาตเริ่มต้น(ล่าสุด)',//15
            'ใบอนุญาตสิ้นสุด(ล่าสุด)',//16
            'รายงานตัว90วันเริ่มต้น',//17
            'รายงานตัว90วันสิ้นสุด',//18
            'เลข ตม.',//18
            'เบอร์ติดต่อแรงงาน',//19
            'ที่อยู่แรงงาน',//19
            'เอเจนซี่', //20
            'หมายเหตุ',//21
          
        ];
    }

    private $No = 0;
    public function map($data): array
    {
        $this->companyName = $data->company_name;
      $chunkSize = 10000; // จำนวนแถวในแต่ละช่วง
      return [
      
        ++$this->No, //1
        ($data->import_name == '' ? "ไม่พบข้อมูล" : $data->import_name),//2
        $data->labour_code,//3
        ($data->labour_department == '' ? "'" : $data->labour_department),//4
        $data->labour_place_of_work,//5
        $data->labour_name,//5
        $data->labour_name_th,//5
        $data->nationality_name,//6
        date('d-m-Y',strtotime($data->labour_birth_date)),//7
        $data->labour_passport_number, //8
        ($data->labour_textid == '' ? "'" : $data->labour_textid),//9
        date('d-m-Y',strtotime($data->labour_passport_date_start)),//10
        date('d-m-Y',strtotime($data->labour_passport_date_end)),//11
        ($data->labour_visa_number),
        date('d-m-Y',strtotime($data->labour_visa_date_start)),//12
        date('d-m-Y',strtotime($data->labour_visa_date_end)),//13
        $data->labour_work_permit_number,//14
        date('d-n-Y',strtotime($data->labour_work_permit_date_start)),//15
        date('d-n-Y',strtotime($data->labour_work_permit_date_end)),//16
        date('d-m-Y',strtotime($data->labour_ninety_date_start)),//17
        date('d-m-Y',strtotime($data->labour_ninety_date_end)),//18
        $data->labour_immigration_number,
        ($data->addr_note == '' ? "ไม่พบข้อมูล" : $data->addr_note),//9
        ($data->addr_province == '' ? "ไม่พบที่อยู่" : 'เลขที่ '.$data->addr_number.' ตำบล/แขวง '.$data->DISTRICT_NAME. 'อำเภอ/เขต '.$data->AMPHUR_NAME.' จังหวัด '.$data->PROVINCE_NAME.' รหัสไปรษณีย์ '.$data->addr_zipcode),
        $data->agent_company,//19
        $data->labour_note,//20

      ];
    }

    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_NUMBER,
            'Q' => NumberFormat::FORMAT_NUMBER,
            'O' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    private function getRemainingPassportDays($expiryDate) {
        $today = Carbon::now();
        $expiryDate = Carbon::parse($expiryDate);
        return $expiryDate->diffInDays($today);
    }



}




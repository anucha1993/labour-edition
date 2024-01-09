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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;



class CPFexportSubformSheet implements FromCollection,WithTitle,WithHeadings,WithMapping,WithColumnWidths,WithEvents

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
               



    
            },
        ];
    }



    

    public function columnWidths(): array
    {
        
        return [
            'A' => 5,
            'B' => 65,            
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
            'ชื่อบริษัท',//2
            'แผนก',//3
            'User ID',//4
            'Name',//5
            'สัญชาติ',//6
            'วันเกิด',//7
            'Country/Region',//8
            'Document Type',//9
            'Document Number',//10
            'Issue Date',//11
            'Expiry Date',//12
            'Issue Place',//13

        ];
    }

    private $No = 0;
    public function map($data): array
    {
        $this->companyName = $data->company_name;
      $chunkSize = 10000; // จำนวนแถวในแต่ละช่วง

      switch ($data->labour_nationality) {
        case 1: // MMR
            $documentTypes = "MMR" . $data->labour_passport_number;
            break;
        case 2: // KHM
            $documentTypes = "KHM" . $data->labour_passport_number;
            break;
        case 3: // LAO
            $documentTypes = "LAO" . $data->labour_passport_number;
            break;
        default:
            break;
    }

      return [
        ++$this->No, //1
        $data->company_name,//2
        ($data->labour_department == '' ? "'" : $data->labour_department),//3
        ($data->labour_code == '' ? "'" : $data->labour_code),//4
        $data->labour_name,//5
        $data->nationality_name,//6
        date('d-m-Y',strtotime($data->labour_birth_date)),//7
        'Thailand',//8
        'Thai TM47 Number',//9
        $documentTypes,//10
        date('d-m-Y',strtotime($data->labour_passport_date_start)),//11
        date('d-m-Y',strtotime($data->labour_passport_date_end)),//12
        $data->labour_TM_province,//13
       

      ];
    }
    private function getRemainingPassportDays($expiryDate) {
        $today = Carbon::now();
        $expiryDate = Carbon::parse($expiryDate);
        return $expiryDate->diffInDays($today);
    }

}

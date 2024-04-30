<?php

namespace App\Exports\create_form_import;

use App\Models\customer\CustomerModel;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\sheet\custom_sheet\FirstSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Exports\sheet\custom_sheet\SecondSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CreateFromExcel implements FromCollection, WithHeadings,WithMapping,WithEvents,WithColumnWidths
{
    private $data;
    private $row;



    public function __construct(array $data)
    {
        $this->data = collect($data);
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($row): array
    {
        // ประมวลผลข้อมูลในแต่ละแถวและคืนค่าในรูปแบบของ array
        return [$this->row];
    }

    public function columnWidths(): array
    {
        $columnWidths = [];
        $headerCol = $this->data;
        $firstRow = reset($headerCol);
        $headerColumns = array_slice($firstRow, 1); 
    
        // Loop ตั้งแต่ A ถึง Z
        for ($i = 0; $i < count($headerColumns); $i++) {
            // กำหนดชื่อของคอลัมน์โดยใช้เลขลำดับของคอลัมน์แทน A, B, C, ...
            $columnName = chr(65 + $i); // 65 คือ ASCII code ของ A
            // กำหนดความกว้างของแต่ละคอลัมน์
            $columnWidths[$columnName] = 50; // เปลี่ยนเลขตามต้องการ
        }
        return $columnWidths;
    }

    //จัดตัวหนังสือให้อยู้ตรงกลาง
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:Z')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
    
    public function headings(): array
    {
        $rows = $this->data;
        // ดึงแถวแรกของข้อมูล
        $firstRow = reset($rows);
        // ตัดข้อมูล index ที่ 0 และ 1 ออกแล้วเก็บข้อมูลตั้งแต่ index ที่ 2 เป็นต้นไป
        $headers = array_slice($firstRow, 2); 
        $row1 = ['เลขที่หนังสือเดินทาง']; 
        $row2 = ['labour_passport_number']; 
        foreach ($headers as $key => $val){
            $row1[] = $val; // กำหนด Value ไปที่ $row1
            $row2[] = $key; // กำหนด Key ไปที่ $row2
        }
        return [
            $row1, // แสดง Value แถวแรก
            $row2  // แสดง Key แถวที่แสดง $key
        ];
    }
    
    
    
    
}

<?php

namespace App\Imports\labours;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class update90day implements ToCollection,WithStartRow
{
   /**
    * @param Collection $collection
    */
    protected $excelData = [];

    public function startRow(): int
    {
        return 2; // กำหนดให้เริ่มต้นจากแถวที่ 2
    }

    public function collection(Collection $rows)
    {
        // $rowData = $rows->toArray(); 
        // $this->excelData = $rowData;

        $rowData = $rows->toArray(); 

        foreach ($rowData as $key => $row) {
            //row 1
            $dateValue = Carbon::createFromTimestamp(($row[1] - 25569) * 86400)->format('Y-m-d'); // ตำแหน่งข้อมูลวันที่อยู่ที่คอลัมน์ที่ 2
            $rowData[$key][1] = $dateValue; // กำหนดค่าวันที่ที่ถูกแปลงกลับไปยังคอลัมน์ที่ 2
           
        }
    
        //dd($rowData);
        $this->excelData = $rowData;
     
    }

    // เพิ่มเมทอดเพื่อรับค่าของ $excelData
    public function getExcelData()
    {
        return $this->excelData;
    }

    
    
}

<?php

namespace App\Imports\labours;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
class AddressLabourImport implements ToCollection,WithStartRow
{
    /**
    * @param Collection $collection
    */
    protected $excelData = [];
    public function startRow(): int
    {
        return 2; //ใช้ข้อมูลแถวที่2 เป็นต้นไป
    }
    public function collection(Collection $rows)
    {
       // ตรวจสอบว่า $rows ไม่ใช่คอลเล็กชันว่าง
    if ($rows->isNotEmpty()) {
        // แปลง Collection เป็น array
        $rowData = $rows->toArray();

        // ใช้ array_filter เพื่อลบค่าที่มี index ที่ 6 เป็น null ออกจาก array
        $filteredData = array_filter($rowData, function ($row) {
            return $row[0] !== null;
        });

        // นำ array ที่ถูกกรองเก็บไว้
        $this->excelData = $filteredData;

        // ทดสอบแสดงผล
       // dd($filteredData);
    }
    }


    public function getExcelData()
    {
        return $this->excelData;
    }
}

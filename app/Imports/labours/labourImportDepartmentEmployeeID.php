<?php

namespace App\Imports\labours;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class labourImportDepartmentEmployeeID implements ToCollection,WithStartRow
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
        $rowData = $rows->toArray(); 
        $this->excelData = $rowData;
    }

    // เพิ่มเมทอดเพื่อรับค่าของ $excelData
    public function getExcelData()
    {
        return $this->excelData;
    }

    
    
}

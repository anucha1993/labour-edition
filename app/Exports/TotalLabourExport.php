<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\Labours\LabourModel;
use App\Models\customer\CustomerModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TotalLabourExport implements FromCollection, WithHeadings,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ลำดับ',
            'ชื่อบริษัท',
            'จำนวนแรงงาน',
            'สถานะ',
        ];
    }

    public function columnWidths(): array
    {
        
        return [
            'A' => 5,
            'B' => 80,                   
            'C' => 20,                   
                 
        ];
    }

    public function collection()
    {
        // ดึงข้อมูลจาก LabourModel และรวมกับข้อมูลจาก Customer
        $labours = LabourModel::select('labour_company')
            ->where('labour.labour_status', '=', 'Y')
            ->where('labour.labour_resign', '!=', 'Y')
            ->where('labour.labour_escape', '!=', 'Y')
            ->where('labour.labour_visa_company_manage', 'N')
            ->where('labour.labour_work_permit_company_manage', 'N')
            ->where('labour.labour_work_permit_company_manage', 'N')
            ->where('labour.labour_ninety_company_manage', 'N')
            ->where('labour.labour_ninety_company_manage', 'N')
            ->where('labour.labour_passport_company_manage', 'N')
            ->where('labour.labour_visa_company_manage', 'N')
            ->where('labour.labour_work_permit_company_manage', 'N')
            ->where('labour.labour_ninety_company_manage', 'N')
            
            ->selectRaw('count(*) as total_labours')
            ->groupBy('labour_company')
            ->get();

        // สร้าง collection สำหรับ export
        $exportData = new Collection();

        foreach ($labours as $index => $labour) {
            $customer = CustomerModel::find($labour->labour_company);

            // ตรวจสอบว่ามีข้อมูล customer หรือไม่
            if ($customer) {
                $companyName = $customer->company_name;
            } else {
                $companyName = 'ไม่พบข้อมูลบริษัท';
            }

            $exportData->push([
                'ลำดับ' => $index + 1,
                'ชื่อบริษัท' => $companyName,
                'จำนวนแรงงาน' => $labour->total_labours . ' คน',
                'สถานะ' => 'ทำงาน',
            ]);
        }

        return $exportData;
    }
}

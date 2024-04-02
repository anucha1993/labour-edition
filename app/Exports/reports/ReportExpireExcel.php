<?php

namespace App\Exports\reports;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exports\YourExportSheet;
use Illuminate\Support\Facades\DB;
use App\Models\Labours\LabourModel;
use League\Fractal\Resource\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class ReportExpireExcel implements FromCollection, WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */


     private $data;
    private $expireType;

    public function sheets(): array
    {
        // กลุ่มข้อมูลตาม labour_company
        $labourCompanies = $this->data->groupBy('labour_company');

        $sheets = [];

        foreach ($labourCompanies as $labourCompany => $data) {
            $sheets[] = new YourExportSheet($data, $labourCompany);
        }

        return $sheets;
    }

    public function __construct($expireType)
    {
        $this->expireType = $expireType;


        //dd($this->company_id);

        $data = LabourModel::leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
            ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
            ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
            ->leftjoin('address_labour', 'address_labour.labour_id', 'labour.labour_id')
            ->leftjoin('amphures', 'amphures.AMPHUR_ID', 'address_labour.addr_amphur')
            ->leftjoin('districts', 'districts.DISTRICT_CODE', 'addr_distict')
            ->leftjoin('provinces', 'provinces.PROVINCE_ID', 'addr_province')
            ->where('labour.labour_status', '=', 'Y')
            // พาสหมด
            ->when($this->expireType != 'passport', function ($query) {
                return $query->where('labour.labour_passport_date_end','<=',Carbon::now()->addDays(15));
            })
            //ตามกลุ่มนำเข้า
            ->when($this->expireType != 'visa', function ($query) {
                return $query->where('labour.labour_visa_date_end','<=',Carbon::now()->addDays(15));
            })
            //สถานะทำงาน
            ->when($this->expireType === 'work', function ($query) {
                return $query->where('labour.labour_work_permit_date_end','<=',Carbon::now()->addDays(15));
            })
            //สถานะหลบหนี
            ->when($this->expireType === 'ninety', function ($query) {
                return $query->where('labour.labour_ninety_date_end','<=',Carbon::now()->addDays(15));
            })
           
            ->orderBy('labour.labour_id')
            ->get();

        $row_count = $data->count(); // จำนวนแถวที่ได้
        if ($row_count === 0) {
            echo "<script>alert('ไม่พบข้อมูล'); window.history.go(-1);</script>";
        }
        $this->data = $data; // แก้ไขตรงนี้
    }

    public function collection()
    {
        // ไม่ต้อง return $data จากนี้
    }
}

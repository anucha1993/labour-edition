<?php

namespace App\Exports\reports;

use App\Exports\CPFexportSheet;
use App\Exports\YourExportSheet;
use App\Models\Labours\LabourModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class reportCpfForm01Excell implements FromCollection,WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
   
    private $data;

    public function sheets(): array
    {
        // กลุ่มข้อมูลตาม labour_company
        $labourCompanies = $this->data->groupBy('labour_company');

        $sheets = [];

        foreach ($labourCompanies as $labourCompany => $data) {
            $sheets[] = new CPFexportSheet($data, $labourCompany);
        }

        return $sheets;
    }
    private $company_id;
    private $import_id;
    private $status;
    private $ninety_day_start;
    private $ninety_day_end;
    private $visa_start;
    private $visa_end;
    private $work_start;
    private $work_end;
    private $passport_start;
    private $passport_end;

    public function __construct($data, $company_id, $status, $import_id, $ninety_day_start, $ninety_day_end, $visa_start, $visa_end, $work_start, $work_end, $passport_start, $passport_end)
    {
        $this->company_id       = $company_id;
        $this->status           = $status;
        $this->import_id        = $import_id;
        $this->ninety_day_start = $ninety_day_start;
        $this->ninety_day_end   = $ninety_day_end;
        $this->visa_start       = $visa_start;
        $this->visa_end         = $visa_end;
        $this->work_start       = $work_start;
        $this->work_end         = $work_end;
        $this->passport_start   = $passport_start;
        $this->passport_end     = $passport_end;

        // dd($this->company_id);

        $data = LabourModel::leftJoin('company', 'company.company_id', '=', 'labour.labour_company')
            ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
            ->leftJoin('import', 'import.import_id', '=', 'labour.import_id')
            ->where('labour.labour_status', '=', 'Y')
            //ตามบริษัท
            ->when($this->company_id != 'all', function ($query) {
                return $query->where('company.company_id', $this->company_id);
            })
            //ตามกลุ่มนำเข้า
            ->when($this->import_id != 'all', function ($query) {
                return $query->where('labour.import_id', $this->import_id);
            })
            //สถานะทำงาน
            ->when($this->status === 'job', function ($query) {
                return $query->where('labour.labour_work', '=', 'Y')
                ->where('labour.labour_resign', '!=', 'Y')
                ->where('labour.labour_status', '=', 'Y');
            })
            //สถานะหลบหนี
            ->when($this->status === 'escape', function ($query) {
                return $query->where('labour.labour_escape', 'Y')
                ->where('labour.labour_status', '=', 'Y');
            })
            //สถานะลาออก
            ->when($this->status === 'resign', function ($query) {
                return $query->where('labour.labour_resign', 'Y')
                ->where('labour.labour_status', '=', 'Y');
            })
            // 90 วัน
            ->when($this->import_id != 'all', function ($query) {
                return $query->where('labour.import_id', $this->import_id);
            })

            ->when($this->ninety_day_start !== null && $this->ninety_day_end !== null, function ($query) {
                return $query->whereDate('labour_ninety_date_end', '>=', $this->ninety_day_start)
                             ->whereDate('labour_ninety_date_end', '<=', $this->ninety_day_end);
            })

            ->when($this->visa_start !== null && $this->visa_end !== null, function ($query) {
                return $query->whereDate('labour_visa_date_end', '>=', $this->visa_start)
                             ->whereDate('labour_visa_date_end', '<=', $this->visa_end);
            })

            ->when($this->work_start !== null && $this->work_end !== null, function ($query) {
                return $query->whereDate('labour_work_permit_date_end', '>=', $this->work_start)
                             ->whereDate('labour_work_permit_date_end', '<=', $this->work_end);
            })

            ->when($this->passport_start !== null && $this->passport_end !== null, function ($query) {
                return $query->whereDate('labour_passport_date_end', '>=', $this->passport_start)
                             ->whereDate('labour_passport_date_end', '<=', $this->passport_end);
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

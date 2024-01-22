<?php

namespace App\Exports\customer;

use Illuminate\Support\Carbon;
use App\Models\customer\CustomerModel;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CustomerExcel implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithColumnFormatting,WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private $province;
    private $customer;
    private $data;

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 50,
            'D' => 25,
            'E' => 25,
            'F' => 25,
            'G' => 30,
            'H' => 25,
            'I' => 30,
            'J' => 30,
            'K' => 30,
            'L' => 30,
            'M' => 30,
            'N' => 35,
            'O' => 25,
            'P' => 25,
            'Q' => 25,
            'R' => 25,
            'S' => 45,

        ];
    }

      //จัดตัวหนังสือให้อยู้ตรงกลาง
      public function registerEvents(): array
      {
          return [
              AfterSheet::class => function (AfterSheet $event) {
                  $event->sheet->getDelegate()->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                  $event->sheet->getDelegate()->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                  $event->sheet->getDelegate()->getStyle('F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
  


    public function headings(): array
    {
        return [
            'ลำดับ',
            'ทะเบียนเลขที่',
            'ชื่อบริษัท',
            'ชื่อนายจ้าง',
            'ประเภทกิจการ',
            'เบอร์โทรศัพท์',
            'อีเมล์',
            'ผู้ประสานงาน',
            'ชื่อกรรมการ ท่านที่ 1',
            'ชื่อกรรมการ ท่านที่ 2',
            'ชื่อกรรมการ ท่านที่ 3',
            'ชื่อกรรมการ ท่านที่ 4',
            'ชื่อกรรมการ ท่านที่ 5',
            'ที่อยู่เลขที่',
            'แขวง/ตำบล',
            'เขต/อำเภอ',
            'จังหวัด',
            'รหัสไปรษณีย์',
            'หมายเหตุ',
        ];
    }


    private $No = 0;
    public function map($data): array
    {
        return [
            ++$this->No,
            $data->company_code,
            $data->company_name,
            $data->company_surname . ' ' . $data->company_company_lastname,
            ($data->company_business_type != '' ? $data->company_business_type : 'ไม่พบข้อมูล'),
            ($data->company_tel != '' ? $data->company_tel : 'ไม่พบข้อมูล'),
            ($data->company_email != '' ? $data->company_email : 'ไม่พบข้อมูล'),
            ($data->company_coordinator != '' ? $data->company_coordinator : 'ไม่พบข้อมูล'),
            ($data->company_authorized_surname_1 != '' ? $data->company_authorized_surname_1 . ' ' . $data->company_authorized_lastname_1 : 'NONE'),
            ($data->company_authorized_surname_1 != '' ? $data->company_authorized_surname_2 . ' ' . $data->company_authorized_lastname_2 : 'NONE'),
            ($data->company_authorized_surname_1 != '' ? $data->company_authorized_surname_3 . ' ' . $data->company_authorized_lastname_3 : 'NONE'),
            ($data->company_authorized_surname_1 != '' ? $data->company_authorized_surname_4 . ' ' . $data->company_authorized_lastname_4 : 'NONE'),
            ($data->company_authorized_surname_1 != '' ? $data->company_authorized_surname_5 . ' ' . $data->company_authorized_lastname_5 : 'NONE'),
            $data->company_house_number,
            $data->DISTRICT_NAME,
            $data->AMPHUR_NAME,
            $data->PROVINCE_NAME,
            $data->company_zipcode,
            $data->company_note,

        ];
    }

    public function __construct($province, $customer)
    {

        $this->province = $province;
        $this->customer = $customer;

        $data = CustomerModel::leftjoin('provinces', 'provinces.PROVINCE_ID', 'company.company_province')
            ->leftjoin('amphures', 'amphures.AMPHUR_ID', 'company.company_area')
            ->leftjoin('districts', 'districts.DISTRICT_CODE', 'company.company_district')
            ->when($this->province != 'all', function ($query) {
                return $query->where('company.company_province', $this->province);
            })
            ->when($this->customer != 'all', function ($query) {
                return $query->where('company.company_id', $this->customer);
            })
            ->get();

        $this->data = $data;
    }



    public function collection()
    {
        //
        return $this->data;
    }
}

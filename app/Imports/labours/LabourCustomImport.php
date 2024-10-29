<?php

namespace App\Imports\labours;

use App\Models\labours\filesModel;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Labours\LabourModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\labours\update90dayModel;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LabourCustomImport implements ToCollection, WithStartRow
{
    /**
     * @param Collection $collection
     */
    protected $labourAll = [];
    protected $dataColumn = [];

    public function startRow(): int
    {
        return 2; //ใช้ข้อมูลแถวที่2 เป็นต้นไป
    }




    public function collection(Collection $collection)
    {
        // $query = LabourModel::where('labour_passport_number', 'MI098471')->update(['labour_work' => 'N']);
        //$query = DB::table('labour')->where('labour_passport_number', 'MI098471')->update(['labour_work' => 'N']);
        $headers = null;
        $data = [];

        // ลูปเพื่อดึงข้อมูลและอัปเดต
        foreach ($collection as $row) {
            // ถ้า headers ยังไม่ถูกกำหนด
            if (!$headers) {
                // กำหนด headers โดยใช้ข้อมูลจากแถวปัจจุบัน
                $headers = $row->toArray();
                continue;
            }

            // สร้าง associative array โดยใช้ headers เป็น key และข้อมูลจากแถวปัจจุบันเป็น value
            $rowData = $row->toArray();
            $rowData = array_combine($headers, $rowData);

            // สร้าง associative array โดยลบค่าที่มี NULL หรือค่าว่างออกจากข้อมูล
            $rowData = array_filter($rowData, function ($value) {
                return $value !== null && $value !== '';
            });

            // เพิ่มข้อมูลที่อัปเดตแล้วลงในอาร์เรย์ $data
            $dataColumn[] = $rowData;
        }
        $labourIDs = [];
        foreach ($dataColumn as $row) {

            if (isset($row['labour_passport_number']) && !empty($row['labour_passport_number'])) {
                $passport_number = $row['labour_passport_number'];
                $labourIDs[] = $row['labour_passport_number'];
                $this->dataColumn = array_keys($row);

                //วันที่เริ่มงาน
                if (!empty($row['labour_work_date'])) {
                    $row['labour_work_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_work_date'])->format('Y-m-d');
                }
                //วันเกิด
                if (!empty($row['labour_birth_date'])) {
                    $row['labour_birth_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_birth_date'])->format('Y-m-d');
                }
                //วันที่พาสเริ่มต้น
                if (!empty($row['labour_passport_date_start'])) {
                    $row['labour_passport_date_start'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_passport_date_start'])->format('Y-m-d');
                }
                //วันที่พาสสิ้นสุด
                if (!empty($row['labour_passport_date_end'])) {
                    $row['labour_passport_date_end'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_passport_date_end'])->format('Y-m-d');
                }
                //วันที่ วีซ่า เริ่มต้น
                if (!empty($row['labour_visa_date_start'])) {
                    $row['labour_visa_date_start'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_visa_date_start'])->format('Y-m-d');
                }
                //วันที่ วีซ่า สิ้นสุด
                if (!empty($row['labour_visa_date_end'])) {
                    $row['labour_visa_date_end'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_visa_date_end'])->format('Y-m-d');
                }
                //วันที่ วีซ่า เริ่มต้น
                if (!empty($row['labour_visa_date_start01'])) {
                    $row['labour_visa_date_start01'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_visa_date_start01'])->format('Y-m-d');
                }
                //วันที่ วีซ่า สิ้นสุด
                if (!empty($row['labour_visa_date_end01'])) {
                    $row['labour_visa_date_end01'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_visa_date_end01'])->format('Y-m-d');
                }
                //วันที่ วีซ่า เริ่มต้น
                if (!empty($row['labour_visa_date_start02'])) {
                    $row['labour_visa_date_start02'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_visa_date_start02'])->format('Y-m-d');
                }
                //วันที่ วีซ่า สิ้นสุด
                if (!empty($row['labour_visa_date_end02'])) {
                    $row['labour_visa_date_end02'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_visa_date_end02'])->format('Y-m-d');
                }
                //วันที่ เดินทางเข้ามา
                if (!empty($row['labour_visa_run_date'])) {
                    $row['labour_visa_run_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_visa_run_date'])->format('Y-m-d');
                }
                //วันที่ ใบอนุญาตทำงาน เริ่ม
                if (!empty($row['labour_work_permit_date_start'])) {
                    $row['labour_work_permit_date_start'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_work_permit_date_start'])->format('Y-m-d');
                }
                //วันที่ ใบอนุญาตทำงาน สิ้นสุด
                if (!empty($row['labour_work_permit_date_end'])) {
                    $row['labour_work_permit_date_end'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_work_permit_date_end'])->format('Y-m-d');
                }
                //วันที่ ใบอนุญาตทำงาน เริ่ม
                if (!empty($row['labour_work_permit_date_start01'])) {
                    $row['labour_work_permit_date_start01'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_work_permit_date_start01'])->format('Y-m-d');
                }
                //วันที่ ใบอนุญาตทำงาน สิ้นสุด
                if (!empty($row['labour_work_permit_date_end01'])) {
                    $row['labour_work_permit_date_end01'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_work_permit_date_end01'])->format('Y-m-d');
                }
                //วันที่ ใบอนุญาตทำงาน เริ่ม
                if (!empty($row['labour_work_permit_date_start02'])) {
                    $row['labour_work_permit_date_start02'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_work_permit_date_start02'])->format('Y-m-d');
                }
                //วันที่ ใบอนุญาตทำงาน สิ้นสุด
                if (!empty($row['labour_work_permit_date_end02'])) {
                    $row['labour_work_permit_date_end02'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_work_permit_date_end02'])->format('Y-m-d');
                }
                //วันที่ 90วัน เริ่มต้น
                if (!empty($row['labour_ninety_date_start'])) {
                    $row['labour_ninety_date_start'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_ninety_date_start'])->format('Y-m-d');
                }
                //วันที่ 90วัน สิ้นสุด
                if (!empty($row['labour_ninety_date_end'])) {
                    $row['labour_ninety_date_end'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_ninety_date_end'])->format('Y-m-d');
                }
                //วันที่ หลบหนี้
                if (!empty($row['labour_escape_date'])) {
                    $row['labour_escape_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_escape_date'])->format('Y-m-d');
                }
                //วันที่ ลาออก
                if (!empty($row['labour_resign_date'])) {
                    $row['labour_resign_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['labour_resign_date'])->format('Y-m-d');
                }

                //ตรวจสอบ  columns ของ larbour Table
                $existing_columns = Schema::getColumnListing('labour'); // แทน 'labour' ด้วยชื่อตารางของคุณ

                $update_columns = array_intersect_key($row, array_flip($existing_columns));
                $query = LabourModel::where('labour_passport_number', $passport_number)->update($update_columns);
                $labourID = LabourModel::select('*')->where('labour_passport_number', $passport_number)->first();
                if ($labourID) {
                    activity()
                        ->performedOn($labourID)
                        ->tap(function ($activity) use ($labourID) {
                            $activity->causer_type = Auth::user()->name;
                            $activity->log_name = 'labour';
                            $activity->subject_type = 'import-custom-excel';
                            $activity->event = 'updated';
                            $activity->properties = $labourID;
                        })
                        ->log($labourID->labour_name . ',' . $labourID->labour_passport_number);
                } else {
                    // handle the case when $labourID is null
                    Log::warning('Labour not found for passport number: ' . $passport_number);
                }

                // Upload File file_passport_manage

                if (!empty($row['file_passport_manage'])) {
                    $file_path_passport = $row['file_passport_manage'];
                    $file_name = basename($file_path_passport);
                    $destination_directory = public_path('storage/labour-file/' . $labourID->labour_id . '/labour-manage-passport');
                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ หากไม่มีให้สร้างโฟลเดอร์
                    if (!file_exists($destination_directory)) {
                        mkdir($destination_directory, 0777, true); // สร้างโฟลเดอร์โดยใช้สิทธิ์เข้าถึง 0777
                    }
                    // ตรวจสอบว่าไฟล์ต้นทางมีอยู่หรือไม่ และคัดลอกไฟล์
                    if (file_exists($file_path_passport)) {
                        $destination = $destination_directory . '/' . $file_name;
                        copy($file_path_passport, $destination);

                        filesModel::create([
                            'labour_id' => $labourID->labour_id,
                            'files_type' => "เอกสารนายจ้างดำนเนินการต่อหนังสือเดินทางเอง",
                            'file_path' => 'storage/labour-file/' . $labourID->labour_id . '/labour-manage-passport' . '/' . $file_name
                        ]);
                    }
                }

                // Upload File file_visa_manage

                if (!empty($row['file_visa_manage'])) {
                    $file_path_visa = $row['file_visa_manage'];
                    $file_name = basename($file_path_visa);
                    $destination_directory = public_path('storage/labour-file/' . $labourID->labour_id . '/labour-manage-visa');
                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ หากไม่มีให้สร้างโฟลเดอร์
                    if (!file_exists($destination_directory)) {
                        mkdir($destination_directory, 0777, true); // สร้างโฟลเดอร์โดยใช้สิทธิ์เข้าถึง 0777
                    }
                    // ตรวจสอบว่าไฟล์ต้นทางมีอยู่หรือไม่ และคัดลอกไฟล์
                    if (file_exists($file_path_visa)) {
                        $destination = $destination_directory . '/' . $file_name;
                        copy($file_path_visa, $destination);
                    }
                    filesModel::create([
                        'labour_id' => $labourID->labour_id,
                        'files_type' => "เอกสารนายจ้างดำนเนินการต่อวีซ่าเอง",
                        'file_path' =>  'storage/labour-file/' . $labourID->labour_id . '/labour-manage-visa' . '/' . $file_name
                    ]);
                }

                // Upload File file_worl_manage
                if (!empty($row['file_work_manage'])) {
                    $file_path_work = $row['file_work_manage'];
                    $file_name = basename($file_path_work);
                    $destination_directory = public_path('storage/labour-file/' . $labourID->labour_id . '/labour-manage-work');
                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ หากไม่มีให้สร้างโฟลเดอร์
                    if (!file_exists($destination_directory)) {
                        mkdir($destination_directory, 0777, true); // สร้างโฟลเดอร์โดยใช้สิทธิ์เข้าถึง 0777
                    }
                    // ตรวจสอบว่าไฟล์ต้นทางมีอยู่หรือไม่ และคัดลอกไฟล์
                    if (file_exists($file_path_work)) {
                        $destination = $destination_directory . '/' . $file_name;
                        copy($file_path_work, $destination);
                    }
                    filesModel::create([
                        'labour_id' => $labourID->labour_id,
                        'files_type' => "เอกสารนายจ้างดำนเนินการต่อใบอนุญาตเอง",
                        'file_path' => 'storage/labour-file/' . $labourID->labour_id . '/labour-manage-work' . '/' . $file_name
                    ]);
                }
                // Upload File file_ninety_manage

                if (!empty($row['file_ninety_manage'])) {
                    $file_path_ninety = $row['file_ninety_manage'];
                    $file_name = basename($file_path_ninety);
                    $destination_directory = public_path('storage/labour-file/' . $labourID->labour_id . '/labour-manage-ninety');
                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ หากไม่มีให้สร้างโฟลเดอร์
                    if (!file_exists($destination_directory)) {
                        mkdir($destination_directory, 0777, true); // สร้างโฟลเดอร์โดยใช้สิทธิ์เข้าถึง 0777
                    }
                    // ตรวจสอบว่าไฟล์ต้นทางมีอยู่หรือไม่ และคัดลอกไฟล์
                    if (file_exists($file_path_ninety)) {
                        $destination = $destination_directory . '/' . $file_name;
                        copy($file_path_ninety, $destination);
                    }
                    filesModel::create([
                        'labour_id' => $labourID->labour_id,
                        'files_type' => "เอกสารนายจ้างดำนเนินการต่อรายงานตัว90วันเอง",
                        'file_path' =>  'storage/labour-file/' . $labourID->labour_id . '/labour-manage-ninety' . '/' . $file_name

                    ]);
                }



                // INSERT 90 Days
                if (!empty($row['ninety_date_start']) && !empty($row['ninety_date_end'])) {
                    update90dayModel::create([
                        'labour_id'        => $labourID->labour_id,
                        'labour_passport'  => $passport_number,
                        'ninety_date_start' => $row['ninety_date_start'],
                        'ninety_date_end'  => $row['ninety_date_end'],
                        'ninety_user_add'  => Auth::user()->name,
                    ]);
                    // Upload File



                }
            }
        }

        $this->labourAll = $labourIDs;
    }

    public function getExcelData()
    {
        return $this->labourAll;
    }

    public function getExcelColumns()
    {
        return $this->dataColumn;
    }
}

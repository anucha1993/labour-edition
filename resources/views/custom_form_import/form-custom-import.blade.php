@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>IMPORT-CUSTOM <small>นำเข้าข้อมูล แบบกำหนดเอง</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" href="#">Settings 1</a>
                                </li>
                                <li><a class="dropdown-item" href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('import.customLabourExcel') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-3"> <input type="file" name="file-excel"></div>
                            <div class="col-md-3"> <button type="submit" class="btn btn-success btn-sm">
                                    นำเข้าไฟล์ข้อมูล</button></div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>CREATE-FORM-CUSTOM <small>สร้างแบบฟอร์ม</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" href="#">Settings 1</a>
                                </li>
                                <li><a class="dropdown-item" href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <form action="{{ route('customFormImport.export') }}" method="post">
                        @csrf
                        @method('post')
                        <div class="form-group row">
                            <label class="col-md-3 col-sm-3  control-label">ข้อมูลส่วนตัว
                                <br>
                                <small class="text-navy">เลือกข้อมูลที่ต้องการ Update</small>
                            </label>

                            <div class="col-md-3 col-sm-3 ">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_agent" value="ชื่อเอเจนซี่" class="flat">
                                        ชื่อเอเจนซี่
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ID"></i>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_nationality" value="สัญชาติ" class="flat">
                                        สัญชาติ
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ID"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_textid" value="เลขบัตร ปปช" class="flat">
                                        เลขบัตร ปปช
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็นตัวเลข 13 หลักเท่านั้น"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_company" value="นายจ้าง/บริษัท (ระบุเป็น ID)"
                                            class="flat"> นายจ้าง/บริษัท
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ID"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="import_id" value="กลุ่มนำเข้า (ระบุเป็น ID)"
                                            class="flat"> กลุ่มนำเข้า
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ID"></i>
                                </div>

                            </div>

                            <label class="col-md-3 col-sm-3  control-label">ที่อยู่แรงงาน
                                <br>
                                <small class="text-navy">เลือกข้อมูลที่ต้องการ Update</small>
                            </label>
                            <div class="col-md-3 col-sm-3 ">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="addr_number" id="addr" value="เลขที่/หมู่/ซอย"
                                            class="flat-addr">
                                        เลขที่/หมู่/ซอย
                                    </label> 
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="DISTRICT_NAME" id="addr"
                                            value="ตำบล/แขวง(ระบุเป็น ID)" class="flat-district"> ตำบล/แขวง
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ID"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="AMPHUR_NAME" id="amphur-name"
                                            value="อำเภอ/เขต (ระบุเป็น ID)" class="flat-amphur"> อำเภอ/เขต
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ID"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="addr_province" id="addr-province"
                                            value="จังหวัด (ระบุเป็น ID)" class="flat-province"> จังหวัด
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ID"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="addr_note" value="เบอร์ติดต่อ" class="flat">
                                        เบอร์ติดต่อ
                                    </label>
                                </div>



                            </div>
                        </div>



                        <div class="x_title"> </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-sm-3  control-label">หนังสือเดินทาง
                                <br>
                                <small class="text-navy">เลือกข้อมูลที่ต้องการ Update</small>
                            </label>

                            <div class="col-md-3 col-sm-3 ">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_passport_date_start" value="วันที่ออกเล่ม"
                                            class="flat"> วันที่ออกเล่ม
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_passport_date_end" value="วันที่เล่มหมดอายุ"
                                            class="flat"> วันที่เล่มหมดอายุ
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>
                            </div>

                            <label class="col-md-3 col-sm-3  control-label">ข้อมูลวีซ่า
                                <br>
                                <small class="text-navy">เลือกข้อมูลที่ต้องการ Update</small>
                            </label>
                            <div class="col-md-3 col-sm-3 ">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_visa_number" value="เลขที่วีซ่า"
                                            class="flat"> เลขที่วีซ่า
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_visa_run_date" value="วันที่เดินทางเข้ามา"
                                            class="flat"> วันที่เดินทางเข้ามา
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_visa_date_start"
                                            value="วันเริ่มวิซ่า:(รอบต่อล่าสุด หรือ ต่อปี 3,ต่อครั้งแรก)" class="flat">
                                        วันเริ่มวิซ่า:(รอบต่อล่าสุด หรือ ต่อปี 3,ต่อครั้งแรก)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_visa_date_end"
                                            value="วันหมดวีซ่า:(รอบล่าสุด หรือ ต่อปี 3,ต่อครั้งแรก)" class="flat">
                                        วันหมดวีซ่า:(รอบล่าสุด หรือ ต่อปี 3,ต่อครั้งแรก)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_visa_date_start01"
                                            value="วันเริ่มวิซ่า:(ต่อปี 1)" class="flat"> วันเริ่มวิซ่า:(ต่อปี 1)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_visa_date_end01"
                                            value="วันหมดวีซ่า :(ต่อปี 1)" class="flat"> วันหมดวีซ่า :(ต่อปี 1)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_visa_date_start02"
                                            value="วันเริ่มวิซ่า:(ต่อปี 2)" class="flat"> วันเริ่มวิซ่า:(ต่อปี 2)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_visa_date_end02"
                                            value="วันหมดวีซ่า :(ต่อปี 2)" class="flat"> วันหมดวีซ่า :(ต่อปี 2)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>



                            </div>
                        </div>


                        <div class="x_title"> </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-sm-3  control-label">ใบอนุญาตทำงาน
                                <br>
                                <small class="text-navy">เลือกข้อมูลที่ต้องการ Update</small>
                            </label>

                            <div class="col-md-3 col-sm-3 ">

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work_permit_number" value="เลขใบอนุญาตทำงาน"
                                            class="flat"> เลขใบอนุญาตทำงาน
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็นข้อความ 13 หลัก"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_code" value="รหัสพนักงาน" class="flat">
                                        รหัสพนักงาน
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work_permit_date_start"
                                            value="ใบอนุญาตเริ่มต้น:(รอบล่าสุด)" class="flat">
                                        วันที่ใบอนุญาตเริ่มต้น:(รอบล่าสุด)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work_permit_date_end"
                                            value="ใบอนุญาตสิ้นสุด:(รอบล่าสุด)" class="flat">
                                        วันที่ใบอนุญาตสิ้นสุด:(รอบล่าสุด)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work_permit_date_start01"
                                            value="ใบอนุญาตเริ่มต้น:(รอบที่ 1)" class="flat"> วันที่ใบอนุญาตเริ่มต้น:
                                        (รอบที่
                                        1)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work_permit_date_end01"
                                            value="ใบอนุญาตสิ้นสุด:(รอบที่ 1)" class="flat"> วันที่ใบอนุญาตสิ้นสุด:
                                        (รอบที่ 1)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work_permit_date_start02"
                                            value="ใบอนุญาตเริ่มต้น:(รอบที่ 2)" class="flat"> วันที่ใบอนุญาตเริ่มต้น:
                                        (รอบที่
                                        2)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work_permit_date_end02"
                                            value="ใบอนุญาตสิ้นสุด:(รอบที่ 2)" class="flat"> วันที่ใบอนุญาตสิ้นสุด:
                                        (รอบที่ 2)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_department" value="แผนก" class="flat">
                                        แผนก
                                    </label>
                                </div>



                            </div>

                            <label class="col-md-3 col-sm-3  control-label">รายงายตัว 90 วัน
                                <br>
                                <small class="text-navy">เลือกข้อมูลที่ต้องการ Update</small>
                            </label>

                            <div class="col-md-3 col-sm-3 ">

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_ninety_date_start"
                                            value="รายงาน 90 เริ่มต้น: (รอบล่าสุด)" class="flat"> วันที่รายงาน 90 วัน
                                        เริ่มต้น: (รอบล่าสุด)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_ninety_date_end"
                                            value="รายงาน 90 สิ้นสุด: (รอบล่าสุด)" class="flat"> วันที่รายงาน 90 วัน
                                        สิ้นสุด:
                                        (รอบล่าสุด)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_immigration_number" value="เลขที่ ตม."
                                            class="flat"> เลขที่ ตม.
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_TM_province" value="ตม. จังหวัด."
                                            class="flat"> ตม. จังหวัด.
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็นข้อความ"></i>
                                </div>



                            </div>
                        </div>

                        <div class="x_title"> </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-sm-3  control-label">อื่นๆ
                                <br>
                                <small class="text-navy">เลือกข้อมูลที่ต้องการ Update</small>
                            </label>

                            <div class="col-md-3 col-sm-3 ">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work" value="สถานะทำงาน (Y/N)"
                                            class="flat-work"> สถานะทำงาน
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Y/N"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work_date" value="วันที่ทำงาน"
                                            class="flat-work-date"> วันที่ทำงาน
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_resign" value="สถานะลาออก (Y/N)"
                                            class="flat-resign"> สถานะลาออก
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Y/N"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_resign_date" value="วันที่ลาออก"
                                            class="flat-resign-date"> วันที่ลาออก
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Date"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_escape" value="สถานะลาออก (Y/N)"
                                            class="flat-escape"> สถานะหลบหนี <i class="fa fa-info-circle text-success"
                                            data-toggle="tooltip" data-placement="top" title="ระบุเป็น Y/N"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_escape_date" value="วันที่หลบหนี้"
                                            class="flat-escape-date"> วันที่หลบหนี้ <i
                                            class="fa fa-info-circle text-success" data-toggle="tooltip"
                                            data-placement="top" title="ระบุเป็น Date"></i>

                                </div>
                            </div>

                            <label class="col-md-3 col-sm-3  control-label">นายจ้างดำเนินการเอง
                                <br>
                                <small class="text-navy">เลือกข้อมูลที่ต้องการ Update</small>
                            </label>

                            <div class="col-md-3 col-sm-3 ">

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_passport_company_manage"
                                            value="หนังสือเดินทาง (นายจ้างดำเนินการเอง) (Y/N)"
                                            class="flat-passport-manage"> หนังสือเดินทาง (นายจ้างดำเนินการเอง)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Y/N"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="file_passport_manage"
                                            value="แนบหลักฐาน หนังสือเดินทาง (นายจ้างดำเนินการเอง)"
                                            class="flat-file-passport"> แนบหลักฐาน หนังสือเดินทาง (นายจ้างดำเนินการเอง)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ตำแหน่งไฟล์"></i>
                                </div>



                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_visa_company_manage"
                                            value="วีซ่า (นายจ้างดำเนินการเอง) (Y/N)" class="flat-visa-manage"> วีซ่า
                                        (นายจ้างดำเนินการเอง)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Y/N"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="file_visa_manage"
                                            value="แนบหลักฐาน วีซ่า (นายจ้างดำเนินการเอง)" class="flat-file-visa">
                                        แนบหลักฐาน วีซ่า (นายจ้างดำเนินการเอง)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ตำแหน่งไฟล์"></i>
                                </div>



                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_work_permit_company_manage"
                                            value="ใบอนุญาตทำงาน (นายจ้างดำเนินการเอง) (Y/N)" class="flat-work-manage">
                                        ใบอนุญาตทำงาน (นายจ้างดำเนินการเอง)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Y/N"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="file_work_manage"
                                            value="แนบหลักฐาน ใบอนุญาตทำงาน (นายจ้างดำเนินการเอง)" class="flat-file-work">
                                        แนบหลักฐาน ใบอนุญาตทำงาน (นายจ้างดำเนินการเอง)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ตำแหน่งไฟล์"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="labour_ninety_company_manage"
                                            value="รายตัว 90 วัน (นายจ้างดำเนินการเอง) (Y/N)" class="flat-ninety-manage">
                                        รายตัว 90 วัน (นายจ้างดำเนินการเอง)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น Y/N"></i>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="file_ninety_manage"
                                            value="แนบหลักฐาน รายตัว 90 วัน (นายจ้างดำเนินการเอง)"
                                            class="flat-file-ninety"> แนบหลักฐาน รายตัว 90 วัน (นายจ้างดำเนินการเอง)
                                    </label> <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                        data-placement="top" title="ระบุเป็น ตำแหน่งไฟล์"></i>
                                </div>


                            </div>


                        </div>


                        <button type="submit" class="btn btn-success pull-end">สร้างแบบฟอร์ม</button>
                    </form>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6>ข้อมูลนายจ้าง</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table" id="customer">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ชื่อบริษัท</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customer as $item)
                                        <tr>
                                            <td>{{ $item->company_id }}</td>
                                            <td>{{ $item->company_name }}</td>
                                        </tr>
                                    @empty
                                        No data Customer
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6>กลุ่มนำเข้า</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table" id="import-group">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ชื่อกลุ่มนำเข้า</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($importGroup as $item)
                                        <tr>
                                            <td>{{ $item->import_id }}</td>
                                            <td>{{ $item->import_name }}</td>
                                        </tr>
                                    @empty
                                        No data Customer
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6>สัญชาติ</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table" id="nationality">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ชื่อสัญชาติ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($nationality as $item)
                                        <tr>
                                            <td>{{ $item->nationality_id }}</td>
                                            <td>{{ $item->nationality_name }}</td>
                                        </tr>
                                    @empty
                                        No data Customer
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6>เอเจนซี่</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table" id="agent">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ชื่อเอเจนซี่</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($agent as $item)
                                        <tr>
                                            <td>{{ $item->agent_id }}</td>
                                            <td>{{ $item->agent_company }}</td>
                                        </tr>
                                    @empty
                                        No data Customer
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6>ที่อยู่ </h6>
                        </div>
                        <div class="card-body">
    
    
    
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2 col-sm-2 ">จังหวัด
                                    </label>
    
                                    <div class="col-md-8 col-sm-8 ">
                                        <select name="company_province" id="province" class="form-control" required>
                                            <option value="">None</option>
    
                                            @foreach ($provinces as $v)
                                                <option value="{{ $v->PROVINCE_ID }}">{{ $v->PROVINCE_NAME }} ({{$v->PROVINCE_ID }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
    
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2 col-sm-2 ">เขต/อำเภอ :
                                    </label>
    
                                    <div class="col-md-8 col-sm-8 ">
                                        <select name="company_area" id="amphur" class="form-control" required>
                                            <option value="">None</option>
                                        </select>
                                    </div>
    
    
                                </div>
    
    
    
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2 col-sm-2 ">แขวง/ตำบล :
                                    </label>
    
                                    <div class="col-md-8 col-sm-8 ">
                                        <select name="company_district" id="district" class="form-control" required>
                                            <option value="">None</option>
                                        </select>
                                    </div>
    
    
                                </div>
    
    
    
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2 col-sm-2 ">รหัสไปรษณีย์ :
                                    </label>
    
                                    <div class="col-md-8 col-sm-8 ">
                                        <input type="text" name="company_zipcode" id="zipcode" class="form-control"
                                            placeholder="รหัสไปรษณีย์" readonly>
                                    </div>
    
              
                        </div>
                    </div>
                </div>


            </div>



        </div>
    </div>



    <script>
        $(document).ready(function() {
            $('#customer').DataTable({
                order: []
            });
            $('#import-group').DataTable({
                order: []
            });
            $('#nationality').DataTable({
                order: []
            });

            $('#agent').DataTable({
                order: []
            });
        });

        $().ready(function() {
            $('#province').select2();
        });
        $().ready(function() {
            $('#amphur').select2();
        });
        $().ready(function() {
            $('#district').select2();
        });

        //  ส่งข้อมูลจังหวัด
        $(document).ready(function() {
            $('#province').change(function() {
                var select = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('address.provinces') }}",
                    method: 'GET',
                    data: {
                        select: select,
                        _token: _token
                    },
                    success: function(result) {
                        $('#amphur').html(result);
                    }
                });

            });

        });
        //ส่งข้อมูลอำเภอ
        $(document).ready(function() {
            $('#amphur').change(function() {
                var select = $(this).val();
                var _token = $('input[name="token"]').val();
                $.ajax({
                    url: "{{ route('address.amphures') }}",
                    method: 'GET',
                    data: {
                        select: select,
                        _token: _token,
                    },
                    success: function(result) {
                        $('#district').html(result);
                    }
                });
            });
        });
        //ส่งข้อมูลตำบล
        $(document).ready(function() {
            $('#district').change(function() {
                var select = $(this).val();
                var _token = $('input[name="token"]').val();

                $.ajax({
                    url: "{{ route('address.districts') }}",
                    method: 'GET',
                    data: {
                        select: select,
                        token: _token,
                    },
                    success: function(result) {
                        $('#zipcode').val(result);
                    }
                });
            });
        });

    </script>
    <script src="{{ URL::asset('js/form-custom-import/form-custom-import.js') }}"></script>
@endsection

@extends('layouts.layout')
@section('content')

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
    {{-- <button type="button"  data-bs-dismiss="alert" aria-label="Close"></button> --}}
    <strong>{{ $message }}</strong>
</div>
@endif

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2 class="text-success">เพิ่มข้อมูลคนงาน<small></small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{route('labour.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">

                                <h6>รายละเอียดส่วนตัว</h6>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">รหัสแรงงาน :</label>
                                            <input type="text" class="form-control" readonly placeholder="เลขอัตโนมัติ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">ชื่อเอเจนซี่ :</label>
                                            <select name="labour_agent" class="form-control" required="true">
                                                <option selected disabled>--Select A Agent</option>
                                                @foreach ($agents as $v)
                                                    <option value="{{ $v->agent_id }}">{{ $v->agent_company }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">สัญชาติ :</label>
                                            <select name="labour_nationality" class="form-control" required>
                                                <option selected disabled>--Select A Agent</option>
                                                @foreach ($nationality as $v)
                                                    <option value="{{ $v->nationality_id }}" data-icon="fa fa-plus-square">
                                                        {{ $v->nationality_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">เพศ :</label>
                                            <select name="labour_sex" class="form-control" required>
                                                <option selected disabled>--Select A Sex</option>
                                                <option value="1">ชาย</option>
                                                <option value="2">หญิง</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">คำนำหน้า/ชื่อ-นามสกุล :</label>
                                            <input type="text" name="labour_name" class="form-control"
                                                placeholder="Mr.ame-Lastname" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">เลขบัตรประจำตัวประชาชน :</label>
                                            <input type="text" name="labour_textid" class="form-control"
                                                placeholder="000 000 000 0" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันเกิด : <small class="text-success"
                                                    id="age-result"></small></label>
                                            <input type="date" id="birth-date" name="labour_birth_date"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="x_title">
                                    <h2 class="text-success">รายละเอียดนายจ้าง<small></small></h2>

                                    <div class="clearfix"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>บริษัท/นายจ้าง</label>
                                        <select name="labour_company" id="company" class="form-control select_company">
                                            <option selected disabled>---Select A Company---</option>
                                            @foreach ($companys as $v)
                                                <option value="{{ $v->company_id }}">{{ $v->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <br>
                                        <label for="">ทะเบียนบริษัท :</label>
                                        <p class="company_code"></p>
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <label for="">ชื่อนินติบุคคล :</label>
                                        <p class="company_fulnamme"></p>
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <label for="">เลขที่ :</label>
                                        <p class="company_house_number"></p>
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <label for="">ซอย :</label>
                                        <p class="company_alley"></p>
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <label for="">จังหวัด :</label>
                                        <p class="company_province"></p>
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <label for="">เขต / อำเภอ :</label>
                                        <p class="company_area"></p>
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <label for="">เแขวง / ตำบล :</label>
                                        <p class="company_district"></p>
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <label for="">รหัสไปรษณีย์ :</label>
                                        <p class="company_zipcode"></p>
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <label for="">เบอร์โทรศัพท์ :</label>
                                        <p class="company_tel"></p>
                                    </div>
                                </div>



                                <div class="x_title">
                                    <h2 class="text-success">รายละเอียดหนังสือเดินทาง<small></small></h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">เลขที่หนังสือเดินทาง :</label>
                                            <input type="text" name="labour_passport_number" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันที่ออกเล่ม :</label>
                                            <input type="date" name="labour_passport_date_start" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันที่หมดอายุ :</label> <small class="text-success"
                                                id="passport"></small>
                                            <input type="date" id="labour_passport_date_end"
                                                name="labour_passport_date_end" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="x_title">
                                    <h2 class="text-success">รายละเอียดวิซ่า<small></small></h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">เลขที่วิซ่า : </label>
                                            <input type="text" name="labour_visa_number" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันที่เดินทางเข้ามา : </label>
                                            <input type="date" name="labour_visa_run_date" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันเริ่มวิซ่า : (รอบต่อล่าสุด) </label>
                                            <input type="date" name="labour_visa_date_start" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันหมดวิซ่า :  </label>
                                            <input type="date" id="visa-end" name="labour_visa_date_end" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">จำนวนวันหมดอายุ</label>
                                            <p class="text-success" id="visa">รอคำนวน...</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันเริ่มวิซ่า : (รอบที่ 1) </label>
                                            <input type="date" name="labour_visa_date_start01" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันหมดวิซ่า :  </label>
                                            <input type="date"  name="labour_visa_date_end01" class="form-control" >
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันเริ่มวิซ่า : (รอบที่ 2) </label>
                                            <input type="date" name="labour_visa_date_start02" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">วันหมดวิซ่า :  </label>
                                            <input type="date"  name="labour_visa_date_end02" class="form-control">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="x_title">
                                    <h2 class="text-success">รายละเอียดใบอนุญาตทำงาน<small></small></h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">เลขที่ใบอนุญาตทำงาน :</label>
                                            <input type="text" name="labour_work_permit_number" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">รหัสพนักงาน :</label>
                                            <input type="text" name="labour_code" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">แผนก :</label>
                                            <input type="text" name="labour_department" class="form-control" >
                                        </div>
                                    </div>
                                    
                                </div>

                               <div class="row">
                                <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="">ใบอนุญาตทำงานเริ่มต้น : (รอบต่อล่าสุด)</label>
                                    <input type="date" name="labour_work_permit_date_start" class="form-control" required>
                                 </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="">ใบอนุญาตทำงานสิ้นสุด : </label>
                                       <input type="date" id="work-permit-end" name="labour_work_permit_date_end" class="form-control" required>
                                    </div>
                                   </div>
                                   <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">จำนวนวันหมดอายุ</label>
                                        <p class="text-success" id="work-permit">รอคำนวน...</p>
                                    </div>
                                </div>
                               </div>

                               <div class="row">
                                <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="">ใบอนุญาตทำงานเริ่มต้น : (รอบที่ 1)</label>
                                    <input type="date" name="labour_work_permit_date_start01" class="form-control">
                                 </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="">ใบอนุญาตทำงานสิ้นสุด : </label>
                                       <input type="date" name="labour_work_permit_date_end01" class="form-control">
                                    </div>
                                   </div>
                               </div>
                               <div class="row">
                                <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="">ใบอนุญาตทำงานเริ่มต้น : (รอบที่ 2)</label>
                                    <input type="date" name="labour_work_permit_date_start02" class="form-control">
                                 </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="">ใบอนุญาตทำงานสิ้นสุด : </label>
                                       <input type="date" name="labour_work_permit_date_end02" class="form-control">
                                    </div>
                                   </div>
                               </div>
                                
                               <div class="x_title">
                                <h2 class="text-success">รายละเอียดรายงานตัว 90 วัน<small></small></h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">วันที่รายงายตัว 90 วัน เริ่มต้น </label>
                                        <input type="date" name="labour_ninety_date_start" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">วันที่รายงายตัว 90 วัน สิ้นสุด </label>
                                        <input type="date" id="ninety-end" name="labour_ninety_date_end" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">จำนวนวันหมดอายุ</label>
                                        <p class="text-success" id="ninety">รอคำนวน...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="x_title">
                                <h2 class="text-success">รายละเอียด ตม.<small></small></h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">เลขที่่ ตม.</label>
                                        <input type="text" name="labour_immigration_number" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">ตม.จังหวัด</label>
                                        <input type="text" name="labour_TM_province" class="form-control" >
                                    </div>
                                </div>
                            </div>

                            <div class="x_title">
                                <h2 class="text-success">รายละเอียด การทำงาน<small></small></h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-1">
                                    <input type="checkbox" name="labour_work" value="Y" class="flat" checked="checked" style="position: absolute; opacity: 0;">
                                   <label for="labour_work">ทำงาน</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >วันที่เริ่มทำงาน :</label>
                                        <input type="date" name="labour_work_date" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <input type="checkbox" name="labour_escape" value="Y" class="flat"  style="position: absolute; opacity: 0;">
                                   <label for="labour_work">หลบหนี</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >วันที่เริ่มทำงาน :</label>
                                        <input type="date" name="labour_escape_date" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <input type="checkbox" name="labour_escape" class="flat" value="Y"  style="position: absolute; opacity: 0;">
                                   <label for="labour_work">ลาออก</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >วันที่เริ่มทำงาน :</label>
                                        <input type="date" name="labour_escape_date" class="form-control">
                                    </div>
                                </div>
                            </div>

                            </div>
                            <br>

                            <div class="col-md-2">
                                <label for="">สถานะคนงาน</label>
                                <div class="form-group">
                                    <input type="radio" value="Y" class="flat" checked="" name="labour_status" style="position: absolute; opacity: 0;">
                                    <label for="">เปิดใช้งาน</label>
                                    <input type="radio" value="N" class="flat"  name="labour_status" style="position: absolute; opacity: 0;">
                                    <label for="">ปิดใช้งาน</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">หมายเหตุ</label>
                                    <textarea name="labour_note" class="form-control" cols="15" rows="5"></textarea>
                                </div>
                            </div>
                            

                            </div>
                            <button type="submit" class="btn btn-primary pull-right">บันทึก</button>



                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#company').select2();
        });

        //ajax select
       //ajax select
       $(document).ready(function() {
            // โค้ดที่คุณต้องการให้ทำงานเมื่อหน้าโหลดเสร็จสมบูรณ์
            $('.select_company').change(function() {
                if ($(this).val() != '') {
                    var select = $(this).val();
                    console.log(select);
                    var _token = $('input[name="_token"]').val();
                    console.log(select);
                    $.ajax({
                        url: "{{ route('address.show') }}",
                        method: "GET",
                        data: {
                            select: select,
                            _token
                        },
                        success: function(result) {
                            //Company
                            $('.company_code').html(result.company.company_code);
                            $('.company_fulnamme').html(result.company.company_surname);
                            $('.company_house_number').html(result.company.company_house_number);
                            $('.company_alley').html(result.company.company_alley);
                            $('.company_zipcode').html(result.company.company_zipcode);
                            $('.company_tel').html(result.company.company_tel);
                            //Company amphur
                            $('.company_area').html(result.amphur.AMPHUR_NAME);
                            //district
                             $('.company_district').html(result.district.DISTRICT_NAME);
                             //province
                             $('.company_province').html(result.province.PROVINCE_NAME);
                        }
                    });
                }
            });
        });



        function calculateAge() {
            // ดึงค่าวันเกิดจากฟอร์ม
            const birthDateInput = document.getElementById("birth-date");
            const birthDateValue = new Date(birthDateInput.value);

            // วันปัจจุบัน
            const currentDate = new Date();

            // คำนวณอายุ
            const ageInMilliseconds = currentDate - birthDateValue;
            const ageDate = new Date(ageInMilliseconds);
            const years = ageDate.getUTCFullYear() - 1970;
            const months = ageDate.getUTCMonth();
            const days = ageDate.getUTCDate() - 1;

            // แสดงผลลัพธ์ในฟอร์ม
            const resultElement = document.getElementById("age-result");
            resultElement.innerHTML = `อายุ: ${years} ปี ${months} เดือน ${days} วัน`;
        }

        // เมื่อมีการเปลี่ยนค่าใน input วันเกิด ให้คำนวณอายุ
        document.getElementById("birth-date").addEventListener("change", calculateAge);


        // เมื่อมีการเปลี่ยนแปลงในวันที่หมดอายุ
        $('#labour_passport_date_end').change(function() {
            var endDate = new Date($(this).val()); // วันที่หมดอายุที่เลือก
            var currentDate = new Date(); // วันที่ปัจจุบัน
            var timeDiff = endDate - currentDate;

            if (timeDiff < 0) {
                $('#passport').text('หมดอายุแล้ว');
            } else {
                var years = Math.floor(timeDiff / (365 * 24 * 60 * 60 * 1000));
                timeDiff -= years * (365 * 24 * 60 * 60 * 1000);

                var months = Math.floor(timeDiff / (30 * 24 * 60 * 60 * 1000));
                timeDiff -= months * (30 * 24 * 60 * 60 * 1000);

                var days = Math.floor(timeDiff / (24 * 60 * 60 * 1000));

                $('#passport').text(years + ' ปี ' + months + ' เดือน ' + days + ' วัน');
            }
        });

        // Visa
        $('#visa-end').change(function() {
            var endDate = new Date($(this).val()); // วันที่หมดอายุที่เลือก
            var currentDate = new Date(); // วันที่ปัจจุบัน
            var timeDiff = endDate - currentDate;

            if (timeDiff < 0) {
                $('#visa').text('หมดอายุแล้ว');
            } else {
                var years = Math.floor(timeDiff / (365 * 24 * 60 * 60 * 1000));
                timeDiff -= years * (365 * 24 * 60 * 60 * 1000);

                var months = Math.floor(timeDiff / (30 * 24 * 60 * 60 * 1000));
                timeDiff -= months * (30 * 24 * 60 * 60 * 1000);

                var days = Math.floor(timeDiff / (24 * 60 * 60 * 1000));

                $('#visa').text(years + ' ปี ' + months + ' เดือน ' + days + ' วัน');
            }
        });

         // work premit
         $('#work-permit-end').change(function() {
            var endDate = new Date($(this).val()); // วันที่หมดอายุที่เลือก
            var currentDate = new Date(); // วันที่ปัจจุบัน
            var timeDiff = endDate - currentDate;

            if (timeDiff < 0) {
                $('#work-permit').text('หมดอายุแล้ว');
            } else {
                var years = Math.floor(timeDiff / (365 * 24 * 60 * 60 * 1000));
                timeDiff -= years * (365 * 24 * 60 * 60 * 1000);

                var months = Math.floor(timeDiff / (30 * 24 * 60 * 60 * 1000));
                timeDiff -= months * (30 * 24 * 60 * 60 * 1000);

                var days = Math.floor(timeDiff / (24 * 60 * 60 * 1000));

                $('#work-permit').text(years + ' ปี ' + months + ' เดือน ' + days + ' วัน');
            }
        });

         // ninety
         $('#ninety-end').change(function() {
            var endDate = new Date($(this).val()); // วันที่หมดอายุที่เลือก
            var currentDate = new Date(); // วันที่ปัจจุบัน
            var timeDiff = endDate - currentDate;

            if (timeDiff < 0) {
                $('#ninety').text('หมดอายุแล้ว');
            } else {
                var years = Math.floor(timeDiff / (365 * 24 * 60 * 60 * 1000));
                timeDiff -= years * (365 * 24 * 60 * 60 * 1000);

                var months = Math.floor(timeDiff / (30 * 24 * 60 * 60 * 1000));
                timeDiff -= months * (30 * 24 * 60 * 60 * 1000);

                var days = Math.floor(timeDiff / (24 * 60 * 60 * 1000));

                $('#ninety').text(years + ' ปี ' + months + ' เดือน ' + days + ' วัน');
            }
        });


    </script>

    
@endsection

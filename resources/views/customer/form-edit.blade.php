@extends('layouts.layout')
@section('content')
    @if ($message = Session::get('success'))
        <script>
            var message = @json($message);
            Swal.fire({
                icon: "success",
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @if ($message = Session::get('error'))
    <script>
        var message = @json($message);
        Swal.fire({
            icon: "error",
            title: message,
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif


        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2 class="text-success">แก้ไขข้อมูลนายจ้าง<small></small><span>{{$customer->company_number}}</span></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <form action="{{ route('customer.update',$customer->company_id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ชื่อบริษัท :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <input type="text" class="form-control" id="company_name" placeholder="ชื่อบริษัท"
                                        name="company_name" value="{{$customer->company_name}}">
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ทะเบียนเลขที่ :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <input type="text" class="form-control" id="company_code"
                                        placeholder="ทะเบียนบริษัทเลขที่" name="company_code" value="{{$customer->company_code}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ชื่อนายจ้าง :
                                </label>

                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_surname" placeholder="ชื่อ" value="{{$customer->company_surname}}" 
                                        name="company_surname">
                                </div>
                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_lastname" placeholder="นามสกุล" value="{{$customer->company_lastname}}" 
                                        name="company_lastname">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">เบอร์โทรศัพท์ :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <input type="text" class="form-control" id="company_tel" value="{{$customer->company_tel}}" 
                                        placeholder="เบอร์โทรศัพท์ 02" name="company_tel">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">แฟกซ์ :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <input type="text" class="form-control" id="company_fax" placeholder="แฟกซ์ 02"
                                        name="company_fax" value="{{$customer->company_fax}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">อีเมล์ :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <input type="text" class="form-control" id="company_email" placeholder="อีเมล์"  value="{{$customer->company_email}}" 
                                        name="company_email">
                                </div>
                            </div>

                            <div class="x_title">
                                <h2 class="text-success">กรรมการผู้มีอำนาจลงนาม<small></small></h2>

                                <div class="clearfix"></div>
                            </div>



                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ชื่อกรรมการ ท่านที่ 1 :
                                </label>

                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_surname_1"
                                        placeholder="ชื่อ" name="company_authorized_surname_1" value="{{$customer->company_authorized_surname_1}}" >
                                </div>
                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_lastname_1" value="{{$customer->company_authorized_lastname_1}}"
                                        placeholder="นามสกุล" name="company_authorized_lastname_1">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ชื่อกรรมการ ท่านที่ 2 :
                                </label>

                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_surname_2" value= "{{$customer->company_authorized_surname_2}}" 
                                        placeholder="ชื่อ" name="company_authorized_surname_2">
                                </div>
                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_lastname_2" value= "{{$customer->company_authorized_lastname_2}}"
                                        placeholder="นามสกุล" name="company_authorized_lastname_2">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ชื่อกรรมการ ท่านที่ 3 :
                                </label>

                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_surname_3" value= "{{$customer->company_authorized_surname_3}}"
                                        placeholder="ชื่อ" name="company_authorized_surname_3">
                                </div>
                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_lastname_3" value= "{{$customer->company_authorized_lastname_3}}"
                                        placeholder="นามสกุล" name="company_authorized_lastname_3">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ชื่อกรรมการ ท่านที่ 4 :
                                </label>

                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_surname_4" value= "{{$customer->company_authorized_surname_4}}"
                                        placeholder="ชื่อ" name="company_authorized_surname_4">
                                </div>
                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_lastname_4" value= "{{$customer->company_authorized_lastname_4}}"
                                        placeholder="นามสกุล" name="company_authorized_lastname_4">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ชื่อกรรมการ ท่านที่ 5 :
                                </label>

                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_surname_5" value= "{{$customer->company_authorized_surname_5}}"
                                        placeholder="ชื่อ" name="company_authorized_surname_5">
                                </div>
                                <div class="col-md-4 col-sm-4 ">
                                    <input type="text" class="form-control" id="company_authorized_lastname_5" value= "{{$customer->company_authorized_lastname_5}}"
                                        placeholder="นามสกุล" name="company_authorized_lastname_5">
                                </div>

                            </div>








                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">เลขที่ / หมู่ / ตึก : *
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <textarea name="company_house_number" class="form-control" cols="30" rows="3">{{$customer->company_house_number}}</textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">จังหวัด
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <select name="company_province" id="province" class="form-control" required>
                                        <option value="">None</option>
                                         @php
                                             $provinceName = DB::table('provinces')->where('PROVINCE_ID',$customer->company_province)->first();
                                         @endphp
                                         <option selected value="{{$provinceName->PROVINCE_ID}}">{{$provinceName->PROVINCE_NAME}}</option>

                                        @foreach ($provinces as $v)
                                            <option value="{{ $v->PROVINCE_ID }}">{{ $v->PROVINCE_NAME }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">เขต/อำเภอ :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <select name="company_area" id="amphur" class="form-control" required>
                                        @php
                                        $ampuresName = DB::table('amphures')->where('AMPHUR_ID',$customer->company_area)->first();
                                    @endphp
                                    <option selected value="{{$ampuresName->AMPHUR_ID}}">{{$ampuresName->AMPHUR_NAME}}</option>


                                        <option value="">None</option>
                                    </select>
                                </div>


                            </div>



                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">แขวง/ตำบล :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <select name="company_district" id="district" class="form-control" required>
                                        @php
                                        $districtName = DB::table('districts')->where('DISTRICT_CODE',$customer->company_district)->first();
                                    @endphp
                                    @if(!empty($districtName->DISTRICT_CODE))
                                    <option selected value="{{($districtName->DISTRICT_CODE)}}">{{$districtName->DISTRICT_NAME}}</option>
                                    @endif
                                  

                                        <option value="">None</option>
                                    </select>
                                </div>


                            </div>



                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">รหัสไปรษณีย์ :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <input type="text" name="company_zipcode" id="zipcode" class="form-control"
                                        placeholder="รหัสไปรษณีย์" readonly value="{{$customer->company_zipcode}}">
                                </div>

                            </div>




                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ประเภทกิจการ :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <input type="text" name="company_business_type" class="form-control" value="{{$customer->company_business_type}}"
                                        placeholder="ประเภทกิจการ">
                                </div>


                            </div>



                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">ผู้ประสานงาน :
                                </label>

                                <div class="col-md-8 col-sm-8 ">
                                    <input type="text" name="company_coordinator" class="form-control" value="{{$customer->company_coordinator}}"
                                        placeholder="ประเภทกิจการ">
                                </div>


                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-2 col-sm-2 ">หมายเหตุ :
                                </label>
                                <div class="col-md-8 col-sm-8 ">
                                    <textarea name="company_note" class="form-control" cols="30" rows="7">{{$customer->company_note}}</textarea>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-12">
                            <input type="radio" class="flat" name="company_status" value="Close"  @if ($customer->company_status == "Close") checked @endif><label for="status"> เปิดใช้งาน </label>
                            <input type="radio" class="flat" name="company_status" value="Ready"  @if ($customer->company_status == "Ready") checked @endif><label for="status"> ปิดใช้งานชั่วคราว </label>
                            <input type="radio" class="flat" name="company_status" value="Notcontact"  @if ($customer->company_status == "Notcontact") checked @endif><label for="status"> ปิดใช้งานถาวร </label>
                           </div>

                        <div class="col-md-12">
                            <div class="x_title">
                                <h2 class="text-success"><small></small></h2>

                                <div class="clearfix"></div>
                            </div>
                            <button type="submit" class="btn btn-success">เพิ่มข้อมูลนายจ้าง</button>
                        </div>




                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
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
@endsection

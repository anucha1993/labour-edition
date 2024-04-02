@extends('layouts.layout')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Import <small>นำเข้าข้อมูลข้อมูลคนต่างด้าวทั้งหมด</small>&nbsp;
                        <span><a href="{{ URL::asset('master-import-file/labour.xlsx') }}"
                                class="text-success pull-right  "> &nbsp;<i class="fa fa-file-excel-o"></i>
                                ดาวน์โหลดฟอร์มต้นฉบับ</a></span>
                        <span><a href="{{ URL::asset('master-import-file/addressID.xlsx') }}"
                                class="text-success pull-right  "> &nbsp;<i class="fa fa-file-excel-o"></i>
                                รายชื่อที่อยู่</a></span>
                    </h2>
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
                    <br />
                    <form action="{{ route('excelImport.import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ชื่อบริษัท :</label>
                                    <select name="company" class="form-control" id="company">
                                        @foreach ($company as $v)
                                            <option value="{{ $v->company_id }}">{{ $v->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>เอเจนซี่ :</label>
                                    <select name="agency" class="form-control">
                                        @foreach ($agents as $v)
                                            <option value="{{ $v->agent_id }}">{{ $v->agent_company }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>สัญชาติ :</label>
                                    <select name="nationality" class="form-control">
                                        @foreach ($nationality as $v)
                                            <option value="{{ $v->nationality_id }}">{{ $v->nationality_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>อัพโหลดข้อมูล :</label>
                                    <input type="file" name="file-excel" id="file-excel" class="form-control">
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Actions</label>
                                    <br>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i>
                                        นำเข้าข้อมูล</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Address <small>ตรวจสอบที่อยู่</small>&nbsp;

                    </h2>
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
                    <div class="col-md-6">
                        <form action="#">
                            <textarea name="addressInput" id="addressInput" cols="30" rows="3" class="form-control addressInput"></textarea>
                        </form>
                    </div>
                    <div class="col-md-6" id="address">
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token">

    <script>
        $(document).ready(function() {
            $('#company').select2({});
        });



        $(document).ready(function() {
            $('.addressInput').on('change', function() {
                var address = $('#addressInput').val().trim();
                var _token = $("#_token").val();

                if (address !== '') {
                    // address = address.replace(/\s+/g, '');
                    var parts = address.split(' ');

                    // หาชื่อจังหวัดในอาร์เรย์ parts โดยวนลูป
                    var provinceName;
                    for (var i = 0; i < parts.length; i++) {
                        // หากพบคำที่มีรูปแบบของชื่อจังหวัด
                        if (parts[i].indexOf('จังหวัด') !== -1) {
                           // provinceName = parts[i].replace('จังหวัด', ' ');
                           parts[i] = parts[i].replace('จังหวัด', '');
                            break; // หยุดการวนลูปเมื่อพบชื่อจังหวัด
                        }
                    }
                    var ampurName;
                    for (var i = 0; i < parts.length; i++) {
                        // หากพบคำที่มีรูปแบบของชื่อจังหวัด
                        if (parts[i].indexOf('อำเภอ') !== -1) {
                          ///  ampurName = parts[i].replace('อำเภอ', '');
                            parts[i] = parts[i].replace('อำเภอ', '');
                            break; // หยุดการวนลูปเมื่อพบชื่อจังหวัด
                        }
                    }
                    var district;
                    for (var i = 0; i < parts.length; i++) {
                        // หากพบคำที่มีรูปแบบของชื่อจังหวัด
                        if (parts[i].indexOf('ตำบล') !== -1) {
                           // district = parts[i].replace('ตำบล', '');
                            parts[i] = parts[i].replace('ตำบล', '');
                           
                            break; 
                        }
                       
                    }
                   
                    console.log(parts);
                  // console.log(provinceName + ampurName + district);

                    // ส่งข้อมูลไปยังเซิร์ฟเวอร์โดยใช้ชื่อจังหวัดที่พบ
                    $.ajax({
                        url: '{{ route('checkaddress') }}',
                        method: 'POST',
                        data: {
                            _token: _token,
                            parts: parts,
                        },
                        success: function(response) {
                        console.log(response); // เรียกใช้ฟังก์ชัน displayResult ด้วยข้อมูลที่ได้รับกลับมา
                        var html = '<span>ตำบล/แขวง : ' + (response.district != null ? response.district.DISTRICT_NAME : '<span>ไม่พบข้อมูล</span>') +
                                   ' อำเภอ/เขต : ' + (response.amphur != null ? response.amphur.AMPHUR_NAME : '<span>ไม่พบข้อมูล</span>') +
                                   ' จังหวัด : ' + (response.provinces != null ? response.provinces.PROVINCE_NAME : '<span>ไม่พบข้อมูล</span>') +
                                   ' รหัสไปรษณีย์ : ' + (response.zipcodes != null ? response.zipcodes.zipcode : '<span>ไม่พบข้อมูล</span>') + '</span>';
                                 $('#address').append(html);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                           
                        }
                    });
                }
            });
        });
        //  // นิยามฟังก์ชัน displayResult เพื่อแสดงผลลัพธ์ที่ได้รับกลับมาจากเซิร์ฟเวอร์
        //  function displayResult(response) {
        //         console.log(response); // แสดงผลลัพธ์ที่ได้รับกลับมาในคอนโซล
        //     }
    </script>
@endsection

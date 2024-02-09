@extends('layouts.layout')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
  
    @if ($status)
    <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
        <strong>บันทึกข้อมูลสำเร็จ!!</strong>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Import <small>นำเข้าข้อมูล ที่อยู่แรงงาน</small>&nbsp; <span><a
                                href="{{ URL::asset('master-import-file/address.xlsx') }}"
                                class="text-success pull-right  ">
                                &nbsp;<i class="fa fa-file-excel-o"></i> ดาวน์โหลดฟอร์มต้นฉบับ</a></span></h2>
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
                {{-- เนื้อหา --}}
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ route('addressLabour.import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="file" class="form-control" name="file-excel" required>
                                </div>
                                <button type="submit" class="btn btn-success">ตรวจสอบข้อมูล</button>
                            </form>
                        </div>
                        
                        @if ($excelData)
                            <div class="col-md-9">

                                <form action="{{route('addressLabour.store')}}" method="post">
                                    @csrf
                                    <button class="btn btn-primary" id="btn-submit">ยืนยันข้อมูล</button>
                                    <table class="table table">
                                        <thead>
                                            <tr>
                                                <th>สัญชาติ</th>
                                                <th>เลขพาส</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>ที่อยู่</th>
                                                <th>หมายเหตุ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($excelData as $item)
                                                @php

                                                    $labour = DB::table('labour')
                                                        ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
                                                        ->where('labour_passport_number', $item[0])
                                                        ->first();
                                                    $provinceGET = DB::table('provinces')
                                                        ->where('PROVINCE_NAME', 'LIKE', '%' . $item[4] . '%')
                                                        ->pluck('PROVINCE_ID')
                                                        ->toArray();
                                                    $amphuresGET = DB::table('amphures')
                                                        ->whereIn('PROVINCE_ID', $provinceGET)
                                                        ->where('AMPHUR_NAME', 'LIKE', '%' . $item[3] . '%')
                                                        ->get();
                                                    $amphuresArray = $amphuresGET->pluck('AMPHUR_ID')->toArray();
                                                    $PROVINCE_ID = $amphuresGET->pluck('PROVINCE_ID')->toArray();

                                                    $districtsGET = DB::table('districts')
                                                        ->whereIn('AMPHUR_ID', $amphuresArray)
                                                        ->where('DISTRICT_NAME', 'LIKE', '%' . $item[2] . '%')
                                                        ->get();

                                                    $districtsArray = $districtsGET->pluck('DISTRICT_CODE')->toArray();
                                                    $AMPHUR_ID = $districtsGET->pluck('AMPHUR_ID')->toArray();

                                                    $province = DB::table('provinces')
                                                        ->whereIn('PROVINCE_ID', $PROVINCE_ID)
                                                        ->first();
                                                    //  dd($item[4]);

                                                    if($province == NULL) {
                                                        $province = (object)['PROVINCE_NAME' => NULL];
                                                    }

                                                    if ($AMPHUR_ID) {
                                                        $amphures = DB::table('amphures')
                                                            ->whereIn('AMPHUR_ID', $AMPHUR_ID)
                                                            ->first();
                                                    } else {
                                                        $amphures = (object) ['AMPHUR_NAME' => null];
                                                    }
                                                    if ($districtsArray) {
                                                        $zipcode = DB::table('zipcodes')
                                                            ->whereIn('district_code', $districtsArray)
                                                            ->first();
                                                    } else {
                                                        $zipcode = (object) ['district_code' => null, 'zipcode' => null];
                                                    }

                                                    if ($zipcode->district_code) {
                                                        $districts = DB::table('districts')
                                                            ->where('district_code', $zipcode->district_code)
                                                            ->first();
                                                    } else {
                                                        $districts = (object) ['DISTRICT_NAME' => null];
                                                    }

                                                   

                                                @endphp
                                                @if ($labour)
                                                    <tr>
                                                        <td>{{ $labour->nationality_name }}</td>
                                                        <td>{{ $labour->labour_passport_number }}</td>
                                                        <td>{{ $labour->labour_name }}</td>
                                                        <td>
                                                            {{ $item[1] . ' ' }}
                                                            {!! $districts->DISTRICT_NAME != null ? $districts->DISTRICT_NAME: "<span class='text-danger'>ไม่พบตำบล/แขวง </span>" !!}
                                                            {!! $amphures->AMPHUR_NAME != null ? $amphures->AMPHUR_NAME : "<span class='text-danger'>ไม่พบอำเภอ/เขต</span>" !!}
                                                            {!! $province->PROVINCE_NAME != null ? $province->PROVINCE_NAME: "<span class='text-danger'>ไม่พบจังหวัด</span>" !!}
                                                            {!! $zipcode->zipcode != null ? $zipcode->zipcode : "<span class='text-danger'>ไม่พบรหัสไปรษณี </span>" !!}

                                                            <input type="hidden" name="labour_id[]"       value="{{$labour->labour_id}}">
                                                            <input type="hidden" name="labour_passport[]" value="{{$labour->labour_passport_number}}">
                                                            <input type="hidden" name="addr_number[]"     value="{{$item[1]}}">
                                                            <input type="hidden" name="addr_province[]"   value="{{$province->PROVINCE_ID}}">
                                                            <input type="hidden" name="addr_amphur[]"     value="{{$amphures->AMPHUR_ID}}">
                                                            <input type="hidden" name="addr_distict[]"    value="{{$districts->DISTRICT_CODE}}">
                                                            <input type="hidden" name="addr_zipcode[]"    value="{{$zipcode->zipcode}}">
                                                            <input type="hidden" name="addr_note[]"       value="{{$item[5]}}">

                                                        </td>
                                                        <td>{{ $item[5] }}</td>
                                                    </tr>
                                                @else
                                                <tr>
                                                    <td><span class="text-danger">ไม่พบข้อมูล</span></td>
                                                    <td>{{$item[0]}}</td>
                                                    <td><span class="text-danger">ไม่พบข้อมูล</span></td>
                                                    <td><span class="text-danger">ไม่พบข้อมูล</span></td>
                                                    <td><span class="text-danger">ไม่พบข้อมูล</span></td>
          
                                                </tr>
                                                @endif

                                                <script>
                                                    var btnSubmit = document.getElementById('btn-submit');
                                                    var zipcode   = <?php echo json_encode($zipcode);  ?>;
                                                    var amphures  = <?php echo json_encode($amphures); ?>;
                                                    var districts = <?php echo json_encode($districts);?>;
                                                    var province  = <?php echo json_encode($province); ?>;
                                                    var labour    = <?php echo json_encode($labour);   ?>;
                                                    console.log(labour);
                                                    if(labour === null){
                                                        btnSubmit.disabled = true;
                                                        btnSubmit.innerText = 'ผิดพลาดกรุณาตรวจสอบข้อมูล';
                                                        btnSubmit.classList.add('btn-danger');
                                                    }
                                            
                                                    // ตรวจสอบว่า zipcode มีค่าหรือไม่
                                                    if (zipcode === null) {
                                                        btnSubmit.disabled = true;
                                                        btnSubmit.innerText = 'ผิดพลาดกรุณาตรวจสอบข้อมูล';
                                                        btnSubmit.classList.add('btn-danger');
                                                    }
                                            
                                                    // ตรวจสอบว่า amphures.AMPHUR_NAME มีค่าหรือไม่
                                                    if (amphures.AMPHUR_NAME === null) {
                                                        btnSubmit.disabled = true;
                                                        btnSubmit.innerText = 'ผิดพลาดกรุณาตรวจสอบข้อมูล';
                                                        btnSubmit.classList.add('btn-danger');
                                                    }
                                            
                                                    // ตรวจสอบว่า districts.DISTRICT_NAME มีค่าหรือไม่
                                                    if (districts.DISTRICT_NAME === null) {
                                                        btnSubmit.disabled = true;
                                                        btnSubmit.innerText = 'ผิดพลาดกรุณาตรวจสอบข้อมูล';
                                                        btnSubmit.classList.add('btn-danger');
                                                    }
                                            
                                                    // ตรวจสอบว่า province.PROVINCE_NAME มีค่าหรือไม่
                                                    if (province.PROVINCE_NAME === null) {
                                                        btnSubmit.disabled = true;
                                                        btnSubmit.innerText = 'ผิดพลาดกรุณาตรวจสอบข้อมูล';
                                                        btnSubmit.classList.add('btn-danger');
                                                    }
                                                </script>

                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>


            </div>
        </div>
    </div>
    <script>
    // ตรวจสอบว่ามีการรีเฟรชหน้าหรือไม่
    if (performance.navigation.type === 1) {
        // ถ้ามีการรีเฟรช ให้ทำการเปลี่ยนทางไปยัง URL ที่กำหนด
        window.location.href = "{{ url(route('addressLabour.index')) }}";
    }
</script>


@endsection

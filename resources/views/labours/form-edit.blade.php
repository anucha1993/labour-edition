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

    <form action="{{ route('labour.update', $labourModel->labour_id) }}" method="post">
        @csrf
        @method('put')
        <input type="hidden" value="{{ $labourModel->labour_id }}" name="labour_id">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form-Edit <small>แก้ไขข้อมูลคนงาน</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Settings 1</a>
                                    <a class="dropdown-item" href="#">Settings 2</a>
                                </div>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-3 col-sm-3  profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    <!-- Current avatar -->
                                    @php
                                        $na = $nationality
                                            ->where('nationality_id', $labourModel->labour_nationality)
                                            ->first();
                                    @endphp
                                    <i style="font-size: 150px" class="fa {{ $na->nationality_flag }}"></i>
                                </div>
                            </div>
                            <br>
                            <h4 style="font-size: 20px">{{ $labourModel->labour_name }}</h4>

                            <ul class="list-unstyled user_data">
                                <li><i class="fa fa-map-marker user-profile-icon"></i> {{ $AddressLabour }}
                                </li>
                                <li>
                                    <i class="fa fa-car" aria-hidden="true"></i> {!! optional($ComAddr)->company_name ? $ComAddr->company_name . '<br>' . $AddressCompany : 'ไม่พบข้อมูล' !!}

                                </li>
                                <li>
                                    <i class="fa fa-briefcase user-profile-icon"></i>
                                    {{ $labourModel->labour_department !== null ? $labourModel->labour_department : 'ไม่พบข้อมูล' }}
                                </li>

                                <li class="m-top-xs">
                                    <i class="fa fa-book"></i>
                                    {{ $labourModel->labour_passport_number }}
                                </li>
                            </ul>

                            <a class="btn btn-success text-white">{{ $na->nationality_name }}</a>
                            <br />
                            <div class="row">
                                <div class="col-md-9 col-sm-9 ">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" @if ($labourModel->labour_passport_company_manage == "Y")  checked @endif name="labour_passport_company_manage"  class="flat-passport text-danger"> หนังสือเดินทาง
                                            (นายจ้างดำเนินการเอง)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-9 ">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" @if ($labourModel->labour_visa_company_manage == "Y") checked @endif  name="labour_visa_company_manage" class="flat-visa"> วีซ่า (นายจ้างดำเนินการเอง)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-9 ">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" @if ($labourModel->labour_work_permit_company_manage == "Y") checked @endif name="labour_work_permit_company_manage" class="flat-work" > ใบอนุญาตทำงาน (นายจ้างดำเนินการเอง)
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-9 col-sm-9 ">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" @if ($labourModel->labour_ninety_company_manage == "Y") checked @endif  name="labour_ninety_company_manage"  class="flat-90days"> รายตัว 90 วัน (นายจ้างดำเนินการเอง)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- start skills -->
                            <h4>รายละเอียดทั่วไป</h4>
                            <ul class="list-unstyled user_data">

                                <li>
                                    <p>{{ optional($ComAddr)->company_name ? $ComAddr->company_name : 'ไม่พบข้อมูล' }}</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="100">
                                        </div>
                                    </div>
                                </li>

                                <li>

                                    {{-- //สถานะทำงาน --}}
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="checkbox" id="labourWork" name="labour_work"
                                                value="{{ $labourModel->labour_work }}" class="js-switch">
                                            <label id="text-labourWork" for="labour_work"></label>
                                        </div>
                                        <div class="col-8 float-start">
                                            <input id="workDate" disabled name="labour_work_date" type="date"
                                                style="font-size: 10px; width: 70%" class="text-center form-control"
                                                value="{{ $labourModel->labour_work_date }}">
                                        </div>
                                    </div>


                                </li>
                                <li>
                                    {{-- //สถานะลาออก --}}
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="checkbox" id="resign" name="labour_resign" class="js-switch"
                                                value="{{ $labourModel->labour_resign }}" />
                                            <label id="text-resign"></label>
                                        </div>
                                        <div class="col-8">
                                            <input id="resignDate" name="labour_resign_date" type="date"
                                                style="font-size: 10px; width: 70%" class="text-center form-control"
                                                value="{{ $labourModel->labour_resign_date }}">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    {{-- //สถานะหลบหนี --}}
                                    <div class="row">
                                        <div class="col-4">
                                            <input id="escape" type="checkbox" name="labour_escape"
                                                value="{{ $labourModel->labour_escape }}" class="js-switch" />
                                            <label id="text-escape"></label>
                                        </div>
                                        <div class="col-8">
                                            <input id="escapeDate" type="date" name="labour_escape_date"
                                                style="font-size: 10px; width: 70%" class="text-center form-control"
                                                value="{{ $labourModel->labour_escape_date }}">


                                </li>
                                <li>
                                    <p>บันทึกเพิ่มเติม</p>
                                    <textarea name="labour_note" class="form-control" cols="30" rows="10">{{ $labourModel->labour_note }}</textarea>
                                </li>
                                <li>

                                    <input type="checkbox" id="LabourStatus" value="{{ $labourModel->labour_status }}"
                                        class="js-switch" name="labour_status" /> <label id="text-LabourStatus"></label>


                                </li>
                                <li>
                                    @if (Auth::user()->type != '3')
                                        <div class="float-end"><button type="submit"
                                                class="btn btn-primary pull-right">บันทึกข้อมูล</button></div>
                                    @endif

                                </li>

                            </ul>



                        </div>

                        @php
                            $importFirst = $import->where('import_id', $labourModel->import_id)->first();
                        @endphp

                        <div class="col-md-8 col-sm-8 ">

                            <div class="profile_title">
                                <div class="col-md-12">
                                    <h2>{{ $importFirst != null ? $importFirst->import_name : 'ไม่พบกลุ่มนำเข้า' }}</h2>

                                </div>



                            </div>


                            <!-- start of user-activity-graph -->
                            <div style="width:100%; height:280px;">
                                @php

                                    $ninety = DB::table('90days')
                                        ->where('labour_id', $labourModel->labour_id)
                                        ->orderby('ninety_id', 'desc')
                                        ->limit(2)
                                        ->get();
                                    $rowsNinety = 1;
                                    $rowsNinety = $ninety->count();

                                @endphp

                                <div class="container">
                                    {{-- 90 วัน timeline --}}
                                    <div class="col-md-6">
                                        <div class="x_content">
                                            <ul class="list-unstyled timeline ">
                                                <li>
                                                    <div class="block ">
                                                        <div class="tags ">
                                                            <a href="" class="tag">
                                                                <span>รอบล่าสุด</span>
                                                            </a>
                                                        </div>
                                                        <div class="block_content">
                                                            <h2 class="title">
                                                                รายงานตัว 90 วันล่าสุด
                                                            </h2>
                                                            <div class="byline">
                                                                <span id="ninety">กำลังคำนวน</span>
                                                            </div>
                                                            <p class="excerpt">
                                                                {{ date('d-m-Y', strtotime($labourModel->labour_ninety_date_start)) . ' ถึงว้นที่ ' . date('d-m-Y', strtotime($labourModel->labour_ninety_date_end)) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>

                                                @if ($rowsNinety > 0)
                                                    @foreach ($ninety as $v)
                                                        <li>
                                                            <div class="block">
                                                                <div class="tags">
                                                                    <a href="" class="tag">
                                                                        <span>รอบที่ {{ $NUMN = $rowsNinety-- }} </span>
                                                                    </a>
                                                                </div>
                                                                <div class="block_content">
                                                                    <h2 class="title">
                                                                        รายงานตัว 90 รอบที่ {{ $NUMN }}
                                                                    </h2>
                                                                    <div class="byline">
                                                                        <span id="ninety">กำลังคำนวน</span>
                                                                    </div>
                                                                    <p class="excerpt">
                                                                        {{ date('d-m-Y', strtotime($labourModel->labour_ninety_date_start)) . ' ถึงว้นที่ ' . date('d-m-Y', strtotime($labourModel->labour_ninety_date_end)) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @elseif($rowsNinety >= 1)
                                                    <li>
                                                        <div class="block">
                                                            <div class="tags">
                                                                <a href="" class="tag">
                                                                    <span>รอบที่ 2 รอดำเนินการ</span>
                                                                </a>
                                                            </div>
                                                            <div class="block_content">
                                                                <h2 class="title">
                                                                    รอดำเนินการ
                                                                </h2>
                                                                <div class="byline">
                                                                    <span id="ninety">รอดำเนินการ</span>
                                                                </div>
                                                                <p class="excerpt">
                                                                    รอดำเนินการ
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li>
                                                        <div class="block">
                                                            <div class="tags">
                                                                <a href="" class="tag">
                                                                    <span>รอบที่ 2 รอดำเนินการ</span>
                                                                </a>
                                                            </div>
                                                            <div class="block_content">
                                                                <h2 class="title">
                                                                    รอดำเนินการ
                                                                </h2>
                                                                <div class="byline">
                                                                    <span id="ninety">รอดำเนินการ</span>
                                                                </div>
                                                                <p class="excerpt">
                                                                    รอดำเนินการ
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="block">
                                                            <div class="tags">
                                                                <a href="" class="tag">
                                                                    <span>รอบที่ 1 รอดำเนินการ</span>
                                                                </a>
                                                            </div>
                                                            <div class="block_content">
                                                                <h2 class="title">
                                                                    รอดำเนินการ
                                                                </h2>
                                                                <div class="byline">
                                                                    <span id="ninety">รอดำเนินการ</span>
                                                                </div>
                                                                <p class="excerpt">
                                                                    รอดำเนินการ
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif





                                            </ul>

                                        </div>
                                    </div>
                                    {{-- สิ้นสุด 90 วัน timeline --}}
                                    <div class="col-md-6">
                                        <div class="x_content">
                                            <ul class="list-unstyled timeline">
                                                <li>
                                                    <div class="block">
                                                        <div class="tags">
                                                            <a href="" class="tag">
                                                                <span>รอบล่าสุด</span>
                                                            </a>
                                                        </div>
                                                        <div class="block_content">
                                                            <h2 class="title">
                                                                ต่อใบอนุญาตทำงาน รอบล่าสุด
                                                            </h2>
                                                            <div class="byline">
                                                                <span id="work-permit">กำลังคำนวน</span>
                                                            </div>
                                                            <p class="excerpt">
                                                                {{ date('d-m-Y', strtotime($labourModel->labour_work_permit_date_start)) . ' ถึงว้นที่ ' . date('d-m-Y', strtotime($labourModel->labour_work_permit_date_end)) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>

                                                @if ($labourModel->labour_work_permit_date_end02)
                                                    <li>
                                                        <div class="block">
                                                            <div class="tags">
                                                                <a href="" class="tag">
                                                                    <span>รอบที่ 2 </span>
                                                                </a>
                                                            </div>
                                                            <div class="block_content">
                                                                <h2 class="title">
                                                                    ต่อใบอนุญาตทำงาน รอบที่ 2
                                                                </h2>
                                                                <div class="byline">
                                                                    <span id="work-permit">กำลังคำนวน</span>
                                                                </div>
                                                                <p class="excerpt">
                                                                    {{ date('d-m-Y', strtotime($labourModel->labour_work_permit_date_start02)) . ' ถึงว้นที่ ' . date('d-m-Y', strtotime($labourModel->labour_work_permit_date_end02)) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li>
                                                        <div class="block">
                                                            <div class="tags">
                                                                <a href="" class="tag">
                                                                    <span>รอบที่ 2 </span>
                                                                </a>
                                                            </div>
                                                            <div class="block_content">
                                                                <h2 class="title">
                                                                    รอดำเนินการ
                                                                </h2>
                                                                <div class="byline">
                                                                    <span id="work-permit">กำลังคำนวน</span>
                                                                </div>
                                                                <p class="excerpt">
                                                                    รอดำเนินการ
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if ($labourModel->labour_work_permit_date_end01)
                                                    <li>
                                                        <div class="block">
                                                            <div class="tags">
                                                                <a href="" class="tag">
                                                                    <span>รอบที่ 1 </span>
                                                                </a>
                                                            </div>
                                                            <div class="block_content">
                                                                <h2 class="title">
                                                                    ต่อใบอนุญาตทำงาน รอบที่ 1
                                                                </h2>
                                                                <div class="byline">
                                                                    <span id="work-permit">กำลังคำนวน</span>
                                                                </div>
                                                                <p class="excerpt">
                                                                    {{ date('d-m-Y', strtotime($labourModel->labour_work_permit_date_start01)) . ' ถึงว้นที่ ' . date('d-m-Y', strtotime($labourModel->labour_work_permit_date_end01)) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li>
                                                        <div class="block">
                                                            <div class="tags">
                                                                <a href="" class="tag">
                                                                    <span>รอบที่ 2 </span>
                                                                </a>
                                                            </div>
                                                            <div class="block_content">
                                                                <h2 class="title">
                                                                    รอดำเนินการ
                                                                </h2>
                                                                <div class="byline">
                                                                    <span id="work-permit">กำลังคำนวน</span>
                                                                </div>
                                                                <p class="excerpt">
                                                                    รอดำเนินการ
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>


                                </div>


                            </div>
                            <!-- end of user-activity-graph -->

                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class=""><a href="#tab_content1" id="home-tab"
                                            role="tab" data-toggle="tab" aria-expanded="flase">ข้อมูลส่วนตัว</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content2" role="tab"
                                            id="profile-tab" data-toggle="tab" aria-expanded="false">ข้อมูลนายจ้าง</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content3" role="tab"
                                            id="profile-tab2" data-toggle="tab" aria-expanded="false">หนังสือเดินทาง |
                                            กลุ่มนำเข้า</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content4" role="tab"
                                            id="visa-tab" data-toggle="tab" aria-expanded="false">วิซ่า</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content5" role="tab"
                                            id="work-tab" data-toggle="tab" aria-expanded="false">ใบอนุญาตทำงาน |
                                            รหัสพนักงาน&แผนก</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content6" role="tab"
                                            id="ninety-tab" data-toggle="tab" aria-expanded="false">รายงานตัว 90 วัน |
                                            ตม.</a>
                                    </li>

                                </ul>


                                <div id="myTabContent" class="tab-content">
                                    {{-- รายละเอียดส่วนตัว --}}
                                    <div role="tabpanel" class="tab-pane active "
                                        id="tab_content1"aria-labelledby="home-tab">

                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">ข้อมูลคนต่างด้าว<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <br />

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 text-left">รหัสแรงงาน
                                                                :</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control"
                                                                    name="labour_number"
                                                                    value="{{ $labourModel->labour_number }}" disabled
                                                                    placeholder="Default Input">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 text-left">ชื่อเอเจนซี่
                                                                :</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <select name="labour_agent" style="font-size: 16px"
                                                                    class="form-control" required>
                                                                    @php
                                                                        $agent = $agents
                                                                            ->where(
                                                                                'agent_id',
                                                                                $labourModel->labour_agent,
                                                                            )
                                                                            ->first();
                                                                    @endphp
                                                                    <option selected
                                                                        value="{{ $labourModel->labour_agent }}">
                                                                        {{ $agent->agent_company }}</option>
                                                                    <option disabled>--Select A Agent</option>
                                                                    @foreach ($agents as $v)
                                                                        <option value="{{ $v->agent_id }}">
                                                                            {{ $v->agent_company }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 text-left">สัญชาติ
                                                                :</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <select name="labour_nationality" class="form-control"
                                                                    required>

                                                                    @php
                                                                        $na = $nationality
                                                                            ->where(
                                                                                'nationality_id',
                                                                                $labourModel->labour_nationality,
                                                                            )
                                                                            ->first();
                                                                    @endphp
                                                                    <option selected
                                                                        value="{{ $labourModel->labour_nationality }}">
                                                                        {{ $na->nationality_name }}</option>
                                                                    <option disabled>--Select A Agent</option>
                                                                    @foreach ($nationality as $v)
                                                                        <option value="{{ $v->nationality_id }}"
                                                                            data-icon="fa fa-plus-square">
                                                                            {{ $v->nationality_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">เพศ : </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <select name="labour_sex" class="form-control" required>
                                                                    @if ($labourModel->labour_sex == '1')
                                                                        <option selected value="1">ชาย</option>
                                                                    @endif
                                                                    @if ($labourModel->labour_sex == '2')
                                                                        <option selected value="2">หญิง</option>
                                                                    @endif

                                                                    <option disabled>--Select A Sex</option>
                                                                    <option value="1">ชาย</option>
                                                                    <option value="2">หญิง</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 ">คำนำหน้า/ชื่อ-นามสกุล
                                                                : </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" name="labour_name"
                                                                    class="form-control" placeholder="Mr.ame-Lastname"
                                                                    value="{{ $labourModel->labour_name }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">เลขบัตร ปปช.
                                                                :</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" name="labour_textid"
                                                                    class="form-control" placeholder="000 000 000 0"
                                                                    value="{{ $labourModel->labour_textid }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">วันเกิด
                                                                :</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date" id="birth-date"
                                                                    name="labour_birth_date" class="form-control"
                                                                    value="{{ $labourModel->labour_birth_date }}"
                                                                    required>
                                                            </div>
                                                        </div>


                                                        <div class="ln_solid"></div>
                                                    </div>


                                                </div>

                                            </div>

                                            {{-- ที่อยู่แรงงาน --}}
                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">

                                                        <div class="x_title">
                                                            <h4 class="text-success">ที่อยู่แรงงาน<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <br />
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 text-left">เลขที่/หมู่/ซอย:</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $labourAddr != null ? $labourAddr->addr_number : '' }}"
                                                                    placeholder="เลขที่/หมู่/ซอย" name="addr_number">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 text-left">ตำบล/แขวง:</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <select name="addr_distict" id="addrDistict"
                                                                    class="form-control">
                                                                    @if ($labourAddr)
                                                                        <option selected
                                                                            value="{{ $labourAddr->addr_distict }}">
                                                                            {{ $labourAddr->DISTRICT_NAME }}</option>
                                                                    @else
                                                                        <option selected value="">none</option>
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 text-left">อำเภอ/เขต:</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <select name="addr_amphur" id="addrAmphur"
                                                                    class="form-control addrAmphur">

                                                                    @if ($labourAddr)
                                                                        <option selected
                                                                            value="{{ $labourAddr->addr_amphur }}">
                                                                            {{ $labourAddr->AMPHUR_NAME }}</option>
                                                                    @else
                                                                        <option selected value="">none</option>
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 text-left">จังหวัด</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <select name="addr_province" id="addrProvince"
                                                                    class="form-control addrProvince">

                                                                    @if ($labourAddr)
                                                                        <option selected
                                                                            value="{{ $labourAddr->addr_province }}">
                                                                            {{ $labourAddr->PROVINCE_NAME }}</option>
                                                                    @else
                                                                        <option selected value="">none</option>
                                                                    @endif


                                                                    @foreach ($provinces as $v)
                                                                        <option value="{{ $v->PROVINCE_ID }}">
                                                                            {{ $v->PROVINCE_NAME }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">รหัสไปรษณีย์:
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control"
                                                                    id="addrZipcode" name="addr_zipcode"
                                                                    value="{{ $labourAddr != null ? $labourAddr->addr_zipcode : 'ไม่พบข้อมูล' }}"
                                                                    readonly="readonly" placeholder="รหัสไปรษณีย์">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 ">เบอร์ติดต่อ</label>
                                                            <div class="col-md-8 col-sm-8 ">

                                                                <input type="text" class="form-control"
                                                                    name="addr_note"
                                                                    value="{{ $labourAddr != null ? $labourAddr->addr_note : '' }}">
                                                            </div>
                                                        </div>

                                                        <div class="ln_solid"></div>
                                                    </div>


                                                </div>

                                            </div>


                                        </div>
                                    </div>



                                    {{-- สิ้นสุดรายละเอียดส่วนตัว --}}


                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2"
                                        aria-labelledby="profile-tab">

                                        {{-- ข้อมูลนายจ้าง --}}
                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">ข้อมูลคนต่างด้าว<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">ข้อมูลนายจ้าง:
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <select name="labour_company" id="company"
                                                                    style="width: 308px" class="form-control">
                                                                    @if ($labourModel->labour_company)
                                                                        <option selected
                                                                            value="{{ $labourModel->labour_company }}">
                                                                            {{ $ComAddr->company_name }}</option>
                                                                    @endif


                                                                    <option disabled>---Select A Company---</option>

                                                                    @foreach ($companys as $v)
                                                                        <option value="{{ $v->company_id }}">
                                                                            {{ $v->company_name }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>

                                                        @if ($labourModel->labour_company)
                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-form-label col-md-4 col-sm-4 ">ทะเบียนบริษัทเลขที่
                                                                    :
                                                                </label>

                                                                <div class="col-md-8 col-sm-8 ">
                                                                    <input type="text" class="form-control"
                                                                        id="company_code"
                                                                        value="{{ optional($ComAddr)->company_code ? $ComAddr->company_code : null }}"
                                                                        readonly="readonly" placeholder="ซอย">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-form-label col-md-4 col-sm-4 ">อีเมล์ :
                                                                </label>
                                                                <div class="col-md-8 col-sm-8 ">
                                                                    <input type="text" class="form-control"
                                                                        id="company_email"
                                                                        value="{{ optional($ComAddr)->company_email ? $ComAddr->company_email : null }}"
                                                                        readonly="readonly" placeholder="ซอย">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-form-label col-md-4 col-sm-4 ">ชื่อนายจ้าง :
                                                                </label>
                                                                <div class="col-md-8 col-sm-8 ">
                                                                    <input type="text" class="form-control"
                                                                        id="company_surname"
                                                                        value=" {{ optional($ComAddr)->company_surname ? $ComAddr->company_surname . ' ' . $ComAddr->company_lastname : null }}"
                                                                        readonly="readonly" placeholder="ซอย">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-form-label col-md-4 col-sm-4 ">เบอร์โทรศัพท์
                                                                    :
                                                                </label>
                                                                <div class="col-md-8 col-sm-8 ">
                                                                    <input type="text" class="form-control"
                                                                        id="company_tel"
                                                                        value="{{ optional($ComAddr)->company_tel ? $ComAddr->company_tel : null }}"
                                                                        readonly="readonly" placeholder="ซอย">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-form-label col-md-4 col-sm-4 ">ประเภทกิจการ
                                                                    :
                                                                </label>
                                                                <div class="col-md-8 col-sm-8 ">
                                                                    <input type="text" class="form-control"
                                                                        id="company_business_type"
                                                                        value="{{ optional($ComAddr)->company_business_type ? $ComAddr->company_business_type : null }}"
                                                                        readonly="readonly" placeholder="ซอย">
                                                                </div>
                                                            </div>

                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">ที่อยู่นายจ้าง<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">เลขที่ / หมู่
                                                                /:
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control"
                                                                    id="company_house_number"
                                                                    value="{{ optional($ComAddr)->company_house_number ? $ComAddr->company_house_number : null }}"
                                                                    readonly="readonly" placeholder="Read-Only Input">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">ซอย : </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control"
                                                                    id="company_alley"
                                                                    value="{{ $ComAddr->company_alley != null ? $ComAddr->company_alley : 'ไม่มีข้อมูล' }}"
                                                                    readonly="readonly" placeholder="ซอย">
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">ตำบล/แขวง
                                                                :</label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control"
                                                                    id="DISTRICT_NAME"
                                                                    value="{{ $ComAddr->DISTRICT_NAME }}"
                                                                    readonly="readonly" placeholder="ซอย">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">อำเภอ/เขต :
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control"
                                                                    id="AMPHUR_NAME" value="{{ $ComAddr->AMPHUR_NAME }}"
                                                                    readonly="readonly" placeholder="ซอย">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">จังหวัด :
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control"
                                                                    id="PROVINCE_NAME"
                                                                    value="{{ $ComAddr->PROVINCE_NAME }}"
                                                                    readonly="readonly" placeholder="ซอย">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">รหัสไปรษณีย์ :
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control"
                                                                    id="company_zipcode"
                                                                    value="{{ $ComAddr->company_zipcode }}"
                                                                    readonly="readonly" placeholder="ซอย">
                                                            </div>
                                                        </div>
                                                        @endif

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        {{-- สิ้นสุดข้อมูลนายจ้าง --}}

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content3"
                                        aria-labelledby="profile-tab">
                                        {{-- หนังสือเดินทาง กลุ่มนำเข้า --}}
                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">หนังสือเดินทาง<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">หนังสือเดินทาง
                                                                :
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control passport"
                                                                    value="{{ $labourModel->labour_passport_number }}"
                                                                    placeholder="หนังสือเดินทาง"
                                                                    name="labour_passport_number">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">วันที่ออกเล่ม
                                                                :
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date" class="form-control passport"
                                                                    value="{{ $labourModel->labour_passport_date_start }}"
                                                                    placeholder="หนังสือเดินทาง"
                                                                    name="labour_passport_date_start">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">วันที่หมดอายุ
                                                                :
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date" class="form-control passport"
                                                                    value="{{ date('Y-m-d', strtotime($labourModel->labour_passport_date_end)) }}"
                                                                    placeholder="หนังสือเดินทาง"
                                                                    name="labour_passport_date_end">
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">กลุ่มนำเข้า<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">ประเภท :
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">

                                                                <select name="import_id" class="form-control">
                                                                    @if ($importFirst)
                                                                        <option selected
                                                                            value="{{ $labourModel->import_id }}">
                                                                            {{ $importFirst->import_name }}</option>
                                                                    @else
                                                                        <option selected>ไม่มีข้อมูล</option>
                                                                    @endif
                                                                    @foreach ($import as $v)
                                                                        <option value="{{ $v->import_id }}">
                                                                            {{ $v->import_name }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        {{-- สิ้นสุดหนังสือเดินทาง กลุ่มนำเข้า --}}


                                    </div>

                                    {{-- visa --}}
                                    <div role="tabpanel" class="tab-pane " id="tab_content4"aria-labelledby="visa-tab">

                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">ข้อมูลวีซ่าเริ่ม <small class="text-danger"> จำเป็นต้องระบุ รอบล่าสุดทุกครั้งเมื่อมีการต่อ</small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">เลขที่วีซ่า :
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="text" class="form-control visa"
                                                                    name="labour_visa_number"
                                                                    value="{{ $labourModel->labour_visa_number }}"
                                                                    placeholder="VISA NUMBER">
                                                            </div>

                                                        </div>

                                                     

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 ">วันเริ่มวิซ่า:(ต่อปี 1)
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date" class="form-control visa"
                                                                    name="labour_visa_date_start01"
                                                                    value="{{ $labourModel->labour_visa_date_start01 }}"
                                                                    placeholder="VISA NUMBER">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 ">วันเริ่มวิซ่า:(ต่อปี 2)
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date" class="form-control visa"
                                                                    name="labour_visa_date_start02"
                                                                    value="{{ $labourModel->labour_visa_date_start02 }}"
                                                                    placeholder="VISA NUMBER">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 ">วันเริ่มวิซ่า:(รอบต่อล่าสุด หรือ ต่อปี 3,ต่อครั้งแรก)
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date" class="form-control visa"
                                                                    name="labour_visa_date_start"
                                                                    value="{{ $labourModel->labour_visa_date_start }}"
                                                                    placeholder="VISA NUMBER">
                                                            </div>
                                                        </div>



                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">ข้อมูลวีซ่าสิ้นสุด<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 ">วันที่เดินทางเข้ามา
                                                                :
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date" class="form-control visa"
                                                                    name="labour_visa_run_date"
                                                                    value="{{ $labourModel->labour_visa_run_date }}"
                                                                    placeholder="VISA NUMBER">
                                                            </div>

                                                        </div>

                                                      

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-4 col-sm-4 ">วันหมดวีซ่า
                                                                :(ต่อปี 1)
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date" class="form-control visa"
                                                                    name="labour_visa_date_end01"
                                                                    value="{{ $labourModel->labour_visa_date_end01 }}"
                                                                    placeholder="VISA NUMBER">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 ">วันหมดวีซ่า:(ต่อปี 2)
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date" class="form-control visa"
                                                                    name="labour_visa_date_end02"
                                                                    value="{{ $labourModel->labour_visa_date_end02 }}"
                                                                    placeholder="VISA NUMBER">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-4 col-sm-4 ">วันหมดวีซ่า:(รอบล่าสุด หรือ ต่อปี 3,ต่อครั้งแรก)
                                                            </label>
                                                            <div class="col-md-8 col-sm-8 ">
                                                                <input type="date"
                                                                    class="form-control visa
                                                                    name="labour_visa_date_end"
                                                                    value="{{ date('Y-m-d', strtotime($labourModel->labour_visa_date_end)) }}"
                                                                    placeholder="VISA NUMBER">
                                                            </div>
                                                        </div>



                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{-- END visa --}}
                                    {{-- ใบอนุญาตทำงาน --}}
                                    <div role="tabpanel" class="tab-pane " id="tab_content5"aria-labelledby="work-tab">

                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">ใบอนุญาตทำงานเริ่ม<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-5 col-sm-5 ">ใบอนุญาตทำงาน:
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="text" class="form-control work"
                                                                    name="labour_work_permit_number"
                                                                    value="{{ $labourModel->labour_work_permit_number }}"
                                                                    placeholder="WORLK PERMIT NUMBER">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-5 col-sm-5 ">ใบอนุญาตเริ่มต้น:
                                                                (รอบล่าสุด)
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="date" class="form-control work"
                                                                    name="labour_work_permit_date_start"
                                                                    value="{{ $labourModel->labour_work_permit_date_start }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-5 col-sm-5 ">ใบอนุญาตเริ่มต้น:
                                                                (รอบที่ 1)
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="date" class="form-control work"
                                                                    name="labour_work_permit_date_start01"
                                                                    value="{{ $labourModel->labour_work_permit_date_start01 }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-5 col-sm-5 ">ใบอนุญาตเริ่มต้น:
                                                                (รอบที่ 2)
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="date" class="form-control work"
                                                                    name="labour_work_permit_date_start02"
                                                                    value="{{ $labourModel->labour_work_permit_date_start02 }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-5 col-sm-5 ">แผนก:
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="text" class="form-control work"
                                                                    name="labour_department"
                                                                    value="{{ $labourModel->labour_department }}"
                                                                    placeholder="labour department">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">ใบอนุญาตทำงานสิ้นสุด<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>




                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-5 col-sm-5 ">รหัสพนักงาน:
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="text" class="form-control work"
                                                                    name="labour_code"
                                                                    value="{{ $labourModel->labour_code }}"
                                                                    placeholder="labour code">
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-5 col-sm-5 ">ใบอนุญาตสิ้นสุด:
                                                                (รอบล่าสุด)
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="date" class="form-control work"
                                                                    id="work-permit-end"
                                                                    name="labour_work_permit_date_end"
                                                                    value="{{ date('Y-m-d', strtotime($labourModel->labour_work_permit_date_end)) }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-5 col-sm-5 ">ใบอนุญาตสิ้นสุด:
                                                                (รอบที่ 1)
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="date" class="form-control work"
                                                                    name="labour_work_permit_date_end01"
                                                                    value="{{ $labourModel->labour_work_permit_date_end01 }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-form-label col-md-5 col-sm-5 ">ใบอนุญาตสิ้นสุด:
                                                                (รอบที่ 2)
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="date" class="form-control work"
                                                                    name="labour_work_permit_date_end02"
                                                                    value="{{ $labourModel->labour_work_permit_date_end02 }}">
                                                            </div>
                                                        </div>




                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    {{-- สิ้นสุดใบอนุญาตทำงาน --}}

                                    {{-- 90 วัน ตม. --}}

                                    {{-- ใบอนุญาตทำงาน --}}
                                    <div role="tabpanel" class="tab-pane " id="tab_content6"aria-labelledby="ninety-tab">

                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">รายงายตัว 90 วัน<small></small></h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-5 col-sm-5 ">ราย 90
                                                                เริ่มต้น:
                                                                (รอบล่าสุด)
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="date" class="form-control 90days"
                                                                    name="labour_ninety_date_start"
                                                                    value="{{ $labourModel->labour_ninety_date_start }}">
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-5 col-sm-5 ">ราย 90
                                                                สิ้นสุด:
                                                                (รอบล่าสุด)
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="date" class="form-control 90days"
                                                                    name="labour_ninety_date_end" id="ninety-end"
                                                                    value="{{ date('Y-m-d', strtotime($labourModel->labour_ninety_date_end)) }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-5 col-sm-5 ">เลขที่ ตม.
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="text" class="form-control 90days"
                                                                    name="labour_immigration_number"
                                                                    value="{{ $labourModel->labour_immigration_number }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-5 col-sm-5  ">ตม. จังหวัด :
                                                            </label>
                                                            <div class="col-md-7 col-sm-7 ">
                                                                <input type="text" class="form-control 90days"
                                                                    name="labour_TM_province"
                                                                    value="{{ $labourModel->labour_TM_province }}">
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="x_panel">

                                                    <div class="x_content">
                                                        <div class="x_title">
                                                            <h4 class="text-tfg">ตารางต่ออายุรายงายตัว 90
                                                                วัน<small></small>
                                                            </h4>

                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="90day"
                                                            style="height: 190px; overflow-y: auto; border: 1px solid #ccc; padding: 5px;">
                                                            <table class="table table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>รอบที่</th>
                                                                        <th>วันที่</th>
                                                                        <th>ผู้ต่ออายุ</th>
                                                                        <th>หมายเหตุ</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($ninety as $v)
                                                                        <tr>
                                                                            <td>{{ 'ต่อครั้งที่ ' . $rowsNinety-- }}</td>
                                                                            <td>{{ date('d/m/Y', strtotime($v->ninety_date_start)) . ' ถึง ' . date('d/m/Y', strtotime($v->ninety_date_end)) }}
                                                                            </td>
                                                                            <td>{{ $v->ninety_user_add }}</td>
                                                                            <td>{{ $v->ninety_note }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{-- สิ้นสุด 90 วัน ตม. --}}



                                </div>


                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>

  <script>
     var Auth = @json(Auth::user()->name);
     const  adressProvinces =  "{{ route('address.provinces') }}";
     const  adressAmphures =  "{{ route('address.amphures') }}";
     const  adressDistricts =  "{{ route('address.districts') }}";
     const  adressShow =  "{{ route('address.show') }}";
  </script>

  <script src="{{URL::asset('/js/labour/form-edit.js')}}"></script>
    <!-- end of skills -->
@endsection

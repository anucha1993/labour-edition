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
                    <h2>Import <small>นำเข้าข้อมูล 90 วัน</small>&nbsp; <span><a
                                href="{{ URL::asset('master-import-file/ninetyday.xlsx') }}" class="text-success pull-right  ">
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
                <div class="x_content">
                    <br />
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ route('import.update90day.import') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="file" class="form-control" name="file-excel">
                                </div>
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">ตรวจสอบข้อมูล</button>
                                </div>
                            </form>
                        </div>

                        @if ($excelData)
                            <div class="col-md-9">
                                <form action="{{route('import.update90day.update90day')}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">ยืนยันข้อมูล</button> <span>{{"จำนวน ".count($excelData)." รายชื่อ"}}</span>
                                    <table class="table table">
                                        <thead>
                                            <tr>
                                                <th>สัญชาติ</th>
                                                <th>เลขพาส</th>
                                                <th>ชื่อ</th>
                                                <th>ข้อมูล 90 วันเดิม</th>
                                                <th>ข้อมูล 90 วัน ใหม่</th>
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
                                                @endphp
                                                @if ($labour)
                                                    <tr>
                                                        <td><input type="hidden" name="labour_id[]" value="{{$labour->labour_id}}">{{$labour->nationality_name }}</td>
                                                        <td><input type="hidden" name="labour_passport_number[]" value="{{ $item[0] }}">{{ $item[0] }}</td>
                                                        <td>{{ $labour->labour_name }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($labour->labour_ninety_date_start)) . ' - ' . date('d/m/Y', strtotime($labour->labour_ninety_date_end)) }}
                                                        </td>
                                                        <td><input type="hidden" name="labour_ninety_date_start[]" value="{{date('Y-m-d', strtotime($labour->labour_ninety_date_end))}}"> 
                                                            <input type="hidden" name="labour_ninety_date_end[]" value="{{date('Y-m-d', strtotime($item[1]))}}">
                                                            {{ date('d/m/Y', strtotime($labour->labour_ninety_date_end)) . ' - ' . date('d/m/Y', strtotime($item[1])) }}
                                                        </td>
                                                        <td><input type="hidden" name="ninety_note[]" value="{{$item[2]}}">{{$item[2]}}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td style="color: red">{{$item[0]}}</td>
                                                        <td style="color: red">ไม่พบข้อมูลในระบบ</td>
                                                        <td style="color: red">ไม่พบข้อมูลในระบบ</td>
                                                        <td style="color: red">ไม่พบข้อมูลในระบบ</td>
                                                        <td style="color: red">ไม่พบข้อมูลในระบบ</td>
                                                        <td style="color: red">ไม่พบข้อมูลในระบบ</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                              </form>

                           

                            </div>
                        @endif

                        @if($result)
                        <div class="col-md-9">
                            <h6 class="text-success">Update 90 Day Successfully ข้อมูลที่อัพเดทเมื่อสักครู่ โปรดตรวจสอบ    <a class="text-danger" href="{{route('import.update90day')}}">รีโหลด</a></h6>
                              <p>{{"จำนวน ".$result->count()." รายชื่อ"}}</p>
                            <br>
                            <table class="table table">
                                <thead>
                                    <tr>
                                        <th>สัญชาติ</th>
                                        <th>เลขพาส</th>
                                        <th>ชื่อ</th>
                                        <th>ข้อมูล 90 วัน ใหม่</th>
                                        <th>ผู้เพิ่ม</th>
                                        <th>หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($result as $v)
                                    @php
                                        $ninety = DB::table('90days')->where('labour_id',$v->labour_id)->orderby('ninety_id','desc')->first();
                                    @endphp
                                        <tr>
                                            <td>{{$v->nationality_name}}</td>
                                            <td>{{$v->labour_passport_number}}</td>
                                            <td>{{$v->labour_name}}</td>
                                            <td>{{date('d/m/Y',strtotime($v->labour_ninety_date_start)).' ถึง '.date('d/m/Y',strtotime($v->labour_ninety_date_end))}}</td>
                                            <td>{{$ninety->ninety_user_add}}</td>
                                            <td>{{$ninety->ninety_note}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif


                    </div>

                </div>
            </div>


        </div>
    </div>

    </div>
@endsection

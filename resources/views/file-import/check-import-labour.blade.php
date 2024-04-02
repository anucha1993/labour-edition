@extends('layouts.layout')
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
    <strong>{{ $message }}</strong>
</div>
@endif
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Import <small> รายชื่อการ นำเข้าข้อมูล </small></h2>
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
                    {{-- @php
                        dd($las);
                    @endphp --}}
                    <label class="text-warning">จำนวนการนำเข้า Excel ทั้งหมด : {{$countLas}} รายชื่อ</label>
                    <br>
                    <table class="table table">
                        <thead>
                            <tr>
                                <th>เลขที่พาส</th>
                                <th>สัญชาติ</th>
                                <th>ชื่อ-สกุล</th>
                                <th>บริษัท</th>
                                <th>เลขที่วีซ่า</th>
                                <th>เลขที่ใบอนุญาตทำงาน</th>
                                <th>กลุ่มนำเข้า</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($las as $v)
                                <tr>
                                    <td>{{ $v->labour_passport_number }}</td>
                                    <td>{{ $v->nationality_name}}</td>
                                    <td>{{ $v->labour_name}}</td>
                                    <td>{{ $v->company_name}}</td>
                                    <td>{{ $v->labour_visa_number }}</td>
                                    <td>{{ $v->labour_work_permit_number }}</td>
                                    <td>{{ $v->import_name }}</td>
                                    <td><a href="{{route('labour.edit',$v->labour_id)}}" class="text-info btn-sm"> <i class="fa fa-edit"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
       
    </script>
@endsection

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
                    <h2>Import <small>นำเข้าข้อมูลข้อมูลคนต่างด้าวทั้งหมด</small>&nbsp; <span><a href="{{URL::asset('master-import-file/labour.xlsx')}}" class="text-success pull-right  "> &nbsp;<i class="fa fa-file-excel-o"></i> ดาวน์โหลดฟอร์มต้นฉบับ</a></span></h2>
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
                    <form action="{{route('excelImport.import')}}" method="post" enctype="multipart/form-data">
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
                                    <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i> นำเข้าข้อมูล</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#company').select2({
              
            });
        });
    </script>
@endsection

@extends('layouts.layout')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Report <small>รายงานข้อมูลคนต่างด้าวทั้งหมด</small></h2>
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
                    <form action="{{route('reportLabour.exportLabours')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ชื่อบริษัท :</label>
                                    <select name="company_id" class="form-control" id="company">
                                        @foreach ($company as $v)
                                            <option value="{{ $v->company_id }}">{{ $v->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>กลุ่มการนำเข้า :</label>
                                    <select name="import_id" class="form-control" id="import">
                                        <option selected value="all">ทั้งหมด</option>
                                        @foreach ($import as $v)
                                            <option value="{{ $v->import_id }}">{{ $v->import_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>สถานะคนงาน :</label>
                                    <select name="status" class="form-control">
                                        <option value="all">ทั้งหมด</option>
                                        <option value="่job">ทำงาน</option>
                                        <option value="escape">หลบหนี</option>
                                        <option value="resign">ลาออก</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Actions</label>
                                    <br>
                                    <button type="submit" class="btn btn-danger">ดาวน์โหลด</button>
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
        $(document).ready(function() {
            $('#import').select2({
              
            });
        });
    </script>
@endsection

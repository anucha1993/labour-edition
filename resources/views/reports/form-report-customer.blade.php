@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Report <small>รายงานข้อมูลนายจ้าง</small></h2>
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
                    <form action="{{route('report.customer.download')}}" method="post">
                              @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label>จังหวัด</label>
                                <select name="province" id="province" class="form-control">
                                    <option value="all">ทั้งหมด</option>
                                    @foreach ($provinces as $v)
                                        <option value="{{ $v->PROVINCE_ID }}">{{ $v->PROVINCE_NAME }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>บริษัท</label>
                                <select name="customer" id="customer" class="form-control">
                                    <option value="all">ทั้งหมด</option>
                                    @foreach ($customers as $v)
                                        <option value="{{ $v->company_id }}">{{ $v->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Action</label>
                                <br>
                                <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i>
                                    รายงาน</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#province').select2();
        });
        $(document).ready(function() {
            $('#customer').select2();
        });
    </script>
@endsection

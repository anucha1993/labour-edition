@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Report <small>รายงานจำนวคนต่างด้าวเอกทั้งหมด</small></h2>
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
                    <form action="{{ route('report.total.export') }}" method="get">
                        @csrf
                        
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


@endsection

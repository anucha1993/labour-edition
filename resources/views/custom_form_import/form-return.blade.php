@extends('layouts.layout')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ $message }}</strong>
        </div>
    @endif



    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Import <small>ข้อมูลที่ update </small>&nbsp; จำนวน : {{$labour->count()}} คน <span>
                            &nbsp;</h2>
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
                    <div class="card-box table-responsive">
                        <table class="table labours table-striped jambo_table bulk_action">
                            <thead >
                                <tr class="headings" class="text-center">
                                    <th class="text-center" >สัญชาติ</th>
                                    <th class="text-center" >เลขที่พาส</th>
                                    <th class="text-center" >เลขที่วิซ่า</th>
                                    <th class="text-center" >รหัสพนักงาน</th>
                                    <th class="text-center" >ชื่อ-นามสกุล</th>
                                    <th class="text-center" >บริษัท</th>
                                    <th class="text-center" >กลุ่มการนำเข้า</th>
                                    <th class="text-center" >วันที่พาสหมดอายุ</th>
                                    <th class="text-center" >วันที่วีซ่าหมดอายุ</th>
                                    <th class="text-center" >วันที่90วันหมดอายุ</th>
                                    <th class="text-center" >Actions</th>
                                </tr>
                            </thead>
                            {{-- <style>
                                .ff{
                                    background-color: #0000002f
                                }
                            </style> --}}
                            <tbody>
                                @foreach ($labour as $v)
                                <tr @if($v->labour_status == "N" || $v->labour_escape == "Y" || $v->labour_resign == "Y" ) style=" background-color: #0000002f;"  @endif>
                                    <td class="text-center">
                                        <span  style="font-size: 15px" class="{{$v->nationality_flag}}"></span>
                                    </td>
                                    <td class="text-center"><span style="font-size: 12px" class="badge badge-success">{{$v->labour_passport_number}}</span></td>
                                    <td class="text-center"><span style="font-size: 12px" class="badge badge-secondary">{{$v->labour_visa_number}}</span></td>
                                    <td class="text-center"><span style="font-size: 12px" >{{ ($v->labour_code != NULL ? $v->labour_code : "none" )}}</span></td>
                                    <td>{{$v->labour_name}}</td>
                                    <td>{{$v->company_name}}</td>
                                    <td>{{($v->import_name == '' ? "ไม่พบข้อมูล" : $v->import_name)}}</td>
                                    <td class="text-center">
                                        @if (strtotime($v->labour_passport_date_end) < strtotime('today'))
                                         <span style="font-size: 12px" class="badge badge-danger">{{date('d/m/Y',strtotime($v->labour_passport_date_end))}} </span>
                                         <i class="fa fa-info-circle text-danger" data-toggle="tooltip" data-placement="top" title="หมดอายุ"></i>
                                     
                                        @else
                                        <span style="font-size: 12px" class="badge badge-success">{{date('d/m/Y',strtotime($v->labour_passport_date_end))}}  </span>
                                        <i class="fa fa-info-circle text-success" data-toggle="tooltip" data-placement="top" title="ปกติ"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (strtotime($v->labour_visa_date_end) < strtotime('today'))
                                        <span style="font-size: 12px" class="badge badge-danger">{{date('d/m/Y',strtotime($v->labour_visa_date_end))}}</span>
                                        <i class="fa fa-info-circle text-danger" data-toggle="tooltip" data-placement="top" title="หมดอายุ"></i>
                                     
                                        @else
                                        <span style="font-size: 12px" class="badge badge-success">{{date('d/m/Y',strtotime($v->labour_visa_date_end))}}</span>
                                        <i class="fa fa-info-circle text-success" data-toggle="tooltip" data-placement="top" title="ปกติ"></i>
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        @if (strtotime($v->labour_ninety_date_end) < strtotime('today'))
                                      <span style="font-size: 12px" class="badge badge-danger">  {{date('d/m/Y',strtotime($v->labour_ninety_date_end))}} </span>
                                      <i class="fa fa-info-circle text-danger" data-toggle="tooltip" data-placement="top" title="หมดอายุ"></i>
                                     
                                        @else
                                        <span style="font-size: 12px" class="badge badge-success">  {{date('d/m/Y',strtotime($v->labour_ninety_date_end))}} </span>
                                        <i class="fa fa-info-circle text-success" data-toggle="tooltip" data-placement="top" title="ปกติ"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                        @if (Auth::user()->type != '3')
                                        <a href="{{route('labour.edit',$v->labour_id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        @endif

                                        @if (Auth::user()->type == '3')
                                        <a href="{{route('labour.edit',$v->labour_id)}}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                        @endif
                                       
                                    </td>
                                </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    

                </div>
            </div>
        </div>
    </div>
@endsection

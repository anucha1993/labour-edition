@extends('layouts.layout')

@section('content')
    <div class="row" style="display: inline-block;">
        <div class="tile_count">
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> แรงงานทั้งหมด</span>

                <div class="count green">{{ number_format($countLabourTotal) }}</div>
                <span class="count_bottom"><i class="green"> </i> ทุกสัญชาติ/คน</span>
            </div>

            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-clock-o"></i> พาสหมดอายุ</span>
                <div class="count ">{{ number_format($ExpirePassport->total()) }}</div>
                <span class="count_bottom"> แจ้งก่อนหมด 15 วัน </span>
            </div>
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-clock-o"></i> วิซ่าหมดอายุ</span>
                <div class="count">{{ number_format($ExpireVisa->total()) }}</div>
                <span class="count_bottom"> แจ้งก่อนหมด 15 วัน </span>
            </div>
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-clock-o"></i> ใบอนุญาตทำงานหมดอายุ</span>
                <div class="count">{{ number_format($ExpireWork->total()) }}</div>
                <span class="count_bottom"> แจ้งก่อนหมด 15 วัน</span>
            </div>
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-clock-o"></i> 90 วันหมดอายุ</span>
                <div class="count">{{ number_format($Expire90day->total()) }}</div>
                <span class="count_bottom"> แจ้งก่อนหมด 15 วัน</span>
            </div>

            <div class="col-md-2 col-sm-4  tile_stats_count">
               <span class="count_top"><i class="fa fa-clock-o"></i> แรงงานปิดระบบ</span>
               <div class="count red">{{ number_format($countLabourStatusActivateTotal) }}</div>
               <span class="count_bottom"> สถานะปิดระบบเท่านั้น</span>
           </div>
        </div>





        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-bars"></i> ข้อมูลหมดอายุ
                        <small>แจ้งก่อนหมด 15 วัน</small>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Settings 1</a>
                                <a class="dropdown-item" href="#">Settings 2</a>
                            </div>
                        </li>
                        <li>
                            <a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"aria-controls="home" aria-selected="true">พาสหมดอายุ <i class="red fa fa-bell-o"> ({{ number_format($ExpirePassport->total()) }}) </i> </i></a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">วิซ่าหมดอายุ  <i class="red fa fa-bell-o"> ({{ number_format($ExpireVisa->total()) }}) </i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                aria-controls="contact" aria-selected="false">ใบอนุญาตทำงานหมดอายุ  <i class="red fa fa-bell-o"> ({{ number_format($ExpireWork->total()) }}) </i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="day90-tab" data-toggle="tab" href="#day90" role="tab"
                                aria-controls="contact" aria-selected="false">90 วันหมดอายุ  <i class="red fa fa-bell-o"> ({{ number_format($Expire90day->total()) }})</i></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                              {{-- Passport --}}
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                              <a href="{{route('report.exportExpire','passport')}}" class="btn btn-success float-right"> <i class="fa fa-file-excel-o"> ดาวน์โหลด</i></a>
                            <table class="table labours table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings" class="text-center">
                                        <th class="text-center">สัญชาติ</th>
                                        <th class="text-center">เลขที่พาส</th>
                                        <th class="text-center">เลขที่วิซ่า</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">บริษัท</th>
                                        <th class="text-center">กลุ่มการนำเข้า</th>
                                        <th class="text-center">วันที่พาสหมดอายุ</th>
                                        <th class="text-center">วันที่วีซ่าหมดอายุ</th>
                                        <th class="text-center">วันที่90วันหมดอายุ</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                {{-- <style>
                                                 .ff{
                                                     background-color: #0000002f
                                                 }
                                             </style> --}}
                                <tbody>
                                    @foreach ($ExpirePassport as $v)
                                        <tr @if ($v->labour_status == 'N' || $v->labour_escape == 'Y' || $v->labour_resign == 'Y') style=" background-color: #0000002f;" @endif>
                                            <td class="text-center">
                                                <span style="font-size: 15px" class="{{ $v->nationality_flag }}"></span>
                                            </td>
                                            <td class="text-center"><span style="font-size: 12px"
                                                    class="badge badge-success">{{ $v->labour_passport_number }}</span>
                                            </td>
                                            <td class="text-center"><span style="font-size: 12px"
                                                    class="badge badge-secondary">{{ $v->labour_visa_number }}</span></td>
                                            <td class="text-center"><span
                                                    style="font-size: 12px">{{ $v->labour_code != null ? $v->labour_code : 'none' }}</span>
                                            </td>
                                            <td>{{ $v->labour_name }}</td>
                                            <td>{{ $v->company_name }}</td>
                                            <td>{{ $v->import_name == '' ? 'ไม่พบข้อมูล' : $v->import_name }}</td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_passport_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px"
                                                        class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                                    </span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px"
                                                        class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                                    </span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_visa_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px"
                                                        class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px"
                                                        class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_ninety_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px" class="badge badge-danger">
                                                        {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px" class="badge badge-success">
                                                        {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- <a href="" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                                @if (Auth::user()->type != '3')
                                                    <a href="{{ route('labour.edit', $v->labour_id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                @endif

                                                @if (Auth::user()->type == '3')
                                                    <a href="{{ route('labour.edit', $v->labour_id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $ExpirePassport->withQueryString()->links('pagination::bootstrap-5') !!}
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                              <a href="{{route('report.exportExpire','visa')}}" class="btn btn-success float-right"> <i class="fa fa-file-excel-o"> ดาวน์โหลด</i></a>
                            <table class="table labours table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings" class="text-center">
                                        <th class="text-center">สัญชาติ</th>
                                        <th class="text-center">เลขที่พาส</th>
                                        <th class="text-center">เลขที่วิซ่า</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">บริษัท</th>
                                        <th class="text-center">กลุ่มการนำเข้า</th>
                                        <th class="text-center">วันที่พาสหมดอายุ</th>
                                        <th class="text-center">วันที่วีซ่าหมดอายุ</th>
                                        <th class="text-center">วันที่90วันหมดอายุ</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                {{-- <style>
                                                              .ff{
                                                                  background-color: #0000002f
                                                              }
                                                          </style> --}}
                                <tbody>
                                    @foreach ($ExpireVisa as $v)
                                        <tr @if ($v->labour_status == 'N' || $v->labour_escape == 'Y' || $v->labour_resign == 'Y') style=" background-color: #0000002f;" @endif>
                                            <td class="text-center">
                                                <span style="font-size: 15px" class="{{ $v->nationality_flag }}"></span>
                                            </td>
                                            <td class="text-center"><span style="font-size: 12px"
                                                    class="badge badge-success">{{ $v->labour_passport_number }}</span>
                                            </td>
                                            <td class="text-center"><span style="font-size: 12px"
                                                    class="badge badge-secondary">{{ $v->labour_visa_number }}</span></td>
                                            <td class="text-center"><span
                                                    style="font-size: 12px">{{ $v->labour_code != null ? $v->labour_code : 'none' }}</span>
                                            </td>
                                            <td>{{ $v->labour_name }}</td>
                                            <td>{{ $v->company_name }}</td>
                                            <td>{{ $v->import_name == '' ? 'ไม่พบข้อมูล' : $v->import_name }}</td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_passport_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px"
                                                        class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                                    </span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px"
                                                        class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                                    </span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_visa_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px"
                                                        class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px"
                                                        class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_ninety_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px" class="badge badge-danger">
                                                        {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px" class="badge badge-success">
                                                        {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- <a href="" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                                @if (Auth::user()->type != '3')
                                                    <a href="{{ route('labour.edit', $v->labour_id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                @endif

                                                @if (Auth::user()->type == '3')
                                                    <a href="{{ route('labour.edit', $v->labour_id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $ExpireVisa->withQueryString()->links('pagination::bootstrap-5') !!}
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                              <a href="{{route('report.exportExpire','work')}}" class="btn btn-success float-right"> <i class="fa fa-file-excel-o"> ดาวน์โหลด</i></a>
                            <table class="table labours table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings" class="text-center">
                                        <th class="text-center">สัญชาติ</th>
                                        <th class="text-center">เลขที่พาส</th>
                                        <th class="text-center">เลขที่วิซ่า</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">บริษัท</th>
                                        <th class="text-center">กลุ่มการนำเข้า</th>
                                        <th class="text-center">วันที่พาสหมดอายุ</th>
                                        <th class="text-center">วันที่วีซ่าหมดอายุ</th>
                                        <th class="text-center">วันที่90วันหมดอายุ</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                {{-- <style>
                                                              .ff{
                                                                  background-color: #0000002f
                                                              }
                                                          </style> --}}
                                <tbody>
                                    @foreach ($ExpireWork as $v)
                                        <tr @if ($v->labour_status == 'N' || $v->labour_escape == 'Y' || $v->labour_resign == 'Y') style=" background-color: #0000002f;" @endif>
                                            <td class="text-center">
                                                <span style="font-size: 15px" class="{{ $v->nationality_flag }}"></span>
                                            </td>
                                            <td class="text-center"><span style="font-size: 12px"
                                                    class="badge badge-success">{{ $v->labour_passport_number }}</span>
                                            </td>
                                            <td class="text-center"><span style="font-size: 12px"
                                                    class="badge badge-secondary">{{ $v->labour_visa_number }}</span></td>
                                            <td class="text-center"><span
                                                    style="font-size: 12px">{{ $v->labour_code != null ? $v->labour_code : 'none' }}</span>
                                            </td>
                                            <td>{{ $v->labour_name }}</td>
                                            <td>{{ $v->company_name }}</td>
                                            <td>{{ $v->import_name == '' ? 'ไม่พบข้อมูล' : $v->import_name }}</td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_passport_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px"
                                                        class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                                    </span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px"
                                                        class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                                    </span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_visa_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px"
                                                        class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px"
                                                        class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_ninety_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px" class="badge badge-danger">
                                                        {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px" class="badge badge-success">
                                                        {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- <a href="" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                                @if (Auth::user()->type != '3')
                                                    <a href="{{ route('labour.edit', $v->labour_id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                @endif

                                                @if (Auth::user()->type == '3')
                                                    <a href="{{ route('labour.edit', $v->labour_id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $ExpireWork->withQueryString()->links('pagination::bootstrap-5') !!}
                        </div>

                        <div class="tab-pane fade" id="day90" role="tabpanel" aria-labelledby="day90-tab">
                              <a href="{{route('report.exportExpire','ninety')}}" class="btn btn-success float-right"> <i class="fa fa-file-excel-o"> ดาวน์โหลด</i></a>
                            <table class="table labours table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings" class="text-center">
                                        <th class="text-center">สัญชาติ</th>
                                        <th class="text-center">เลขที่พาส</th>
                                        <th class="text-center">เลขที่วิซ่า</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">บริษัท</th>
                                        <th class="text-center">กลุ่มการนำเข้า</th>
                                        <th class="text-center">วันที่พาสหมดอายุ</th>
                                        <th class="text-center">วันที่วีซ่าหมดอายุ</th>
                                        <th class="text-center">วันที่90วันหมดอายุ</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                {{-- <style>
                                                              .ff{
                                                                  background-color: #0000002f
                                                              }
                                                          </style> --}}
                                <tbody>
                                    @foreach ($Expire90day as $v)
                                        <tr @if ($v->labour_status == 'N' || $v->labour_escape == 'Y' || $v->labour_resign == 'Y') style=" background-color: #0000002f;" @endif>
                                            <td class="text-center">
                                                <span style="font-size: 15px" class="{{ $v->nationality_flag }}"></span>
                                            </td>
                                            <td class="text-center"><span style="font-size: 12px"
                                                    class="badge badge-success">{{ $v->labour_passport_number }}</span>
                                            </td>
                                            <td class="text-center"><span style="font-size: 12px"
                                                    class="badge badge-secondary">{{ $v->labour_visa_number }}</span></td>
                                            <td class="text-center"><span
                                                    style="font-size: 12px">{{ $v->labour_code != null ? $v->labour_code : 'none' }}</span>
                                            </td>
                                            <td>{{ $v->labour_name }}</td>
                                            <td>{{ $v->company_name }}</td>
                                            <td>{{ $v->import_name == '' ? 'ไม่พบข้อมูล' : $v->import_name }}</td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_passport_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px"
                                                        class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                                    </span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px"
                                                        class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                                    </span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_visa_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px"
                                                        class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px"
                                                        class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                @if (strtotime($v->labour_ninety_date_end) < strtotime('today'))
                                                    <span style="font-size: 12px" class="badge badge-danger">
                                                        {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                                    <i class="fa fa-info-circle text-danger" data-toggle="tooltip"
                                                        data-placement="top" title="หมดอายุ"></i>
                                                @else
                                                    <span style="font-size: 12px" class="badge badge-success">
                                                        {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                                    <i class="fa fa-info-circle text-success" data-toggle="tooltip"
                                                        data-placement="top" title="ปกติ"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- <a href="" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                                @if (Auth::user()->type != '3')
                                                    <a href="{{ route('labour.edit', $v->labour_id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                @endif

                                                @if (Auth::user()->type == '3')
                                                    <a href="{{ route('labour.edit', $v->labour_id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $Expire90day->withQueryString()->links('pagination::bootstrap-5') !!}
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

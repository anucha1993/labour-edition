@extends('layouts.layout')

@section('content')
    <div class="tile_count">
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> แรงงานทั้งหมด</span>

            <div class="count green">{{ number_format($countLabourTotal) }}</div>
            <span class="count_bottom"><i class="green"> </i> ทุกสัญชาติ/คน</span>
        </div>

        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> พาสหมดอายุ</span>
            <div class="count ">{{ number_format($TotalExpirePassport) }}</div>
            <span class="count_bottom"> แจ้งก่อนหมด 60 วัน (ไม่รวมนายจ้างดำเนินการเอง) </span>
        </div>
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> วิซ่าหมดอายุ</span>
            <div class="count">{{ number_format($TotalExpireVisa) }}</div>
            <span class="count_bottom"> แจ้งก่อนหมด 30 วัน  (ไม่รวมนายจ้างดำเนินการเอง)</span>
        </div>
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> ใบอนุญาตทำงานหมดอายุ</span>
            <div class="count">{{ number_format($TotalExpireWork) }}</div>
            <span class="count_bottom"> แจ้งก่อนหมด 30 วัน (ไม่รวมนายจ้างดำเนินการเอง)</span>
        </div>
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> 90 วันหมดอายุ</span>
            <div class="count">{{ number_format($TotalExpire90day) }}</div>
            <span class="count_bottom"> แจ้งก่อนหมด 15 วัน (ไม่รวมนายจ้างดำเนินการเอง)</span>
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
                    <small>แจ้งก่อนหมดพาสหมด 60 วัน | แจ้งก่อนหมดวีซ่าหมด 30 วัน | แจ้งก่อนหมดใบอนุญาตหมด 30 วัน |
                        แจ้งก่อนหมด 90 วันหมด 15 วัน</small>
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
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                            role="tab"aria-controls="home" aria-selected="true">พาสหมดอายุ <i class="red fa fa-bell-o">
                                ({{ number_format($TotalExpirePassport) }}) </i> </i></a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">วิซ่าหมดอายุ <i class="red fa fa-bell-o">
                                ({{ number_format($TotalExpireVisa) }}) </i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                            aria-controls="contact" aria-selected="false">ใบอนุญาตทำงานหมดอายุ <i class="red fa fa-bell-o">
                                ({{ number_format($TotalExpireWork) }}) </i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="day90-tab" data-toggle="tab" href="#day90" role="tab"
                            aria-controls="contact" aria-selected="false">90 วันหมดอายุ <i class="red fa fa-bell-o">
                                ({{ number_format($TotalExpire90day) }})</i></a>
                    </li>
                </ul>
                <form action="{{ route('/') }}" method="GET">
                    <div class="input-group mb-3 pull-right">
                        <input type="text" class="form-control" placeholder="ค้นหาข้อมูลบริษัท..." name="search"
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                        </div>
                    </div>
                </form>
                <div class="tab-content" id="myTabContent">
                    {{-- Passport --}}
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <a href="{{ route('report.exportExpire', ['expireType' => 'passport', 'company' => 'NULL']) }}" class="btn btn-success float-right"> <i
                                class="fa fa-file-excel-o"> ดาวน์โหลด</i></a>
                        <table class="table labours table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings" class="text-center">

                                    <th class="text-center">บริษัท</th>
                                    <th class="text-center">จำนวนหมดอายุ</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($ExpirePassport as $item)
                                    <tr>
                                        <td class="">{{ $item->company_name }}</td>
                                        <td class="text-center" style="font-size: 18px"><span
                                                class="badge badge-pill badge-danger">{{ $item->labour_count }} คน</span>
                                        </td>
                                        <td class="text-center"><a
                                                href="{{ route('dashboard.Modalshow.passport', $item->company_id) }}"
                                                class="btn-show-report-company">ดูข้อมูล</a></td>
                                    </tr>
                                @empty
                                    ไม่พบข้อมูล
                                @endforelse
                            </tbody>
                        </table>
                        {!! $ExpirePassport->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <a href="{{ route('report.exportExpire', ['expireType' => 'visa', 'company' => 'NULL']) }}" class="btn btn-success float-right"> <i
                                class="fa fa-file-excel-o"> ดาวน์โหลด</i></a>
                        <table class="table labours table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings" class="text-center">

                                    <th class="text-center">บริษัท</th>
                                    <th class="text-center">จำนวนหมดอายุ</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($ExpireVisa as $item)
                                    <tr>
                                        <td class="">{{ $item->company_name }}</td>
                                        <td class="text-center" style="font-size: 18px"><span
                                                class="badge badge-pill badge-danger">{{ $item->labour_count }} คน</span>
                                        </td>
                                        <td class="text-center"><a
                                                href="{{ route('dashboard.Modalshow.visa', $item->company_id) }}"
                                                class="btn-show-report-company">ดูข้อมูล</a></td>
                                    </tr>
                                @empty
                                    ไม่พบข้อมูล
                                @endforelse
                            </tbody>
                        </table>
                        {!! $ExpireVisa->withQueryString()->links('pagination::bootstrap-5') !!}

                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <a href="{{ route('report.exportExpire',['expireType' => 'work', 'company' => 'NULL']) }}" class="btn btn-success float-right"> <i
                                class="fa fa-file-excel-o"> ดาวน์โหลด</i></a>
                        <table class="table labours table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings" class="text-center">

                                    <th class="text-center">บริษัท</th>
                                    <th class="text-center">จำนวนหมดอายุ</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($ExpireWork as $item)
                                    <tr>
                                        <td class="">{{ $item->company_name }}</td>
                                        <td class="text-center" style="font-size: 18px"><span
                                                class="badge badge-pill badge-danger">{{ $item->labour_count }} คน</span>
                                        </td>
                                        <td class="text-center"><a
                                                href="{{ route('dashboard.Modalshow.work', $item->company_id) }}"
                                                class="btn-show-report-company">ดูข้อมูล</a></td>
                                    </tr>
                                @empty
                                    ไม่พบข้อมูล
                                @endforelse
                            </tbody>
                        </table>
                        {!! $ExpireWork->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>

                    <div class="tab-pane fade" id="day90" role="tabpanel" aria-labelledby="day90-tab">
                        <a href="{{ route('report.exportExpire', ['expireType' => 'ninety', 'company' => 'NULL']) }}" class="btn btn-success float-right"> <i
                                class="fa fa-file-excel-o"> ดาวน์โหลด</i></a>
                        <table class="table labours table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings" class="text-center">

                                    <th class="text-center">บริษัท</th>
                                    <th class="text-center">จำนวนหมดอายุ</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($Expire90day as $item)
                                    <tr>
                                        <td class="">{{ $item->company_name }}</td>
                                        <td class="text-center" style="font-size: 18px"><span
                                                class="badge badge-pill badge-danger">{{ $item->labour_count }} คน</span>
                                        </td>
                                        <td class="text-center"><a
                                                href="{{ route('dashboard.Modalshow.ninety', $item->company_id) }}"
                                                class="btn-show-report-company">ดูข้อมูล</a></td>
                                    </tr>
                                @empty
                                    ไม่พบข้อมูล
                                @endforelse
                            </tbody>
                        </table>
                        {!! $Expire90day->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- modal เพิ่ม User --}}
    <div class="modal fade bd-example-modal-xl" tabindex="-1" id="showCompany" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 80vw;">
            <div class="modal-content">
                ...
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" tabindex="-1" id="showCompanyVisa" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 80vw;">
            <div class="modal-content">
                ...
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            // modal add user
            $(".btn-show-report-company").click("click", function(e) {
                e.preventDefault();
                $("#showCompany")
                    .modal("show")
                    .find(".modal-content")
                    .load($(this).attr("href"));
            });

        });

        $(document).ready(function () {
            $(document).ready(function () {
        // โหลดค่าของลิงก์ที่ถูกเลือกไว้จาก sessionStorage เมื่อหน้าโหลด
        var selectedTabLink = sessionStorage.getItem('selectedTabLink');
        if (selectedTabLink) {
            $('#myTab a[href="' + selectedTabLink + '"]').tab('show');
        }
        
        // บันทึกลิงก์ที่ถูกเลือก
        $('#myTab a').on('click', function (e) {
            sessionStorage.setItem('selectedTabLink', $(this).attr('href'));
        });
    });

    });
    
    </script>
@endsection

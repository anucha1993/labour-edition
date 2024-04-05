<style>
body {
  --table-width: 100%; /* Or any value, this will change dinamically */
}
tbody {
  display:block;
  max-height:500px;
  overflow-y:auto;
}
thead, tbody tr {
  display:table;
  width: var(--table-width);
  table-layout:fixed;
}
</style>

<div class="modal-content">
    <div class="modal-header d-flex align-items-center">
        <h5>รายละเอียดแยกประเภทบริษัท : <b>{{ $company->company_name }}</b> <span class="text-danger">( {{$labours->count()}} )</span></h5>
        <a href="{{ route('report.exportExpire', ['expireType' => 'ninety', 'company' => $company->company_id]) }}" class="btn btn-success float-right"> <i
            class="fa fa-file-excel-o"> ดาวน์โหลด</i></a>
    </div>
    <br>
    <div class="table-responsive-sm">

        <table class="table labours table-fixed  table-striped  ">
            <thead>
                <tr class="headings" class="text-center">
                    <th class="text-center">สัญชาติ</th>
                    <th class="text-center">เลขที่พาส</th>
                    <th class="text-center">เลขที่วิซ่า</th>
                    <th class="text-center">รหัสพนักงาน</th>
                    <th class="text-center">ชื่อ-นามสกุล</th>
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
                @foreach ($labours as $v)
                    <tr @if ($v->labour_status == 'N' || $v->labour_escape == 'Y' || $v->labour_resign == 'Y') style=" background-color: #0000002f;" @endif>
                        <td class="text-center">
                            <span style="font-size: 15px" class="{{ $v->nationality_flag }}"></span>
                        </td>
                        <td class="text-center"><span style="font-size: 12px"
                                class="badge badge-success">{{ $v->labour_passport_number }}</span></td>
                        <td class="text-center"><span style="font-size: 12px"
                                class="badge badge-secondary">{{ $v->labour_visa_number }}</span></td>
                        <td class="text-center"><span
                                style="font-size: 12px">{{ $v->labour_code != null ? $v->labour_code : 'none' }}</span>
                        </td>
                        <td>{{ $v->labour_name }}</td>
                        {{-- <td>{{$v->company_name}}</td> --}}
                        <td>{{ $v->import_name == '' ? 'ไม่พบข้อมูล' : $v->import_name }}</td>
                        <td class="text-center">
                            @if (strtotime($v->labour_passport_date_end) < strtotime('today'))
                                <span style="font-size: 12px"
                                    class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                </span>
                                <i class="fa fa-info-circle text-danger" data-toggle="tooltip" data-placement="top"
                                    title="หมดอายุ"></i>
                            @else
                                <span style="font-size: 12px"
                                    class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_passport_date_end)) }}
                                </span>
                                <i class="fa fa-info-circle text-success" data-toggle="tooltip" data-placement="top"
                                    title="ปกติ"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if (strtotime($v->labour_visa_date_end) < strtotime('today'))
                                <span style="font-size: 12px"
                                    class="badge badge-danger">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                <i class="fa fa-info-circle text-danger" data-toggle="tooltip" data-placement="top"
                                    title="หมดอายุ"></i>
                            @else
                                <span style="font-size: 12px"
                                    class="badge badge-success">{{ date('d/m/Y', strtotime($v->labour_visa_date_end)) }}</span>
                                <i class="fa fa-info-circle text-success" data-toggle="tooltip" data-placement="top"
                                    title="ปกติ"></i>
                            @endif

                        </td>
                        <td class="text-center">
                            @if (strtotime($v->labour_ninety_date_end) < strtotime('today'))
                                <span style="font-size: 12px" class="badge badge-danger">
                                    {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                <i class="fa fa-info-circle text-danger" data-toggle="tooltip" data-placement="top"
                                    title="หมดอายุ"></i>
                            @else
                                <span style="font-size: 12px" class="badge badge-success">
                                    {{ date('d/m/Y', strtotime($v->labour_ninety_date_end)) }} </span>
                                <i class="fa fa-info-circle text-success" data-toggle="tooltip" data-placement="top"
                                    title="ปกติ"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- <a href="" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                            @if (Auth::user()->type != '3')
                                <a href="{{ route('labour.edit', $v->labour_id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-edit"></i></a>
                            @endif

                            @if (Auth::user()->type == '3')
                                <a href="{{ route('labour.edit', $v->labour_id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-eye"></i></a>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- {!! $labours->withQueryString()->links('pagination::bootstrap-5') !!} --}}

</div>

<script></script>

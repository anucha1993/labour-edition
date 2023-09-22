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
                    <h2>ข้อมูลคนต่างด้าว <small>ทั้งหมด</small> </h2>
                    <a href="{{route('labour.create')}}" class="btn btn-primary pull-right">เพิ่มคนงาน</a>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                               
                                <form action="{{ route('labour.index') }}" method="GET">
                                    <div class="input-group mb-3 pull-right">
                                        <input type="text" class="form-control" placeholder="ค้นหาข้อมูล..." name="search" value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                                        </div>
                                    </div>
                                </form>

                                    <table class="table labours table-striped jambo_table bulk_action">
                                    <thead >
                                        <tr class="headings">
                                            <th>เลขที่พาส</th>
                                            <th>เลขที่วิซ่า</th>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>บริษัท</th>
                                            <th>วันที่พาสหมดอายุ</th>
                                            <th>วันที่วีซ่าหมดอายุ</th>
                                            <th>วันที่90วันหมดอายุ</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($labours as $v)
                                        <tr>
                                            <td>{{$v->labour_passport_number}}</td>
                                            <td>{{$v->labour_visa_number}}</td>
                                            <td>{{$v->labour_name}}</td>
                                            <td>{{$v->company_name}}</td>
                                            <td>
                                                @if (strtotime($v->labour_passport_date_end) < strtotime('today'))
                                                {{date('d/m/Y',strtotime($v->labour_passport_date_end))}} <span class="badge badge-danger">หมดอายุแล้ว</span>
                                             
                                                @else
                                                {{date('d/m/Y',strtotime($v->labour_passport_date_end))}}
                                                @endif
                                            </td>
                                            <td>
                                                @if (strtotime($v->labour_visa_date_end) < strtotime('today'))
                                                {{date('d/m/Y',strtotime($v->labour_visa_date_end))}} <span class="badge badge-danger">หมดอายุแล้ว</span>
                                             
                                                @else
                                                {{date('d/m/Y',strtotime($v->labour_visa_date_end))}}
                                                @endif

                                            </td>
                                            <td>
                                                @if (strtotime($v->labour_ninety_date_end) < strtotime('today'))
                                                {{date('d/m/Y',strtotime($v->labour_ninety_date_end))}} <span class="badge badge-danger">หมดอายุแล้ว</span>
                                             
                                                @else
                                                {{date('d/m/Y',strtotime($v->labour_ninety_date_end))}}
                                                @endif
                                            </td>
                                            <td>
                                                {{-- <a href="" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                                @if (Auth::user()->type != '3')
                                                <a href="{{route('labour.edit',$v->labour_id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                @endif
                                               
                                            </td>
                                        </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                                {!! $labours->withQueryString()->links('pagination::bootstrap-5') !!}
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>

    //  $(function (){
    //     var table =  $(".labours").DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{route('labour.index')}}",
    //     columns: [
    //         {data: 'labour_passport_number',name: 'labour_passport_number'},
    //         {data: 'labour_name',name: 'labour_name'},
    //         {data: 'company_name',name: 'company_name'},
    //         {data: 'labour_immigration_number',name: 'labour_immigration_number'},
    //     ]
    //     });
    //     });

</script>


@endsection

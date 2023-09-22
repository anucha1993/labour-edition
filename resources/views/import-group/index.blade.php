@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">

                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible bg-success text-white border-0 fade show" role="alert">

                    <strong>{{ $message }}</strong>
                </div>
            @endif 
            

            <div class="x_panel">
                <div class="x_title">
                    <h2>Import Group <small>กลุ่มนำเข้าแรงงานต่างด้าว </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <a href="{{ route('importgroup.modalAdd') }}"
                class="btn btn-primary btn-sm pull-right import-group">เพิ่ม</a>
            <br />
                <div class="x_content">
                   
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr>
                                        <th>ลบ</th>
                                        <th>ID</th>
                                        <th>ชื่อกลุ่ม</th>
                                        <th>ผู้เพิ่ม</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($import as $v)
                                        <tr>
                                            <td><a href="" class="text-danger"><i class="fa fa-trash"></i></a></td>
                                            <td>{{$v->import_id}}</td>
                                            <td>{{$v->import_name}}</td>
                                            <td>{{$v->import_user_add}}</td>
                                            <td><a href="" class="text-info"><i class="fa fa-edit"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $import->withQueryString()->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true"
        id="modal-add-import-group">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.import-group').click(function(e) {
                e.preventDefault();
                var modal = $('#modal-add-import-group');
                modal.modal('show');
                modal.addClass(" modal-lg")
                modal.addClass("container")
                modal.find('.modal-content').load($(this).attr('href'));
            });
        });
    </script>
@endsection

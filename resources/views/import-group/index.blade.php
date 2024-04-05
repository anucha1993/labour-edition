@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-6 ">

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
                @if (Auth::user()->type != 3) 
                <a href="{{ route('importgroup.modalAdd') }}"
                class="btn btn-primary btn-sm pull-right import-group">เพิ่ม</a>
                @endif
            <br />
                <div class="x_content">
                   
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped jambo_table bulk_action import">
                                <thead>
                                    <tr>
                                        <th>ลบ</th>
                                        <th>ID</th>
                                        <th>ชื่อกลุ่ม</th>
                                        <th>สถานะ</th>
                                        @if (Auth::user()->type != 3) 
                                        <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                              
                            </table>
                           
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

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true"
        id="modal-edit-import-group">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('.import').DataTable({
                processing: true,
                serverSide:true,
                ajax: "{{route('importgroup.index')}}",
                columns: [
                    {data: 'delete',name: 'delete'},
                    {data: 'import_id',name: 'import_id'},
                    {data: 'import_name',name: 'import_name'},
                    {data: 'status',name: 'status'},
                    @if (Auth::user()->type != 3) 
                    {data: 'action',name: 'action'},
                    @endif
                ]
              
            });
        });

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

@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>LogFile <small>Labour</small></h2>
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

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">

                                <form action="{{ route('logfile.labour') }}" method="GET">
                                    <div class="input-group mb-3 pull-right">
                                        <input type="text" class="form-control" placeholder="ค้นหาข้อมูล..."
                                            name="search" value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                                        </div>
                                    </div>
                                </form>

                                <table class="table labours table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr>
                                            <th>created_at</th>
                                            <th>updated_at</th>
                                            <th>log_name</th>
                                            <th>description</th>
                                            <th>subject_type</th>
                                            <th>event</th>
                                            <th>subject_id</th>
                                            <th>causer_type</th>
                                            <th>causer_id</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($labourLog as $v)
                                            <tr>
                                                <td>{{ date('d-m-Y H:i:s', strtotime($v->created_at)) }}</td>
                                                <td>{{ date('d-m-Y H:i:s', strtotime($v->updated_at)) }}</td>
                                                <td>{{ $v->log_name }}</td>
                                                <td>{{ $v->description }}</td>
                                                <td>{{ $v->subject_type }}</td>
                                                <td>{{ $v->event }}</td>
                                                <td>{{ $v->subject_id }}</td>
                                                <td>{{ $v->causer_type }}</td>
                                                <td>{{ $v->causer_id }}</td>

                                                <td> <a type="button" class="text-info" data-toggle="modal"
                                                        data-target=".bs-example-modal-lg">ดูข้อมูล</a>


                                                    <div class="modal fade bs-example-modal-lg" tabindex="-1"
                                                        role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">

                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel">Logfile</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal"><span
                                                                            aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h4>ตรวจสอบ Log</h4>
                                                                    <pre>
                                                                           @php
                                                                               $jsonString = $v->properties;
                                                                               $decodedString = json_decode($jsonString);
                                                                               echo json_encode($decodedString, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                                                                           @endphp
                                                                       </pre>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

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
        </div>
    </div>
@endsection

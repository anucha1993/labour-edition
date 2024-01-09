@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Report <small>รายงานข้อมูลคนต่างด้าวสำหรับ(CPF)เท่านั้น</small></h2>
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
                    <form action="{{ route('report.exportCPF01') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ชื่อบริษัท : (ข้อมูลจะแสดงเฉพาะบริษัท ซีพีเอฟเท่านั้น)</label>
                                    <select name="company_id" class="form-control" id="company">
                                        <option selected value="all">ทั้งหมด</option>
                                        @foreach ($company as $v)
                                            <option value="{{ $v->company_id }}">{{ $v->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>กลุ่มการนำเข้า :</label>
                                    <select name="import_id" class="form-control" id="import">
                                        <option selected value="all">ทั้งหมด</option>
                                        @foreach ($import as $v)
                                            <option value="{{ $v->import_id }}">{{ $v->import_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>สถานะคนงาน :</label>
                                    <select name="status" class="form-control">
                                        <option value="all">ทั้งหมด</option>
                                        <option value="่job">ทำงาน</option>
                                        <option value="escape">หลบหนี</option>
                                        <option value="resign">ลาออก</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">เลือกแบบฟอร์ม</label>
                                    <select name="form_type" id="form_type" class="form-control">
                                        <option value="1">ฟอร์มหลัก</option>
                                        <option value="2">ฟอร์มย่อย</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Actions</label>
                                    <br>
                                    <button type="submit" class="btn btn-danger">ดาวน์โหลด</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <input type="checkbox" name="ninety_day_check" id="ninety_day_check"
                                    value="Y">&nbsp;<label> วันหมดอายุ 90 วัน</label>
                            </div>

                            <div class="col-md-3" id="div-ninety-start" style="display: none">
                                <div class="form-group">
                                    <label>เริ่มต้น</label>
                                    <input type="date" name="ninety_day_start" id="ninety_day_start"
                                        class="form-control"  >
                                </div>
                            </div>

                            <div class="col-md-3" id="div-ninety-end" style="display: none">
                                <div class="form-group">
                                    <label>สิ้นสุด</label>
                                    <input type="date" name="ninety_day_end" id="ninety_day_end" class="form-control" >
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3">
                                <input type="checkbox" name="visa" id="visa" value="Y">&nbsp;<label> วันหมดอายุ
                                    วิซ่า</label>
                            </div>

                            <div class="col-md-3" id="div-visa-start" style="display: none">
                                <div class="form-group">
                                    <label>เริ่มต้น</label>
                                    <input type="date" name="visa_start" id="visa-start" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3" id="div-visa-end" style="display: none">
                                <div class="form-group">
                                    <label>สิ้นสุด</label>
                                    <input type="date" name="visa_end" id="visa-end" class="form-control">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3">
                                <input type="checkbox" name="work" id="work" value="Y">&nbsp;<label>
                                    วันหมดอายุ ใบอนุญาตทำงาน</label>
                            </div>

                            <div class="col-md-3" id="div-work-start" style="display: none">
                                <div class="form-group">
                                    <label>เริ่มต้น</label>
                                    <input type="date" name="work_start" id="work-start" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3" id="div-work-end" style="display: none">
                                <div class="form-group">
                                    <label>สิ้นสุด</label>
                                    <input type="date" name="work_end" id="work-end" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <input type="checkbox" name="passport" id="passport" value="Y">&nbsp;<label>
                                    วันหมดอายุ หนังสือเดินทาง</label>
                            </div>

                            <div class="col-md-3" id="div-passport-start" style="display: none">
                                <div class="form-group">
                                    <label>เริ่มต้น</label>
                                    <input type="date" name="passport_start" id="passport-start"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3" id="div-passport-end" style="display: none">
                                <div class="form-group">
                                    <label>สิ้นสุด</label>
                                    <input type="date" name="passport_end" id="passport_-nd" class="form-control">
                                </div>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#ninety_day_check').change(function() {
                if ($(this).is(':checked')) {
                    // If the checkbox is checked
                    $('#div-ninety-start').show();
                    $('#div-ninety-end').show();
                    $('#ninety_day_start').prop('required',true); // Disable the input with ID 'ninety_day_start'
                    $('#ninety_day_end').prop('required',true); // Disable the input with ID 'ninety_day_end'
                } else {
                    // If the checkbox is unchecked
                    $('#div-ninety-start').hide();
                    $('#div-ninety-end').hide();
                    $('#ninety_day_start').prop('required',false); // Enable the input with ID 'ninety_day_start'
                    $('#ninety_day_end').prop('required', false); // Enable the input with ID 'ninety_day_end'
                }
            });

        });
        $(document).ready(function() {
            $('#visa').change(function() {
                if ($(this).is(':checked')) {
                    // ถ้า checkbox ถูกเลือก (checked)
                    $('#div-visa-start').show();
                    $('#div-visa-end').show();
                    $('#visa-start').prop('required',true);
                    $('#visa-end').prop('required',true);
                } else {
                    // ถ้า checkbox ไม่ถูกเลือก (unchecked)
                    $('#div-visa-start').hide();
                    $('#div-visa-end').hide();
                    $('#visa-start').prop('required',false);
                    $('#visa-end').prop('required',false);
                }
            });
        });

        $(document).ready(function() {
            $('#work').change(function() {
                if ($(this).is(':checked')) {
                    // ถ้า checkbox ถูกเลือก (checked)
                    $('#div-work-start').show();
                    $('#div-work-end').show();
                    $('#work-start').prop('required',true);
                    $('#work-end').prop('required',true);

                } else {
                    // ถ้า checkbox ไม่ถูกเลือก (unchecked)
                    $('#div-work-start').hide();
                    $('#div-work-end').hide();
                    $('#work-start').prop('required',false);
                    $('#work-end').prop('required',false);
                }
            });
        });

        $(document).ready(function() {
            $('#passport').change(function() {
                if ($(this).is(':checked')) {
                    // ถ้า checkbox ถูกเลือก (checked)
                    $('#div-passport-start').show();
                    $('#div-passport-end').show();
                    $('#passport-start').prop('required',true);
                    $('#passport-end').prop('required',true);
                } else {
                    // ถ้า checkbox ไม่ถูกเลือก (unchecked)
                    $('#div-passport-start').hide();
                    $('#div-passport-end').hide();
                    $('#passport-start').prop('required',false);
                    $('#passport-end').prop('required',false);
                }
            });
        });


        $(document).ready(function() {
            $('#company').select2({

            });
        });
        $(document).ready(function() {
            $('#import').select2({

            });
        });
    </script>
@endsection

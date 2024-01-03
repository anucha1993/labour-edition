@extends('layouts.layout')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($success)
    <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
        <strong>{{ $success }}</strong>
    </div>
    @endif



    <style>
        .fileLabel {
            width: 750px;
            height: 300px;
            border: 2px dashed #ccc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            position: relative;
        }

        .fileLabel:hover {
            background-color: #f9f9f9;
        }

        .fileLabel span {
            font-size: 16px;
            color: #888;
        }

        input[type="file"] {
            display: none;
        }
        @media screen and (max-width: 768px) {
    .fileLabel {
        width: 100%; /* ปรับความกว้างให้เต็มขอบจอเมื่อหน้าจอเล็กลง */
        /* ปรับการจัดวางหรือขนาดตามความเหมาะสม */
        /* เพิ่ม CSS properties ต่าง ๆ เพื่อให้มีการจัดวางที่ดีตามเงื่อนไขการใช้งาน */
    }

    .fileLabel span {
        font-size: 14px; /* ปรับขนาดตัวอักษรให้เหมาะสมกับหน้าจอขนาดเล็ก */
        /* เพิ่ม CSS properties อื่น ๆ ตามที่ต้องการ */
    }
}
    </style>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Import <small>นำเข้าข้อมูล แผนก & รหัสพนักงาน</small>&nbsp; <span><a
                                href="{{ URL::asset('master-import-file/dp.xlsx') }}" class="text-success pull-right  ">
                                &nbsp;<i class="fa fa-file-excel-o"></i> ดาวน์โหลดฟอร์มต้นฉบับ</a></span></h2>
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

                <div class="col-6">
                    <div class="x_content">
                        <br>
                        <form action="{{ route('import.department.employee.id') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fileInput" class="fileLabel">
                                            <span id="fileName">ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเลือก</span>
                                            <img id="fileIcon" src="" alt="ไอคอนไฟล์" style="display: none;"
                                                width="100px">
                                            <input id="fileInput" type="file" class="form-control" name="file"
                                                onchange="showFileInfo(this); validateFileType(this);">
                                        </label>


                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success ">อ่านข้อมูล</button>

                                    </div>

                                </div>

                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    @if ($excelData)
                        <div class="x_content">
                            <div class="row">
                                <form action="{{route('import.department.employee.update')}}" method="post">
                                    @csrf
                                    @method('post')
                                    <table class="table table">
                                        <thead>
                                            <tr>
                                                <th>เลขพาส</th>
                                                <th>สัญชาติ</th>
                                                <th >ชื่อพนักงาน</th>
                                                <th>รหัสพนักงาน</th>
                                                <th>แผนก</th>
                                            </tr>
                                        </thead>
                                        <button type="submit" class="btn btn-primary float-end">ยืนยันข้อมูล</button>
                                        <tbody>
                                            @foreach ($excelData as $item)
                                                @php
                                                       $labour = DB::table('labour')
                                                        ->leftJoin('nationality', 'nationality.nationality_id', '=', 'labour.labour_nationality')
                                                        ->where('labour_passport_number', $item[0])
                                                        ->first();
                                                @endphp

                                                @if ($labour != null)
                                                    <tr>
                                                        <td><input type="hidden" name="labour_passport_number[]" value="{{ $item[0] }}">{{ $item[0] }}</td>
                                                        <td>{{ $labour->nationality_name }}</td>
                                                        <td>{{ $labour->labour_name }}</td>
                                                        <td><input type="hidden" name="labour_code[]" value="{{ $item[1] }}">{{ $item[1] }}</td>
                                                        <td><input type="hidden" name="labour_department[]" value="{{ $item[2] }}">{{ $item[2] }}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>{{ $item[0] }}</td>
                                                        <td>ไม่พบข้อมูลในระบบ</td>
                                                        <td>ไม่พบข้อมูลในระบบ</td>
                                                        <td>ไม่พบข้อมูลในระบบ</td>
                                                        <td>ไม่พบข้อมูลในระบบ</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    @else
                    @endif
                </div>



            </div>
        </div>
    </div>



    <script>
        function showFileInfo(input) {
            const file = input.files[0];
            const fileNameElement = document.getElementById('fileName');
            const fileIconElement = document.getElementById('fileIcon');

            if (file) {
                fileNameElement.textContent = file.name;

                // Check if the file type is Excel
                if (file.type === 'application/vnd.ms-excel' || file.name.endsWith('.xls') || file.name.endsWith('.xlsx')) {
                    fileIconElement.src =
                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDm5d92EuzhC9912m0XnzCzaIuAfQsbt1kjxH-wHYBaMPN2lTphug9zcHdNFbN7gVftAw&usqp=CAU'; // Replace with the path to your Excel icon
                    fileIconElement.style.display = 'inline-block';
                } else {
                    fileIconElement.style.display = 'none';
                }
            }
        }

        function validateFileType(input) {
            const file = input.files[0];
            const fileNameElement = document.getElementById('fileName');
            const fileIconElement = document.getElementById('fileIcon');

            if (file) {
                const fileType = file.type;

                // Check if the file type is Excel
                if (
                    fileType === 'application/vnd.ms-excel' ||
                    fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ) {
                    fileNameElement.textContent = file.name;
                    fileIconElement.style.display = 'inline-block';
                } else {
                    fileNameElement.textContent = 'ไฟล์ที่เลือกไม่ใช่ไฟล์ Excel';
                    fileIconElement.style.display = 'none';
                    input.value = ''; // Clear the input value to prevent uploading non-Excel files
                    alert('กรุณาเลือกไฟล์ Excel เท่านั้น');
                }
            }
        }
    </script>
@endsection

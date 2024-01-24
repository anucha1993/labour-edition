@extends('layouts.layout')
@section('content')
    {{-- // Select Notify --}}
    @if ($message = Session::get('success'))
        <script>
            var message = @json($message);
            Swal.fire({
                icon: "success",
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @if ($message = Session::get('error'))
        <script>
            var message = @json($message);
            Swal.fire({
                icon: "error",
                title: message,
                allowOutsideClick: false, // คำสั่งนี้จะไม่ให้ค้าง Swal ด้วยการคลิกภายนอก
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
                onClose: () => {
                    Swal.close();
                }
            });
        </script>
    @endif
    {{-- // End Select Notify --}}


    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">

                    <h2>Customer All <small>ข้อมูลนายจ้าง</small></h2>
                    <a href="{{ route('customer.create') }}" class="btn btn-primary pull-right">เพิ่มนายจ้าง</a>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="card-box table-responsive">

                        <form action="{{ route('customer.index') }}" method="GET">
                            <div class="input-group mb-3 pull-right">
                                <input type="text" class="form-control" placeholder="ค้นหาข้อมูล..." name="search"
                                    value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                                </div>
                            </div>
                        </form>
                        <table class="table table  table-striped jambo_table bulk_action " id="customer"
                            style="font-size: 16px">

                            <thead>
                                <tr>
                                    <th class="text-center">รหัสบริษัท</th>
                                    <th>ชื่อบริษัท</th>
                                    <th>ชื่อนายจ้าง</th>
                                    <th>ประเภทธุระกิจ</th>
                                    <th class="text-center">เบอร์โทรศัพท์</th>
                                    <th>สถานะ</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($customers as $v)
                                    <tr>
                                        <td class="text-center"><span
                                                class="badge badge-dark">{{ $v->company_number }}</span></td>
                                        <td>{{ $v->company_name }}</td>
                                        <td>{{ $v->company_surname . ' ' . $v->company_lastname }}</td>
                                        <td>{{ $v->company_business_type != null ? $v->company_business_type : 'ไม่พบข้อมูล' }}
                                        </td>
                                        <td class="text-center"><span
                                                class="badge badge-success">{{ $v->company_tel }}</span></td>
                                            <td>
                                                @if ($v->company_status == "Close")
                                                    <span class="badge badge-success">เปิดใช้งาน</span>
                                                @endif
                                                @if ($v->company_status == "Ready")
                                                <span class="badge badge-warning">ปิดใช้งานชั่วคราว</span>
                                                 @endif
                                                 @if ($v->company_status == "Notcontact")
                                                 <span class="badge badge-danger">ปิดใช้งานถาวร</span>
                                                  @endif
                                            </td>
                                        <td>
                                            <a href="{{ route('customer.show', $v->company_id) }}" class="text-primary"><i
                                                    class="fa fa-eye"></i></a>&nbsp;&nbsp;
                                            <a href="{{ route('customer.edit', $v->company_id) }}" class="text-success"><i
                                                    class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                    @if (Auth::user()->type == 1)
                                                    <a href="#" id="companyDelete"
                                                    onclick="companyDelete('{{ $v->company_id }}'); return false;"
                                                    class="text-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
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


    </div>

    <script>
        function companyDelete(customerId) {
            Swal.fire({
                title: "คุณแน่ใจหรือไม่ว่า?",
                text: "ต้องการลบข้อมูล นายจ้าง",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "ยกเลิก",
                confirmButtonText: "ใช่, ต้องการลบข้อมูล"
            }).then((result) => {
                if (result.isConfirmed) {
                    // ทำ HTTP request เพื่อลบข้อมูลทาง server ที่นี่
                    // เช่น ใช้ fetch หรือ axios
                    fetch("{{ url('customer/form/delete/') }}/" + customerId, {
                            method: "get",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                        })

                        .then(response => response.json())
                        .then(data => {
                            // ตรวจสอบว่าการลบสำเร็จหรือไม่
                            if (data.success) {


                                Swal.fire({
                                    title: "Deleted!",
                                    text: "ลบข้อมูลสำเร็จ!",
                                    icon: "success",
                                 
                                });

                                setTimeout(() => {
                                    window.location.reload();
                                }, 1300);

                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "เกิดข้อผิดพลาดสำหรับการลบข้อมูล โปรดติดต่อเจ้าหน้าที่!",
                                    icon: "error"
                                });
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire({
                                title: "Error!",
                                text: "เกิดข้อผิดพลาดสำหรับการลบข้อมูล โปรดติดต่อเจ้าหน้าที่!",
                                icon: "error"
                            });
                        });
                }
            });
        }
    </script>
@endsection

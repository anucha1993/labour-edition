
<form action="{{route('importgroup.update',$importGroupModel->import_id)}}" method="post">
    @csrf
    @method('put')
<div class="modal-header">
    <h5>แก้ไขกลุ่มนำเข้าคนต่างด้าว</h5>
</div>
<div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label>ชื่อกลุ่มนำเข้า :</label>
                <input type="text" class="form-control" name="import_name" placeholder="ชื่อกลุ่มนำเข้า" value="{{$importGroupModel->import_name}}">
            </div>
            <div class="col-md-12 mb-3">
                <label>สถานะ :</label>
                <select name="import_status" class="form-control">

                    @if ($importGroupModel->import_status === 'Y')
                    <option selected value="Y">แสดง</option>
                    <option value="N">ไม่แสดง</option>
                    @else
                    <option value="Y">แสดง</option>
                    <option selected value="N">ไม่แสดง</option>
                    @endif
                  
                </select>
            </div>
        </div>
        <input type="hidden" name="import_user_edit" value="{{Auth::user()->name}}">
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success">บันทึก</button>
</div>
</form>
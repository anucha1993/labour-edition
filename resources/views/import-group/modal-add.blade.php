
<form action="{{route('importgroup.modalStore')}}" method="post">
    @csrf
<div class="modal-header">
    <h5>เพิ่มกลุ่มนำเข้าคนต่างด้าว</h5>
</div>
<div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <label>ชื่อกลุ่มนำเข้า :</label>
                <input type="text" class="form-control" name="import_name" placeholder="ชื่อกลุ่มนำเข้า">
            </div>
        </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success">บันทึก</button>
</div>
</form>
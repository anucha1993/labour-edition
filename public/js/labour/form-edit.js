//ตรวจสอบ การกรอก passports
$(document).ready(function() {
    $('.textid').on('change', function() {
        // เอาเฉพาะตัวเลขออกเหลือเฉพาะตัวเลขเท่านั้น
        var inputValue = $(this).val().replace(/\D/g, '');
        // จำนวนตัวเลขทั้งหมดที่ป้อน
        var digitCount = inputValue.length;
        // ถ้าจำนวนตัวเลขไม่เท่ากับ 13 ให้แสดง alert
        if (digitCount !== 13) {
            $('.textid').val('');
            $('.btn-submit').prop('disabled', true);
            alert('กรุณาใส่ตัวเลข ปปช. ให้มีจำนวน 13 ตัว');
            
            
        } else {
            $('.btn-submit').prop('disabled', false);

            // นำเลขมาแบ่งสามตัวเป็นกลุ่ม
            inputValue = inputValue.replace(/(\d{3})(\d{3})(\d{3})(\d{1})/, "$1 $2 $3 $4");
            // ใส่ค่ากลับเข้าไปใน input
            $(this).val(inputValue);
        }

    });
});

//ตรวจสอบ การกรอก Visa
$(document).ready(function() {
    $('.work-id').on('change', function() {
        // เอาเฉพาะตัวเลขออกเหลือเฉพาะตัวเลขเท่านั้น
        var inputValue = $(this).val().replace(/\D/g, '');
        // จำนวนตัวเลขทั้งหมดที่ป้อน
        var digitCount = inputValue.length;
        // ถ้าจำนวนตัวเลขไม่เท่ากับ 13 ให้แสดง alert
        if (digitCount !== 13) {
            $('.work-id').val('');
            $('.btn-submit').prop('disabled', true);
            alert('กรุณาใส่ตัวเลข ใบอนุญาตทำงาน ให้มีจำนวน 13 ตัว');
            
        } else {
            $('.btn-submit').prop('disabled', false);
            // นำเลขมาแบ่งสามตัวเป็นกลุ่ม
            inputValue = inputValue.replace(/(\d{3})(\d{3})(\d{3})(\d{1})/, "$1 $2 $3 $4");
            // ใส่ค่ากลับเข้าไปใน input
            $(this).val(inputValue);
        }

    });
});




$(document).ready(function () {
    $("#addrProvince").select2();
});
$(document).ready(function () {
    $("#addrAmphur").select2();
});

$(document).ready(function () {
    $("#addrDistict").select2();
});
//  ส่งข้อมูลจังหวัด
$(document).ready(function () {
    $("#addrProvince").change(function () {
        var select = $(this).val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: adressProvinces,
            method: "GET",
            data: {
                select: select,
                _token: _token,
            },
            success: function (result) {
                $("#addrAmphur").html(result);
            },
        });
    });
});
//ส่งข้อมูลอำเภอ
$(document).ready(function () {
    $("#addrAmphur").change(function () {
        var select = $(this).val();
        var _token = $('input[name="token"]').val();
        $.ajax({
            url: adressAmphures,
            method: "GET",
            data: {
                select: select,
                _token: _token,
            },
            success: function (result) {
                $("#addrDistict").html(result);
            },
        });
    });
});
//ส่งข้อมูลตำบล
$(document).ready(function () {
    $("#addrDistict").change(function () {
        var select = $(this).val();
        var _token = $('input[name="token"]').val();

        $.ajax({
            url: adressDistricts,
            method: "GET",
            data: {
                select: select,
                token: _token,
            },
            success: function (result) {
                $("#addrZipcode").val(result);
            },
        });
    });
});

// ที่อยู่นายจ้าง
$(document).ready(function () {
    $("#company").select2();
});
$(document).ready(function () {
    $("#company").change(function () {
        var select = $(this).val();
        var _token = $('input[name="token"]').val();

        $.ajax({
            url: adressShow,
            method: "GET",
            data: {
                select: select,
                _token: _token,
            },
            success: function (result) {
                $("#company_code").val(result.company.company_code);
                $("#company_email").val(result.company.company_email);
                $("#company_email").val(
                    result.company.company_surname +
                        " " +
                        result.company.company_lastname
                );
                $("#company_tel").val(result.company.company_tel);
                $("#company_business_type").val(
                    result.company.company_business_type
                );
                $("#company_house_number").val(
                    result.company.company_house_number
                );
                $("#company_alley").val(result.company.company_alley);
                $("#DISTRICT_NAME").val(result.district.DISTRICT_NAME);
                $("#AMPHUR_NAME").val(result.amphur.AMPHUR_NAME);
                $("#PROVINCE_NAME").val(result.province.PROVINCE_NAME);
                $("#company_zipcode").val(result.zipcodes.zipcode);
            },
        });
    });
});

// ตรวจสอบสถานะคนงาน
$(document).ready(function () {
    var LabourStatus = document.getElementById("LabourStatus");
    LabourStatus.checked = true;
    // Assuming LabourStatus is a checkbox input
    if (LabourStatus.value === "Y") {
        LabourStatus.checked = true;
        document.getElementById("text-LabourStatus").innerHTML =
            '<span class="text-success">เปิดใช้งาน</span>';
    } else {
        LabourStatus.checked = false;
        document.getElementById("text-LabourStatus").innerHTML =
            '<span class="text-danger">ปิดใช้งาน</span>';
    }
});

$(document).on("change", "#LabourStatus", function () {
    var userName = Auth;
    // No need to access LabourStatus.value here, as it's a checkbox
    var LabourStatus = document.getElementById("LabourStatus");

    if (LabourStatus.checked) {
        // Checkbox is checked
        labourWork.checked = true;
        LabourStatus.value = "Y";
        document.getElementById("text-LabourStatus").innerHTML =
            '<span class="text-success">เปิดใช้งาน</span>';
    } else {
        // Checkbox is unchecked
        LabourStatus.value = "N";
        labourWork.checked = false;
        document.getElementById("text-LabourStatus").innerHTML =
            '<span class="text-danger">ปิดใช้งาน</span>';
        Swal.fire({
            title: "คุณแน่ใจใช่ไหม?",
            html:
                "หากต้องการปิดสถานะคนงาน ระบบจะจดจำชื่อ <br><i class='text-success'>" +
                userName +
                "</i> เป็นผู้ปิดระบบ",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            showCancelButtonColor: "#d33",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
        })
            //เมื่อกดตกลง
            .then((result) => {
                let LabourStatus = document.getElementById("LabourStatus");
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "เปลี่ยนสถานะสำเร็จ!",
                        text: "กรุณากดบันทึกเพื่อยืนยัน",
                        icon: "success",
                    });
                }
                //เมื่อกดยกเลิก
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    let LabourStatus = document.getElementById("LabourStatus");
                    LabourStatus.value = "Y";
                    LabourStatus.nextElementSibling.click();
                    Swal.fire({
                        title: "ยกเลิกสำเร็จ!",
                        text: "สถานะถูกไม่ถูกเปลี่ยนแปลง",
                        icon: "error",
                    });
                }
            });
    }
    console.log(LabourStatus.value);
});
// ตรวจสอบสถานะคนงานสิ้นสุด

// ตรวจสอบสถานะการทำงาน
$(document).on("change", "#labourWork", function () {
    var labourWork = document.getElementById("labourWork");
    var resign = document.getElementById("resign");
    if (labourWork.checked) {
        labourWork.value = "Y";
        document.getElementById("text-labourWork").innerHTML =
            '<span class="text-success">ทำงาน</span>';
        document.getElementById("workDate").disabled = false;
    } else {
        labourWork.value = "N";
        document.getElementById("text-labourWork").innerHTML =
            '<span class="text-danger">ไม่ทำงาน</span>';
        document.getElementById("workDate").disabled = true;
    }
});
$(document).ready(function () {
    var labourWork = document.getElementById("labourWork");
    // Assuming LabourStatus is a checkbox input
    if (labourWork.value === "Y") {
        labourWork.checked = true;
        document.getElementById("workDate").disabled = false;
        document.getElementById("text-labourWork").innerHTML =
            '<span class="text-success">ทำงาน</span>';
    } else {
        labourWork.checked = false;
        document.getElementById("workDate").disabled = true;
        document.getElementById("text-labourWork").innerHTML =
            '<span class="text-danger">ไม่ทำงาน</span>';
    }
});
// สิ้นสุดตรวจสอบสถานะการทำงาน

// ตรวจสอบสถานะลาออก
$(document).on("change", "#resign", function () {
    var resign = document.getElementById("resign");
    var labourWork = document.getElementById("labourWork");

    if (resign.checked) {
        resign.value = "Y";
        document.getElementById("resignDate").style.display = "block";
        document.getElementById("text-resign").innerHTML =
            '<span class="text-danger">ลาออก</span>';
    } else {
        resign.value = "N";
        document.getElementById("resignDate").style.display = "none";
        document.getElementById("text-resign").innerHTML =
            '<span class="text-success">ไม่ลาออก</span>';
    }
    //abourWork.nextElementSibling.click();
});

$(document).ready(function () {
    var resign = document.getElementById("resign");
    // Assuming resign is a checkbox input
    if (resign.value === "Y") {
        resign.checked = true;
        document.getElementById("resignDate").style.display = "block";
        document.getElementById("text-resign").innerHTML =
            '<span class="text-danger">ลาออก</span>';
    } else {
        resign.checked = false;
        document.getElementById("resignDate").style.display = "none";
        document.getElementById("text-resign").innerHTML =
            '<span class="text-success">ไม่ลาออก</span>';
    }
});
// สิ้นสุดตรวจสอบสถานะลาออก

// ตรวจสอบสถานะหลบหนี
$(document).on("change", "#escape", function () {
    var escape = document.getElementById("escape");
    if (escape.checked) {
        escape.value = "Y";
        document.getElementById("escapeDate").style.display = "block";
        document.getElementById("text-escape").innerHTML =
            '<span class="text-danger">หลบหนี</span>';
    } else {
        escape.value = "N";
        document.getElementById("escapeDate").style.display = "none";
        document.getElementById("text-escape").innerHTML =
            '<span class="text-success">ไม่หลบหนี</span>';
    }
});
$(document).ready(function () {
    var escape = document.getElementById("escape");
    // Assuming resign is a checkbox input
    if (escape.value === "Y") {
        escape.checked = true;
        document.getElementById("escapeDate").style.display = "block";
        document.getElementById("text-escape").innerHTML =
            '<span class="text-danger">หลบหนี</span>';
    } else {
        escape.checked = false;
        document.getElementById("escapeDate").style.display = "none";
        document.getElementById("text-escape").innerHTML =
            '<span class="text-success">ไม่หลบหนี</span>';
    }
});

// สิ้นสุดตรวจสอบสถานะลาออก  labourWork.nextElementSibling.click();
$(document).on("change", "#escape, #resign, #labourWork", function () {
    var escape = document.getElementById("escape");
    var resign = document.getElementById("resign");
    var labourWork = document.getElementById("labourWork");

    if (labourWork.checked) {
        if (resign.checked) {
            resign.nextElementSibling.click();
        }

        if (escape.checked) {
            escape.nextElementSibling.click();
        }
    }

    if (resign.checked) {
        if (escape.checked) {
            escape.nextElementSibling.click();
        }
    }

    if (escape.checked) {
        if (resign.checked) {
            resign.nextElementSibling.click();
        }
    }
});

// ninety
$(document).ready(function () {
    $("#ninety-end").change(function () {
        var endDate = new Date($(this).val()); // วันที่หมดอายุที่เลือก
        var currentDate = new Date(); // วันที่ปัจจุบัน
        var timeDiff = endDate - currentDate;
        console.log(endDate);

        if (timeDiff < 0) {
            $("#ninety").text("หมดอายุแล้ว");
        } else {
            var years = Math.floor(timeDiff / (365 * 24 * 60 * 60 * 1000));
            timeDiff -= years * (365 * 24 * 60 * 60 * 1000);

            var months = Math.floor(timeDiff / (30 * 24 * 60 * 60 * 1000));
            timeDiff -= months * (30 * 24 * 60 * 60 * 1000);

            var days = Math.floor(timeDiff / (24 * 60 * 60 * 1000));

            $("#ninety").text(
                years + " ปี " + months + " เดือน " + days + " วัน"
            );
        }
    });
    $("#ninety-end").trigger("change");
});

// work premit
$(document).ready(function () {
    $("#work-permit-end").change(function () {
        var endDate = new Date($(this).val()); // วันที่หมดอายุที่เลือก
        var currentDate = new Date(); // วันที่ปัจจุบัน
        var timeDiff = endDate - currentDate;

        if (timeDiff < 0) {
            $("#work-permit").text("หมดอายุแล้ว");
        } else {
            var years = Math.floor(timeDiff / (365 * 24 * 60 * 60 * 1000));
            timeDiff -= years * (365 * 24 * 60 * 60 * 1000);

            var months = Math.floor(timeDiff / (30 * 24 * 60 * 60 * 1000));
            timeDiff -= months * (30 * 24 * 60 * 60 * 1000);

            var days = Math.floor(timeDiff / (24 * 60 * 60 * 1000));

            $("#work-permit").text(
                years + " ปี " + months + " เดือน " + days + " วัน"
            );
        }
    });
    $("#work-permit-end").trigger("change");
});

$(document).ready(function () {
    $(
        "input.flat-passport,input.flat-visa,input.flat-90days,input.flat-work"
    ).iCheck({
        checkboxClass: "icheckbox_flat-green",
        radioClass: "iradio_flat-green",
    });

    // เพิ่ม event listener สำหรับ checkbox ที่มีคลาส .flat
    $(
        "input.flat-passport,input.flat-visa,input.flat-90days,input.flat-work"
    ).on("ifChanged", function (event) {
        var passport = $(".flat-passport").prop("checked");
        var visa = $(".flat-visa").prop("checked");
        var ninety = $(".flat-90days").prop("checked");
        var work = $(".flat-work").prop("checked");

        if (passport) {
            $(".passport").prop("disabled", true);
            $(".flat-passport").val("Y");
        } else {
            $(".passport").prop("disabled", false);
            $(".flat-passport").val("N");
        }
        if (visa) {
            $(".visa").prop("disabled", true);
            $(".flat-visa").val("Y");
        } else {
            $(".visa").prop("disabled", false);
            $(".flat-visa").val("N");
        }
        if (ninety) {
            $(".90days").prop("disabled", true);
            $(".flat-90days").val("Y");
        } else {
            $(".90days").prop("disabled", false);
            $(".flat-90days").val("N");
        }
        if (work) {
            $(".work").prop("disabled", true);
            $(".flat-work").val("Y");
        } else {
            $(".work").prop("disabled", false);
            $(".flat-work").val("N");
        }
    });

    $(document).ready(function () {
        var passport = $(".flat-passport").prop("checked");
        var visa = $(".flat-visa").prop("checked");
        var ninety = $(".flat-90days").prop("checked");
        var work = $(".flat-work").prop("checked");

        if (passport) {
               $(".passport").prop("disabled", true);
               $(".flat-passport").val("Y");
           } else {
               $(".passport").prop("disabled", false);
               $(".flat-passport").val("N");
           }
           if (visa) {
               $(".visa").prop("disabled", true);
               $(".flat-visa").val("Y");
           } else {
               $(".visa").prop("disabled", false);
               $(".flat-visa").val("N");
           }
           if (ninety) {
               $(".90days").prop("disabled", true);
               $(".flat-90days").val("Y");
           } else {
               $(".90days").prop("disabled", false);
               $(".flat-90days").val("N");
           }
           if (work) {
               $(".work").prop("disabled", true);
               $(".flat-work").val("Y");
           } else {
               $(".work").prop("disabled", false);
               $(".flat-work").val("N");
           }
    });
});

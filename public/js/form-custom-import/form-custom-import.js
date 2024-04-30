$(document).ready(function () {
    $(".flat-addr,.flat-district,.flat-amphur,.flat-province").iCheck({
        checkboxClass: "icheckbox_flat-green",
        radioClass: "iradio_flat-green",
    });
    $(".flat-addr,.flat-district,.flat-amphur,.flat-province").on(
        "ifChanged",
        function (event) {
            if ($(this).is(":checked")) {
                $(
                    ".flat-addr,.flat-district,.flat-amphur,.flat-province"
                ).iCheck("check");
            } else {
                $(
                    ".flat-addr,.flat-district,.flat-amphur,.flat-province"
                ).iCheck("uncheck");
            }
        }
    );
});

$(document).ready(function () {
    $(".flat-work,.flat-work-date").iCheck({
        checkboxClass: "icheckbox_flat-green",
        radioClass: "iradio_flat-green",
    });

    $(".flat-work,.flat-work-date").on("ifChanged", function (event) {
        if ($(this).prop("checked")) {
            $(".flat-work,.flat-work-date").iCheck("check");
        } else {
            $(".flat-work,.flat-work-date").iCheck("uncheck");
        }
    });
});

$(document).ready(function () {
    $(".flat-resign,.flat-resign-date").iCheck({
        checkboxClass: "icheckbox_flat-green",
        radioClass: "iradio_flat-green",
    });

    $(".flat-resign,.flat-resign-date").on("ifChanged", function (event) {
        if ($(this).prop("checked")) {
            $(".flat-resign,.flat-resign-date").iCheck("check");
        } else {
            $(".flat-resign,.flat-resign-date").iCheck("uncheck");
        }
    });
});

$(document).ready(function () {
    $(".flat-escape,.flat-escape-date").iCheck({
        checkboxClass: "icheckbox_flat-green",
        radioClass: "iradio_flat-green",
    });

    $(".flat-escape,.flat-escape-date").on("ifChanged", function (event) {
        if ($(this).prop("checked")) {
            $(".flat-escape,.flat-escape-date").iCheck("check");
        } else {
            $(".flat-escape,.flat-escape-date").iCheck("uncheck");
        }
    });
});

$(document).ready(function () {
    $(".flat-passport-manage,.flat-file-passport").iCheck({
        checkboxClass: "icheckbox_flat-green",
        radioClass: "iradio_flat-green",
    });

    $(".flat-passport-manage,.flat-file-passport").on("ifChanged", function (event) {
        if ($(this).prop("checked")) {
            $(".flat-passport-manage,.flat-file-passport").iCheck("check");
        } else {
            $(".flat-passport-manage,.flat-file-passport").iCheck("uncheck");
        }
    });
});


$(document).ready(function () {
    $(".flat-visa-manage,.flat-file-visa").iCheck({
        checkboxClass: "icheckbox_flat-green",
        radioClass: "iradio_flat-green",
    });

    $(".flat-visa-manage,.flat-file-visa").on("ifChanged", function (event) {
        if ($(this).prop("checked")) {
            $(".flat-visa-manage,.flat-file-visa").iCheck("check");
        } else {
            $(".flat-visa-manage,.flat-file-visa").iCheck("uncheck");
        }
    });
});


$(document).ready(function () {
    $(".flat-work-manage,.flat-file-work").iCheck({
        checkboxClass: "icheckbox_flat-green",
        radioClass: "iradio_flat-green",
    });

    $(".flat-work-manage,.flat-file-work").on("ifChanged", function (event) {
        if ($(this).prop("checked")) {
            $(".flat-work-manage,.flat-file-work").iCheck("check");
        } else {
            $(".flat-work-manage,.flat-file-work").iCheck("uncheck");
        }
    });
});

$(document).ready(function () {
    $(".flat-ninety-manage,.flat-file-ninety").iCheck({
        checkboxClass: "icheckbox_flat-green",
        radioClass: "iradio_flat-green",
    });

    $(".flat-ninety-manage,.flat-file-ninety").on("ifChanged", function (event) {
        if ($(this).prop("checked")) {
            $(".flat-ninety-manage,.flat-file-ninety").iCheck("check");
        } else {
            $(".flat-ninety-manage,.flat-file-ninety").iCheck("uncheck");
        }
    });
});





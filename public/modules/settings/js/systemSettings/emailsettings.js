console.log('emailsettings.js loading');
$(document).ready(function () {

    $('#btnSave').on('click', function () {
        var form = $('#frmEmailSettings').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            SaveNewsettings(data);
        }

    });
    $('#btntest').on('click', function () {
        var form = $('#frmemail').get(0);
        var data = new FormData(form);
        testEmail(data);
    });

    loadCurrentSettings();


});
function loadCurrentSettings() {
    $.ajax({
        type: 'GET',
        url: '/settings/emailsettings/loadCurrentSettings',
        async: false,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = response.result
                $('#mailDriver').val(data['mailDriver']);
                $('#host').val(data['host']);
                $('#port').val(data['port']);
                $('#userName').val(data['userName']);
                $('#password').val(data['password']);
                $('#encryption').val(data['encryption']);
                $('#mailFromAddress').val(data['mailFromAddress']);
                $('#mailFromName').val(data['mailFromName']);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function SaveNewsettings(data) {
    $.ajax({
        type: "POST",
        url: "/settings/emailsettings/SaveNewsettings",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        success: function (response) {
            loadCurrentSettings();
            console.log(response);

        },
        error: function (error) {
            console.log(error);


        },

    });
}
function testEmail(data) {
    $.ajax({
        type: "POST",
        url: "/settings/emailsettings/testEmail",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        success: function (response) {
            console.log(response);
            $('#frmemail').trigger("reset");
            $('#modelEmail').modal('toggle');
            toastr.success(response.message);
        },
        error: function (error) {
            console.log(error);

            if (error.status == 422) { // when status code is 422, it's a validation issue
                console.log(error.responseJSON);
                // you can loop through the errors object and show it to the user
                console.warn(error.responseJSON.errors);
                // display errors on each form field
                $.each(error.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    errorElement(el);
                    toastr.warning(error[0]);
                    console.clear()
                });
            }
            else {
                toastr.error('Something went wrong');
            }
        },

    });
}

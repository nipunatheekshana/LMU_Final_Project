console.log('bankAccountTypeConfigure .js loadimng');
var parent_url = '/accounting/bankAccountType_list'
$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmbankAccountTypeConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });



    loadBankAccountType();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/accounting/bankAccountTypeConfigure/save",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {
            $('#btnSave').html('waiting')

        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success(response.message);
                $('#frmbankAccountTypeConfigure ').trigger("reset");
                location.href = parent_url;

                $('#btnSave').html('Done')
            }
            else {
                toastr.error(response.message);
            }
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
                    //  el[0].style.border = '1px solid red';

                    errorElement(el);
                    toastr.warning(error[0]);
                    console.clear()
                });
            }
            else {
                toastr.error('Something went wrong');
            }
        },
        complete: function () {
            $('#btnSave').html('Save')
        }
    });
};
function update(data) {
    $.ajax({
        type: "POST",
        url: "/accounting/bankAccountTypeConfigure/update",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {
            $('#btnSave').html('waiting')

        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success(response.message);
                $('#frmbankAccountTypeConfigure ').trigger("reset");
                location.href = parent_url;

                $('#btnSave').html('Done')
            }
            else {
                toastr.error(response.message);
            }
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
                    //  el[0].style.border = '1px solid red';

                    errorElement(el);
                    toastr.warning(error[0]);
                    console.clear()
                });
            }
            else {
                toastr.error('Something went wrong');
            }
        },
        complete: function () {
            $('#btnSave').html('Update')
        }
    });
};

function loadBankAccountType() {

    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
        if (param.length == 2) {
            console.log('view ')
            $('#btnSave').hide();

        } else {
            console.log('edit ');
            $('#btnSave').text('Update');

        }

    }
    if (id) {
        $.ajax({
            type: "GET",
            url: "/accounting/bankAccountTypeConfigure/loadBankAccountType/" + id,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            async: false,
            beforeSend: function () {

            },
            success: function (response) {

                if (response.success) {

                    console.log(response.result);
                    var data = response.result;

                    $('#hiddenId').val(data.id);

                    $('#account_type_code').val(data.account_type_code);
                    $('#account_type_name').val(data.account_type_name);

                    if (data.enabled) {
                        $("#enabled").prop("checked", true);
                    }
                    else {
                        $("#enabled").prop("checked", false);
                    }

                }

            },
            error: function (error) {
                console.log(error);

            },
            complete: function () {

            }

        });
    }

}

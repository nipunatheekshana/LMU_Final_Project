console.log('editParentCompany.js loading');

$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#FrmEditMotherCompany').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            // update(data);
        }

    });

    loadMotherCompanyData();
});

function loadMotherCompanyData() {
    $.ajax({
        type: 'GET',
        url: '/editParentCompany/loadMotherCompanyData',
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                data = response.result
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#address').val(data.address);
                $('#contacts').val(data.contacts);


            }
        }, error: function (data) {
            console.log(response.message);
        }
    });
};

function save(data) {
    $.ajax({
        type: "POST",
        url: "/editParentCompany/save",
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
            if (response.data.success) {
                toastr.success(response.data.message);
                $('#FrmEditMotherCompany').trigger("reset");
                loadMotherCompanyData();
                $('#btnSave').html('Done')
            }
            else {
                toastr.error(response.data.message);
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

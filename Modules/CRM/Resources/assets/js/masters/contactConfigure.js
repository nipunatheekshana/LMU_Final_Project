console.log('contactConfigure.js loadimng');
var parent_url = '/crm/contact_list'
$(document).ready(function () {

    $('#btnNewPhone').on('click', function () {
        $('#modalPhone').modal('toggle');
    });

    $('#btnSave').on('click', function () {
        var form = $('#frmcontactConfigure').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });
    var tablePhone = $('#tableContactPhone').DataTable({
        responsive: true,
        paging: false,
        "searching": false,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thphone", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });
    var tableEmail = $('#tableContactEmail').DataTable({
        responsive: true,
        paging: false,
        "searching": false,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thEmail", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });
    loadGender();
    loadSaluation();
    loadcontact();


});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/crm/contactConfigure/save",
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
                $('#frmcontactConfigure').trigger("reset");
                parent_url = response.result;
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
        url: "/crm/contactConfigure/update",
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
                $('#frmcontactConfigure').trigger("reset");
                parent_url = response.result;
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



function loadcontact() {

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
            url: "/crm/contactConfigure/loadcontact/" + id,
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

                    $('#FirstName').val(data.FirstName);
                    $('#MiddleName').val(data.MiddleName);
                    $('#LastName').val(data.LastName);
                    $('#Salutation').val(data.Salutation);
                    $('#Designation').val(data.Designation);
                    $('#Gender').val(data.Gender);
                    $('#PrimaryAddress').val(data.PrimaryAddress);
                    $('#list_index').val(data.list_index);
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

function loadSaluation() {
    $.ajax({
        type: 'GET',
        url: '/crm/contactConfigure/loadSaluation',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.salutation + ' </option>';
                });
                $('#Salutation').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadGender() {
    $.ajax({
        type: 'GET',
        url: '/crm/contactConfigure/loadGender',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.gender + ' </option>';
                });
                $('#Gender').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

console.log('employeeConfigure .js loadimng');
var parent_url = '/hrm/employee_list'
$(document).ready(function () {

    $('#employee_name').attr('readonly', true);

    $('#btnSave').on('click', function () {
        var form = $('#frmemployeeConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });

    $('#first_name').change(function () {
        CreateEmployeeName();
    });
    $('#middle_name').change(function () {
        CreateEmployeeName();
    });
    $('#last_name').change(function () {
        CreateEmployeeName();
    });


    loadSalutaions();
    loadGenders();
    loadCompanies();
    loadDesignations();
    loadDepartments();
    loadStatus();
    loadEmployee();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/hrm/employeeConfigure/save",
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
                $('#frmemployeeConfigure ').trigger("reset");
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
        url: "/hrm/employeeConfigure/update",
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
                $('#frmemployeeConfigure ').trigger("reset");
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
function loadEmployee() {

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
            url: "/hrm/employeeConfigure/loadEmployee/" + id,
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

                    $('#salutation').val(data.salutation);
                    $('#middle_name').val(data.middle_name);
                    $('#last_name').val(data.last_name);
                    $('#first_name').val(data.first_name);
                    $('#employee_name').val(data.employee_name);
                    $('#gender').val(data.gender);
                    $('#company').val(data.company);
                    $('#department').val(data.department);
                    $('#designation').val(data.designation);
                    $('#national_id_card_number').val(data.national_id_card_number);
                    $('#date_of_birth').val(data.date_of_birth);
                    $('#status').val(data.status);

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
function loadSalutaions() {
    $.ajax({
        type: 'GET',
        url: '/hrm/employeeConfigure/loadSalutaions',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.salutation + ' </option>';
                });
                $('#salutation').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadGenders() {
    $.ajax({
        type: 'GET',
        url: '/hrm/employeeConfigure/loadGenders',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.gender + ' </option>';
                });
                $('#gender').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadCompanies() {
    $.ajax({
        type: 'GET',
        url: '/hrm/employeeConfigure/loadCompanies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.companyName + ' </option>';
                });
                $('#company').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadDesignations() {
    $.ajax({
        type: 'GET',
        url: '/hrm/employeeConfigure/loadDesignations',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.DesignationName + ' </option>';
                });
                $('#designation').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadDepartments() {
    $.ajax({
        type: 'GET',
        url: '/hrm/employeeConfigure/loadDepartments',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.depratmentName + ' </option>';
                });
                $('#department').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadStatus() {
    $.ajax({
        type: 'GET',
        url: '/hrm/employeeConfigure/loadStatus',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.status + ' </option>';
                });
                $('#status').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function CreateEmployeeName() {
    var firstName = $('#first_name').val();
    var middleName = $('#middle_name').val();
    var lastName = $('#last_name').val();
    var fullname = '';

    if (firstName != '') {
        fullname = firstName
    }
    if (middleName != '') {
        fullname = fullname + ' ' + middleName
    }
    if (lastName != '') {
        fullname = fullname + ' ' + lastName
    }

    $('#employee_name').val(fullname);

}




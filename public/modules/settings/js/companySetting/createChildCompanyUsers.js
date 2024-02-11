console.log('createChildCompanyUsers.js is loading')

$(document).ready(function () {

    var table = $('#tableMISLUsers').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3],
            "className": "text-center",
        }],
        "order": [],
        "columns": [
            { "data": "thId" },
            { "data": "thName" },
            { "data": "themail" },
            { "data": "actions" },
        ],
    });

    $('#tableMISLUsers tbody').on('click', 'tr', function () {
        var data = table.row(this).data();
        loadUser(data['thId']);
    });

    $('#btnSave').on('click', function () {
        var form = $('#frmCreateMislUsers').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });

    loadUsers();
    loadCompany();

});
function loadCompany() {
    $.ajax({
        type: 'GET',
        url: '/createChildCompanyUsers/loadCompany',
        async: false,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.name + ' </option>';
                });
                $('#company').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function save(data) {
    $.ajax({
        type: "POST",
        url: "/createChildCompanyUsers/save",
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
                $('#frmCreateMislUsers').trigger("reset");
                loadUsers();

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
function update(data) {
    $.ajax({
        type: "POST",
        url: "/createChildCompanyUsers/update",
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
                $('#frmCreateMislUsers').trigger("reset");
                loadUsers();
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
            $('#btnSave').html('Update')
        }
    });
};
function loadUsers() {
    $.ajax({
        type: 'GET',
        url: '/createChildCompanyUsers/loadUsers',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var name = response.result[i]['name'];
                    var email = response.result[i]['email'];
                    // var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thName": name,
                        "themail": email,
                        "actions": dele,
                    });
                }

                var table = $('#tableMISLUsers').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
};
function loadUser(id) {
    $.ajax({
        type: 'GET',
        url: '/createChildCompanyUsers/loadUser/' + id,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = response.result;
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#hiddnUserId').val(data.id);
                $('#company').val(data.child_company_id);
                $('#btnSave').html('Update')
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
};
function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/createChildCompanyUsers/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadUsers();
            }
        }, error: function (data) {
            console.log(data.result);
        }
    });
};

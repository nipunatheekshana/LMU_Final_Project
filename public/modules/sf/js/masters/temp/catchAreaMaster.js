console.log('catchAreaMaster.js loadimng');
$(document).ready(function () {

    $('#btnSave').on('click', function () {
        var form = $('#frmcatchAreaMaster').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });


    var table = $('#tablecatchAreaMaster').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thAreaCode", 'width': "22.5%" },
            { "data": "thAreaName", 'width': "22.5%" },
            { "data": "index", 'width': "22.5%" },
            { "data": "action", 'width': "22.5%" },
        ],
    });

    loadCatchAreas();
});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/catchAreaMaster/save",
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
                $('#frmcatchAreaMaster').trigger("reset");
                loadCatchAreas();
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
        url: "/sf/catchAreaMaster/update",
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
                $('#frmcatchAreaMaster').trigger("reset");
                loadCatchAreas();
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
function loadCatchAreas() {
    $.ajax({
        type: 'GET',
        url: '/sf/catchAreaMaster/loadCatchAreas',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var AreaCode = response.result[i]['AreaCode'];
                    var AreaName = response.result[i]['AreaName'];
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thAreaCode": AreaCode,
                        "thAreaName": AreaName,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablecatchAreaMaster').DataTable();
                table.clear();
                table.rows.add(data).draw();
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
        url: '/sf/catchAreaMaster/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadCatchAreas();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
// function view(id) {
//     $.ajax({
//         type: 'GET',
//         url: '/sf/catchAreaMaster/view/' + id,
//         success: function (response) {
//             console.log(response.result)
//             if (response.success) {
//                 var data = response.result;
//                 $('#AreaCode').val(data.AreaCode);
//                 $('#AreaName').val(data.AreaName);
//                 $('#hiddenId').val(data.id);
//                 if (data.HNG_GRADE) {
//                     $("#HNG_GRADE").prop("checked", true);
//                 }
//                 $('#btnSave').html('Update')
//             }
//         }, error: function (data) {
//             console.log('something went wrong');
//         }
//     });
// };
function edit(id) {
    $.ajax({
        type: 'GET',
        url: '/sf/catchAreaMaster/view/' + id,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = response.result;
                $('#AreaCode').val(data.AreaCode);
                $('#AreaName').val(data.AreaName);
                $('#hiddenId').val(data.id);
                $('#list_index').val(data.list_index);
                if (data.enabled) {
                    $("#enabled").prop("checked", true);
                }
                else {
                    $("#enabled").prop("checked", false);
                }
                $('#btnSave').html('Update')
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}


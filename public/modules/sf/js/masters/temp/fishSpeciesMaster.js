console.log('fishSpeciesMaster.js loadimng');
$(document).ready(function () {

    $('#btnSave').on('click', function () {
        var form = $('#frmfishSpeciesMaster').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });


    var table = $('#tablefishSpeciesMaster').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thFishCode", 'width': "22.5%" },
            { "data": "thFishName", 'width': "22.5%" },
            { "data": "thShortName", 'width': "22.5%" },
            { "data": "action", 'width': "22.5%" },
        ],
    });
    loadUOM();
    loadFishSpecies();
});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/fishSpeciesMaster/save",
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
                $('#frmfishSpeciesMaster').trigger("reset");
                loadFishSpecies();
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
        url: "/sf/fishSpeciesMaster/update",
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
                $('#frmfishSpeciesMaster').trigger("reset");
                loadFishSpecies();
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
function loadFishSpecies() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishSpeciesMaster/loadFishSpecies',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var FishCode = response.result[i]['FishCode'];
                    var FishName = response.result[i]['FishName'];
                    var ShortName = response.result[i]['ShortName'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thFishCode": FishCode,
                        "thFishName": FishName,
                        "thShortName": ShortName,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablefishSpeciesMaster').DataTable();
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
        url: '/sf/fishSpeciesMaster/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadFishSpecies();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
// function view(id) {
//     $.ajax({
//         type: 'GET',
//         url: '/sf/fishSpeciesMaster/view/' + id,
//         success: function (response) {
//             console.log(response.result)
//             if (response.success) {
//                 var data = response.result;
//                 $('#FishCode').val(data.FishCode);
//                 $('#FishName').val(data.FishName);
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
        url: '/sf/fishSpeciesMaster/view/' + id,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = response.result;
                $('#FishCode').val(data.FishCode);
                $('#FishName').val(data.FishName);
                $('#ScName').val(data.ScName);
                $('#default_weight_unit').val(data.default_weight_unit);
                $('#average_weight').val(data.average_weight);

                $('#ShortName').val(data.ShortName);
                if (data.BulkMode) {
                    $("#BulkMode").prop("checked", true);
                }
                $('#QRiskLevel').val(data.QRiskLevel);
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

function loadUOM() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishSpeciesMaster/loadUOM',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.UomName + ' </option>';
                });
                $('#default_weight_unit').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}


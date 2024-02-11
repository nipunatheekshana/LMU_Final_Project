console.log('dataTypeFormat.js loadimng');
var Child_url = '/settings/dataTypeFormat_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Data Type Format')
    $('#btnCreateNew').on('click', function () {
        location.href = "/settings/dataTypeFormat_configure";
    });

    var table = $('#tabledataTypeFormat').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thdataType", 'width': "26.6%" },
            { "data": "thFormat", 'width': "26.6%" },
            { "data": "action", 'width': "26.6%" },
        ],
    });

    loadDataTypeFormats();
});

function loadDataTypeFormats() {
    $.ajax({
        type: 'GET',
        url: '/settings/dataTypeFormat/loadDataTypeFormats',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var data_type = response.result[i]['data_type'];
                    var format = response.result[i]['format'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thdataType": data_type,
                        "thFormat": format,
                        "action": edit + dele,
                    });
                }

                var table = $('#tabledataTypeFormat').DataTable();
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
        url: '/settings/dataTypeFormat/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadDataTypeFormats();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


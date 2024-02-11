console.log('process.js loadimng');
var Child_url = '/settings/Process_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Process')
    $('#btnCreateNew').on('click', function () {
        location.href = "/settings/Process_configure";
    });

    var table = $('#tableprocess').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thprocess", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    loadprocesses();
});

function loadprocesses() {
    $.ajax({
        type: 'GET',
        url: '/settings/process/loadprocesses',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var ProcessName = response.result[i]['ProcessName'];
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thprocess": ProcessName,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableprocess').DataTable();
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
        url: '/settings/process/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadprocesses();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


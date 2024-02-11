console.log('QGrn.js loadimng');
var Child_url = '/buying/QGrn_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New QGrn')
    $('#btnCreateNew').on('click', function () {
        location.href = "/buying/QGrn_configure";
    });

    var table = $('#tableQGrn').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thQGrn", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    loadQGrns();
});

function loadQGrns() {
    $.ajax({
        type: 'GET',
        url: '/buying/QGrn/loadQGrns',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var WorkstationName = response.result[i]['WorkstationName'];
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thQGrn": WorkstationName,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableQGrn').DataTable();
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
        url: '/buying/QGrn/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadQGrns();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


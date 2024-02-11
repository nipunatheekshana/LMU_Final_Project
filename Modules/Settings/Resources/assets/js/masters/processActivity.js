console.log('processActivity.js loadimng');
var Child_url = '/settings/processActivity_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Process Activity')
    $('#btnCreateNew').on('click', function () {
        location.href = "/settings/processActivity_configure";
    });

    var table = $('#tableprocessActivity').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thprocessActivity", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    loadProcessActivities();
});

function loadProcessActivities() {
    $.ajax({
        type: 'GET',
        url: '/settings/processActivity/loadProcessActivities',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var ActivityName = response.result[i]['ActivityName'];
                    var ProcessName = response.result[i]['ProcessName'];

                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thprocessActivity": ActivityName + ' | ' + ProcessName,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableprocessActivity').DataTable();
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
        url: '/settings/processActivity/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadProcessActivities();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


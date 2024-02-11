console.log('departments.js loadimng');
var Child_url = '/hrm/departments_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Department')
    $('#btnCreateNew').on('click', function () {
        location.href = "/hrm/departments_configure";
    });

    var table = $('#tabledepartments').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thdepartments", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    loadDepartments();
});

function loadDepartments() {
    $.ajax({
        type: 'GET',
        url: '/hrm/departments/loadDepartments',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var depratmentName = response.result[i]['depratmentName'];
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thdepartments": depratmentName,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tabledepartments').DataTable();
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
        url: '/hrm/departments/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadDepartments();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


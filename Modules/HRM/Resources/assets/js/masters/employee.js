console.log('employee.js loadimng');
var Child_url = '/hrm/employee_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Employee')
    $('#btnCreateNew').on('click', function () {
        location.href = "/hrm/employee_configure";
    });

    var table = $('#tableemployee').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "themployee", 'width': "30%" },
            { "data": "thDesignation", 'width': "30%" },
            { "data": "action", 'width': "30%" },
        ],
    });

    loadEmployees();
});

function loadEmployees() {
    $.ajax({
        type: 'GET',
        url: '/hrm/employee/loadEmployees',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var employee_name = response.result[i]['employee_name'];
                    var DesignationName = response.result[i]['DesignationName'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "themployee": employee_name,
                        "thDesignation": DesignationName,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableemployee').DataTable();
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
        url: '/hrm/employee/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadEmployees();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


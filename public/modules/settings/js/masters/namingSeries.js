console.log('namingSeries.js loadimng');
var Child_url = '/settings/namingSeries_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Naming Series')
    $('#btnCreateNew').on('click', function () {
        location.href = "/settings/namingSeries_configure";
    });

    var table = $('#tablenamingSeries').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3,4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thfunction", 'width': "30%" },
            { "data": "thnamingSeries", 'width': "30%" },
            { "data": "thCurrentValue", 'width': "10%" },
            { "data": "action", 'width': "10%" },
        ],
    });

    loadNamingSerieses();
});

function loadNamingSerieses() {
    $.ajax({
        type: 'GET',
        url: '/settings/namingSeries/loadNamingSerieses',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var namingFormat = response.result[i]['namingFormat'];
                    var funct = response.result[i]['function'];
                    var editable = response.result[i]['editable'];
                    var currentValue = response.result[i]['currentValue'];

                    var edit = '';
                    if (editable) {
                        edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    }

                    // var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thfunction": funct,
                        "thnamingSeries": namingFormat,
                        "thCurrentValue": currentValue,
                        "action": edit,
                    });
                }

                var table = $('#tablenamingSeries').DataTable();
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
        url: '/settings/namingSeries/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadNamingSerieses();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


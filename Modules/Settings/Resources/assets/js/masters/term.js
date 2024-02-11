console.log('term.js loadimng');
var Child_url = '/settings/term_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Term')
    $('#btnCreateNew').on('click', function () {
        location.href = "/settings/term_configure";
    });

    var table = $('#tableterm').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thTitle", 'width': "50%" },
            { "data": "thType", 'width': "10%" },
            { "data": "thIs_financial", 'width': "10%" },
            { "data": "thEnabled", 'width': "10%" },
            { "data": "action", 'width': "20%" },
        ],
    });

    loadTerms();
});

function loadTerms() {
    $.ajax({
        type: 'GET',
        url: '/settings/term/loadTerms',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var title = response.result[i]['title'];
                    var description = response.result[i]['description'];
                    var type = response.result[i]['type'];
                    var is_financial = response.result[i]['is_financial'];
                    var financial_state = '';

                    switch (Number(is_financial)) {
                        case 0:
                            financial_state = '<span class="badge bg-warning-bright text-warning">Non-Financial</span>'
                            break;
                        case 1:
                            financial_state = '<span class="badge bg-danger-bright text-danger">Financial</span>'
                            break;

                        default:
                            break;
                    }

                    var enabled = response.result[i]['enabled'];
                    var enabled_state = '';

                    switch (Number(enabled)) {
                        case 0:
                            enabled_state = '<span class="badge bg-muted-bright text-muted">Disabled</span>'
                            break;
                        case 1:
                            enabled_state = '<span class="badge bg-success-bright text-success">Enabled</span>'
                            break;

                        default:
                            break;
                    }

                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thTitle": title,
                        "thType": type,
                        "thIs_financial": financial_state,
                        "thEnabled": enabled_state,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableterm').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log("Something Went Wrong");
        }
    });
};
function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/settings/term/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadTerms();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


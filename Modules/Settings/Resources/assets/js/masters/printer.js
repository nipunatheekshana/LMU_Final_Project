console.log('printer.js loadimng');
var Child_url = '/settings/printer_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Printer')
    $('#btnCreateNew').on('click', function () {
        location.href = "/settings/printer_configure";
    });

    var table = $('#tableprinter').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "5%" },
            { "data": "thprinter_id", 'width': "15%" },
            { "data": "thprinter", 'width': "20%" },
            // { "data": "thlocation", 'width': "20%" },
            { "data": "thport", 'width': "20%" },
            { "data": "action", 'width': "20%" },
        ],
    });

    loadPrinters();
});

function loadPrinters() {
    $.ajax({
        type: 'GET',
        url: '/settings/printer/loadPrinters',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var printer_id = response.result[i]['printer_id'];
                    var printer_name = response.result[i]['printer_name'];
                    // var location = response.result[i]['location'];
                    var printer_port = response.result[i]['printer_port'];
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thprinter_id": printer_id,
                        "thprinter": printer_name,
                        // "thlocation": location,
                        "thport": printer_port,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableprinter').DataTable();
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
        url: '/settings/printer/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadPrinters();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


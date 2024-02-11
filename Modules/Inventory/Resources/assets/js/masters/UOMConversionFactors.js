console.log('UOMConversionFactors.js loadimng');
var Child_url = '/inventory/UOMConversionFactors_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New UOM Conversion Factor')
    $('#btnCreateNew').on('click', function () {
        location.href = "/inventory/UOMConversionFactors_configure";
    });

    var table = $('#tableUOMConversionFactors').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "5%"},
            { "data": "thFromUOM", 'width': "23.75%" },
            { "data": "thToUOM" , 'width': "23.75%"},
            { "data": "thFactor" , 'width': "23.75%"},
            { "data": "action", 'width': "23.75%" },
        ],
    });

    loadUOMConversionFactors();
});

function loadUOMConversionFactors() {
    $.ajax({
        type: 'GET',
        url: '/inventory/UOMConversionFactors/loadUOMConversionFactors',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var uom_from = response.result[i]['uom_from'];
                    var uom_to = response.result[i]['uom_to'];
                    var factor = response.result[i]['factor'];
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thFromUOM": uom_from,
                        "thToUOM": uom_to,
                        "thFactor": factor,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableUOMConversionFactors').DataTable();
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
        url: '/inventory/UOMConversionFactors/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadUOMConversionFactors();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


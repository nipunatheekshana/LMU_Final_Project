console.log('vehicle.js loadimng');
var Child_url = '/settings/vehicle_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New vehicle')
    $('#btnCreateNew').on('click', function () {
        location.href = "/settings/vehicle_configure";
    });

    var table = $('#tablevehicle').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thvehicle", 'width': "40%" },
            { "data": "thModel", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    loadVehicles();
});

function loadVehicles() {
    $.ajax({
        type: 'GET',
        url: '/settings/vehicle/loadVehicles',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var license_plate = response.result[i]['license_plate']
                    , model = response.result[i]['model']
                    , edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'
                    , dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thvehicle": license_plate,
                        "thModel": model,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablevehicle').DataTable();
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
        url: '/settings/vehicle/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadVehicles();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


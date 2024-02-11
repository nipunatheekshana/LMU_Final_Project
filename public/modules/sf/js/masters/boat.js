console.log('boat.js loadimng');
var Child_url = '/sf/boat_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Boat')
    $('#btnCreateNew').on('click', function () {
        location.href = "/sf/boat_configure";
    });

    var table = $('#tableboat').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4, 5],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "5%" },
            { "data": "thBoatID", 'width': "10%" },
            { "data": "thBoatRegNo", 'width': "15%" },
            { "data": "thboat", 'width': "25%" },
            { "data": "thLicenseExpDate", 'width': "10%" },
            { "data": "action", 'width': "10%" },
        ],
    });

    loadboats();
});

function loadboats() {
    $.ajax({
        type: 'GET',
        url: '/sf/boat/loadboats',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var BoatID = response.result[i]['BoatID'];
                    var BoatRegNo = response.result[i]['BoatRegNo'];
                    var BoatName = response.result[i]['BoatName'];
                    var LicenseExpDate = response.result[i]['LicenseExpDate'];
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thBoatID": BoatID,
                        "thBoatRegNo": BoatRegNo,
                        "thboat": BoatName,
                        "thLicenseExpDate": LicenseExpDate,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableboat').DataTable();
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
        url: '/sf/boat/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadboats();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function deleteConfirmation(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                _delete(id)
                swal({
                    title:"Deleted!",
                    text: "Selected Data has been deleted",
                    icon: "success",
                });
            } else {
                swal({
                    title:"Not Deleted!",
                    text: "Your Data is Safe",
                    icon: "error",
                });
            }
        });
}

function edit(id) {
    location.href = Child_url + id;
}


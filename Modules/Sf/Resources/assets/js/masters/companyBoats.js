console.log('companyBoats.js loadimng');
var Child_url = '/sf/companyBoats_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Company Boat')
    $('#btnCreateNew').on('click', function () {
        location.href = "/sf/companyBoats_configure";
    });

    var table = $('#tablecompanyBoats').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thcompanyBoats", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    loadCompanyBoats();
});

function loadCompanyBoats() {
    $.ajax({
        type: 'GET',
        url: '/sf/companyBoats/loadCompanyBoats',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var companyName = response.result[i]['companyName'];
                    var BoatName = response.result[i]['BoatName'];

                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thcompanyBoats": companyName+' | ' +BoatName,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablecompanyBoats').DataTable();
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
        url: '/sf/companyBoats/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadCompanyBoats();
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


console.log('fishRejectReason.js loading');
var Child_url = '/sf/fishrejectreason_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Cutting Type')
    $('#btnCreateNew').on('click', function () {
        location.href = "/sf/fishrejectreason_configure";
    });

    var table = $('#tableRejectReasonMaster').DataTable({
        responsive: true,
        'columnDefs': [
            {
                "targets": [0, 1, 2, 3],
                "className": "text-center",
            },
            {
                "targets": [2],
                "visible": false,
            },
        ],
        "order": [[2, 'desc']],
        "columns": [
            // { "data": "thId", 'width': "10%" },
            { "data": "thRejectCode", 'width': "22.5%" },
            { "data": "thRejectReason", 'width': "32.5%" },
            { "data": "index", 'width': "22.5%" },
            { "data": "action", 'width': "22.5%" },
        ],
    });



    loadRejectReasons();
});

function loadRejectReasons() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishRejectReason/loadRejectReasons',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var rejectCodeData = response.result[i]['rejectCode'];
                    var rejectReason = response.result[i]['rejectReason'];
                    var list_index = response.result[i]['list_index'];
                    var rejectCode = '<a onclick="edit(' + id + ')" class="badge badge-primary text-light">' + rejectCodeData + '</a>'
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    // var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        // "thId": id,
                        "thRejectCode": rejectCode,
                        "thRejectReason": rejectReason,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableRejectReasonMaster').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
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
                    title: "Deleted!",
                    text: "Selected Data has been deleted",
                    icon: "success",
                });
            } else {
                swal({
                    title: "Not Deleted!",
                    text: "Your Data is Safe",
                    icon: "error",
                });
            }
        });
}

function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/sf/fishRejectReason/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadRejectReasons();
            }
            else {
                swal("Cannot Delete Reject Reason", "Reject Reason already in use", "error");
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


console.log('presentationTypeMaster.js loadimng');
var Child_url = '/sf/presentationTypeMaster_Configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Presentation Type')
    $('#btnCreateNew').on('click', function () {
        location.href = "/sf/presentationTypeMaster_Configure";
    });

    var table = $('#tablepresentationTypeMaster').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thFishName", 'width': "22.5%" },
            { "data": "thPrsntCode", 'width': "22.5%" },
            { "data": "thPrsntName", 'width': "22.5%" },
            { "data": "action", 'width': "22.5%" },
        ],
    });

    loadPresentationTypes();
});
function loadPresentationTypes() {
    $.ajax({
        type: 'GET',
        url: '/sf/presentationTypeMaster/loadPresentationTypes',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var PrsntCode = response.result[i]['PrsntCode'];
                    var PrsntName = response.result[i]['PrsntName'];
                    var FishName = response.result[i]['FishName'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thFishName": FishName,
                        "thPrsntCode": PrsntCode,
                        "thPrsntName": PrsntName,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablepresentationTypeMaster').DataTable();
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
        url: '/sf/presentationTypeMaster/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadPresentationTypes();
            }
            else {
                swal("Cannot Delete Presentation Type", "Presentation Type already in use", "error");
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


console.log('catchMethodMaster.js loadimng');
var Child_url = '/sf/catchMethodMaster_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Catch Method')
    $('#btnCreateNew').on('click', function () {
        location.href = "/sf/catchMethodMaster_configure";
    });

    var table = $('#tablecatchMethodMaster').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thCatchMethodCode", 'width': "22.5%" },
            { "data": "thCatchMethodName", 'width': "22.5%" },
            { "data": "index", 'width': "22.5%" },
            { "data": "action", 'width': "22.5%" },
        ],
    });

    loadCatchMethods();
});

function loadCatchMethods() {
    $.ajax({
        type: 'GET',
        url: '/sf/catchMethodMaster/loadCatchMethods',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var CatchMethodCode = response.result[i]['CatchMethodCode'];
                    var CatchMethodName = response.result[i]['CatchMethodName'];
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thCatchMethodCode": CatchMethodCode,
                        "thCatchMethodName": CatchMethodName,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablecatchMethodMaster').DataTable();
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
        url: '/sf/catchMethodMaster/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadCatchMethods();
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


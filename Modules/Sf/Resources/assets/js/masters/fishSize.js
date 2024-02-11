console.log('fishSize.js loadimng');
var Child_url = '/sf/fishSize_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Fish Size')
    $('#btnCreateNew').on('click', function () {
        location.href = "/sf/fishSize_configure";
    });

    var table = $('#tablefishSize').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2,3,4,5],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thfishSp", 'width': "18%" },
            { "data": "thfishSize", 'width': "18%" },
            { "data": "thminValue", 'width': "18%" },
            { "data": "thmaxValue", 'width': "18%" },
            { "data": "action", 'width': "18%" },
        ],
    });

    loadFishSizes();
});

function loadFishSizes() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishSize/loadFishSizes',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var SizeCode = response.result[i]['SizeCode'];
                    var FishName = response.result[i]['FishName'];
                    var minValue = response.result[i]['minValue'];
                    var maxValue = response.result[i]['maxValue'];

                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thfishSp": FishName,
                        "thfishSize": SizeCode,
                        "thminValue": minValue,
                        "thmaxValue": maxValue,
                        "index": list_index,
                        "action": dele,
                    });
                }

                var table = $('#tablefishSize').DataTable();
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
        url: '/sf/fishSize/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadFishSizes();
            }
            else {
                swal("Cannot Delete Fish Size", "Fish Size already in use", "error");
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


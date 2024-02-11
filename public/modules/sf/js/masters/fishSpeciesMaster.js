console.log('fishSpeciesMaster.js loadimng');
var Child_url = '/sf/fishSpeciesMaster_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Fish Species')
    $('#btnCreateNew').on('click', function () {
        location.href = "/sf/fishSpeciesMaster_configure";
    });

    var table = $('#tablefishSpeciesMaster').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4, 5],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thFishCode", 'width': "10%" },
            { "data": "thFishName", 'width': "20%" },
            { "data": "thShortName", 'width': "20%" },
            { "data": "thScName", 'width': "20%" },
            { "data": "action", 'width': "20%" },
        ],
    });

    loadFishSpecies();
});

function loadFishSpecies() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishSpeciesMaster/loadFishSpecies',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var FishCode = response.result[i]['FishCode'];
                    var FishName = response.result[i]['FishName'];
                    var ShortName = response.result[i]['ShortName'];
                    var ScName = response.result[i]['ScName'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thFishCode": FishCode,
                        "thFishName": FishName,
                        "thShortName": ShortName,
                        "thScName": ScName,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablefishSpeciesMaster').DataTable();
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
        url: '/sf/fishSpeciesMaster/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadFishSpecies();
            }
            else {
                swal("Cannot Delete Fish Species", "Fish Species already in use", "error");
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


console.log('manufacturingItem.js loadimng');
var Child_url = '/sf/manufacturingItem_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Manufacturing Item')
    $('#btnCreateNew').on('click', function () {
        location.href = "/sf/manufacturingItem_configure";
    });

    var table = $('#tablemanufacturingItem').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thItem_Code", 'width': "20%" },
            { "data": "thmanufacturingItem", 'width': "20%" },
            { "data": "thavg_weight_per_unit", 'width': "18%" },
            { "data": "action", 'width': "22%" },
        ],
    });

    loadmanufacturingItems();
});

function loadmanufacturingItems() {
    $.ajax({
        type: 'GET',
        url: '/sf/manufacturingItem/loadmanufacturingItems',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var Item_Code = response.result[i]['Item_Code'];
                    var item_name = response.result[i]['item_name'];
                    var avgweightperunit = response.result[i]['avg_weight_per_unit']
                    var uom = response.result[i]['UomName']
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thItem_Code": Item_Code,
                        "thmanufacturingItem": item_name,
                        "thavg_weight_per_unit": avgweightperunit.toPrecision(4)  + ' ' + uom,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablemanufacturingItem').DataTable();
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
        url: '/sf/manufacturingItem/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadmanufacturingItems();
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


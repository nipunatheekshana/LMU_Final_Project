console.log('byproductItem.js loadimng');
var Child_url = '/sf/byproductItem_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Byproduct Item')
    $('#btnCreateNew').on('click', function () {
        location.href = "/sf/byproductItem_configure";
    });

    var table = $('#tablebyproductItem').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thbyproductItemCode", 'width': "20%" },
            { "data": "thbyproductItem", 'width': "40%" },
            { "data": "thrmspecies", 'width': "25%" },
            { "data": "action", 'width': "15%" },
        ],
    });

    loadbyproductItems();
});

function loadbyproductItems() {
    $.ajax({
        type: 'GET',
        url: '/sf/byproductItem/loadbyproductItems',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var Item_Code = response.result[i]['Item_Code'];
                    var item_name = response.result[i]['item_name'];
                    var FishName = response.result[i]['FishName'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';

                    data.push({
                        "thbyproductItemCode": Item_Code,
                        "thbyproductItem": item_name,
                        "thrmspecies": FishName,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablebyproductItem').DataTable();
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
        url: '/sf/byproductItem/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadbyproductItems();
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


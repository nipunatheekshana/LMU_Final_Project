console.log('Item.js loadimng');
var Child_url = '/inventory/Item_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Item')
    $('#btnCreateNew').on('click', function () {
        location.href = "/inventory/Item_configure";
    });

    var table = $('#tableItem').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "5%" },
            { "data": "thItemCode", 'width': "20%" },
            { "data": "thItem", 'width': "40%" },
            { "data": "thItemGroup", 'width': "25%" },
            { "data": "action", 'width': "10%" },
        ],
    });

    loadItems();
});

function loadItems() {
    $.ajax({
        type: 'GET',
        url: '/inventory/Item/loadItems',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var item_code = response.result[i]['Item_Code'];
                    var item_name = response.result[i]['item_name'];
                    var item_group = response.result[i]['GroupName'];
                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thItemCode": item_code,
                        "thItem": item_name,
                        "thItemGroup": item_group,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableItem').DataTable();
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
        url: '/inventory/Item/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadItems();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


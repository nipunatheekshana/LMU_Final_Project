console.log('itemPrice.js loadimng');
var Child_url = '/accounting/itemPrice_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Item Price')
    $('#btnCreateNew').on('click', function () {
        location.href = "/accounting/itemPrice_configure";
    });

    var table = $('#tableitemPrice').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2,3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "5%" },
            { "data": "thitem", 'width': "23.75%" },
            { "data": "thPriceList", 'width': "23.75%" },
            { "data": "thitemPrice", 'width': "23.75%" },
            { "data": "action", 'width': "23.75%" },
        ],
    });

    loadItemPrices();
});

function loadItemPrices() {
    $.ajax({
        type: 'GET',
        url: '/accounting/itemPrice/loadItemPrices',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var item = response.result[i]['item'];
                    var price_list = response.result[i]['price_list'];
                    var price = response.result[i]['price'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thitem": item,
                        "thPriceList": price_list,
                        "thitemPrice": price,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableitemPrice').DataTable();
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
        url: '/accounting/itemPrice/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadItemPrices();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


console.log('deliveryNote.js loadimng');
var Child_url = '/inventory/deliveryNote_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Delivery Note')
    $('#btnCreateNew').on('click', function () {
        location.href = "/inventory/deliveryNote_configure";
    });

    var table = $('#tabledeliveryNote').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thDeliveryNoteNo", 'width': "40%" },
            { "data": "thtotalQty", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    loadDeliveryNotes();
});

function loadDeliveryNotes() {
    $.ajax({
        type: 'GET',
        url: '/inventory/deliveryNote/loadDeliveryNotes',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var delivery_note_no = response.result[i]['delivery_note_no'];
                    var total_qty = response.result[i]['total_qty'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thDeliveryNoteNo": delivery_note_no,
                        "thtotalQty": total_qty,
                        "action": edit + dele,
                    });
                }

                var table = $('#tabledeliveryNote').DataTable();
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
        url: '/inventory/deliveryNote/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadDeliveryNotes();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


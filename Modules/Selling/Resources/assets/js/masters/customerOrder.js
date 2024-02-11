console.log('customerOrder.js loadimng');
var Child_url = '/selling/customerOrder_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Customer Order')
    $('#btnCreateNew').on('click', function () {
        location.href = "/selling/customerOrder_configure";
    });

    var table = $('#tablecustomerOrder').DataTable({
        scrollY: 20000,
        scrollX: true,
        scrollY: true,
        scrollCollapse: true,

        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thcustomerOrder", 'width': "22.5%" },
            { "data": "thcustomerName", 'width': "22.5%" },
            { "data": "thStateLable", 'width': "20%" },
            { "data": "action", 'width': "22.5%" },
        ],
    });

    loadCustomerOrders();
});

function loadCustomerOrders() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrder/loadCustomerOrders',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var state = '';
                    var dele = '<button class="btn btn-danger mr-1" disabled><i class="fa fa-trash" aria-hidden="true"></i></button>';

                    var id = response.result[i]['id'];
                    var order_number = response.result[i]['order_number'];
                    var order_status = response.result[i]['order_status'];
                    var CusName = response.result[i]['CusName'];

                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                   
                    switch (Number(order_status)) {
                        case 0:
                            state = '<span class="badge bg-warning-bright text-warning">Draft</span>'
                            dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                            break;
                        case 1:
                            state = '<span class="badge bg-primary-bright text-primary">Submited</span>'

                            break;
                        case 2:
                            state = '<span class="badge bg-success-bright text-success">Approved</span>'

                            break;
                        case 3:
                            state = '<span class="badge bg-secondary-bright text-secondary">Denied</span>'

                            break;
                        case 4:
                            state = '<span class="badge bg-danger-bright text-danger">Closed</span>'
                            break;

                        default:
                            break;
                    }

                    data.push({
                        "thId": id,
                        "thcustomerOrder": order_number,
                        "thcustomerName": CusName,
                        "thStateLable": state,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablecustomerOrder').DataTable();
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
        url: '/selling/customerOrder/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadCustomerOrders();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
function edit(id) {
    location.href = Child_url + id;
}


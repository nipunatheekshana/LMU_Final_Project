console.log('customerItem.js loadimng');
var Child_url = '/mnu/customerItem_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Customer Item')
    $('#btnCreateNew').on('click', function () {
        location.href = "/mnu/customerItem_configure";
    });

    var table = $('#tablecustomerItem').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thcustomer", 'width': "30%" },
            { "data": "thItem", 'width': "30%" },
            { "data": "action", 'width': "30%" },
        ],
    });

    $('#btnAdd').click(function () {
        var itemType = $('#itemType').val()
        var Customer = $('#customer').val()
        // if(Customer=''){
        //     Customer='null'
        // }
        // if(itemType=''){
        //     itemType='null'
        // }
        console.log(itemType)
        console.log(Customer)


        FilterCustomerItems(Customer,itemType);
    });
    loadCustomers();
    loadCustomerItems();
});

function loadCustomerItems() {
    $.ajax({
        type: 'GET',
        url: '/mnu/customerItem/loadCustomerItems',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var CusName = response.result[i]['CusName'];
                    var item_name = response.result[i]['item_name'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConfirmation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thcustomer": CusName,
                        "thItem": item_name,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablecustomerItem').DataTable();
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
        url: '/mnu/customerItem/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadCustomerItems();
            }
            else {
                swal("Cannot Delete Customer Item", "Customer Item already in use", "error");
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
function FilterCustomerItems(customer,itemType){
    $.ajax({
        type: 'GET',
        url: '/mnu/customerItem/FilterCustomerItems/'+customer+'/'+itemType,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var CusName = response.result[i]['CusName'];
                    var item_name = response.result[i]['item_name'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thcustomer": CusName,
                        "thItem": item_name,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablecustomerItem').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}

function loadCustomers() {
    $.ajax({
        type: 'GET',
        url: '/mnu/customerItem/loadCustomers',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.CusName + ' </option>';
                });
                $('#customer').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

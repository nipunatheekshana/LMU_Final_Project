console.log('customerMaster.js loadimng');
var Child_url = '/selling/customer_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Customer')
    $('#btnCreateNew').on('click', function () {
        location.href = "/selling/customer_configure" ;
    });

    var table = $('#tablecustomerMaster').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId" ,'width':"20%"},
            { "data": "thcustomerMasters" ,'width':"20%"},
            { "data": "thCountry" ,'width':"20%"},
            { "data": "thEmail" ,'width':"20%"},
            { "data": "action" ,'width':"20%"},
        ],
    });

    loadCustomers();
});

function loadCustomers() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMaster/loadCustomers',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var CusName = response.result[i]['CusName'];
                    var country_name = response.result[i]['country_name'];
                    var emailAddress = response.result[i]['emailAddress'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thcustomerMasters": CusName,
                        "thCountry": country_name,
                        "thEmail": emailAddress,
                        "action": edit+dele,
                    });
                }

                var table = $('#tablecustomerMaster').DataTable();
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
        url: '/selling/customerMaster/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadCustomers();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id){
    location.href =Child_url + id;
}


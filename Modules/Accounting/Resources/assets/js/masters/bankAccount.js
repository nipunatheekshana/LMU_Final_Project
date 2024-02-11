console.log('bankAccount.js loadimng');
var Child_url = '/accounting/bankAccount_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Bank Account')
    $('#btnCreateNew').on('click', function () {
        location.href = "/accounting/bankAccount_configure";
    });

    var table = $('#tablebankAccount').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thbankAccount", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    loadBankAccounts();
});

function loadBankAccounts() {
    $.ajax({
        type: 'GET',
        url: '/accounting/bankAccount/loadBankAccounts',
        success: function (response) {
            if (response.success) {
                var data = response.result.map(function (item) {
                    return {
                        "thId": item.id,
                        "thbankAccount": item.account_title,
                        "index": item.list_index,
                        "action": '<button class="btn btn-primary mr-1" onclick="edit(' + item.id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>' +
                            '<button class="btn btn-danger mr-1" onclick="_delete(' + item.id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                    };
                });

                var table = $('#tablebankAccount').DataTable();
                table.clear().rows.add(data).draw();
            }
        },
        error: function () {
            console.log('something went wrong');
        }
    });
}

function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/accounting/bankAccount/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadBankAccounts();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


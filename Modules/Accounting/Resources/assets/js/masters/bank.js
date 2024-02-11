console.log('bank.js loadimng');
var Child_url = '/accounting/bank_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Bank')
    $('#btnCreateNew').on('click', function () {
        location.href = "/accounting/bank_configure";
    });

    var table = $('#tablebank').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thbank", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    loadBanks();
});

function loadBanks() {
    $.ajax({
        type: 'GET',
        url: '/accounting/bank/loadBanks',
        success: function (response) {
            if (response.success) {
                var data = response.result.map(function (item) {
                    return {
                        "thId": item.id,
                        "thbank": item.bank_name,
                        "index": item.list_index,
                        "action": '<button class="btn btn-primary mr-1" onclick="edit(' + item.id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>' +
                            '<button class="btn btn-danger mr-1" onclick="_delete(' + item.id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                    };
                });

                var table = $('#tablebank').DataTable();
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
        url: '/accounting/bank/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadBanks();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


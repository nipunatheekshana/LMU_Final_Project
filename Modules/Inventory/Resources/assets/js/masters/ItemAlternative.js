console.log('itemAlternative.js loadimng');
var Child_url = '/inventory/itemAlternative_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Item Alternative')
    $('#btnCreateNew').on('click', function () {
        location.href = "/inventory/itemAlternative_configure";
    });

    var table = $('#tableitemAlternative').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thitem", 'width': "30%" },
            { "data": "thitemAlternative", 'width': "30%" },
            { "data": "action", 'width': "30%" },
        ],
    });

    loadItemAlternatives();
});

function loadItemAlternatives() {
    $.ajax({
        type: 'GET',
        url: '/inventory/itemAlternative/loadItemAlternatives',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var item = response.result[i]['item'];
                    var item_alternative = response.result[i]['item_alternative'];

                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thitem": item,
                        "thitemAlternative": item_alternative,
                        "index": list_index,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableitemAlternative').DataTable();
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
        url: '/inventory/itemAlternative/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadItemAlternatives();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


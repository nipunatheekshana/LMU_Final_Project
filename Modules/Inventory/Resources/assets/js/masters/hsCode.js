console.log('hsCode.js loadimng');
var Child_url = '/inventory/hsCode_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New HS Code')
    $('#btnCreateNew').on('click', function () {
        location.href = "/inventory/hsCode_configure";
    });

    var table = $('#tablehsCode').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thhsCode", 'width': "20%" },
            { "data": "thCountry", 'width': "20%" },
            { "data": "thDescription", 'width': "20%" },
            { "data": "action", 'width': "20%" },
        ],
    });

    loadHsCodes();
});

function loadHsCodes() {
    $.ajax({
        type: 'GET',
        url: '/inventory/hsCode/loadHsCodes',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var HSCode = response.result[i]['HSCode'];
                    var HS_Description = response.result[i]['HS_Description'];
                    var country_name = response.result[i]['country_name'];

                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thhsCode": HSCode,
                        "thCountry": country_name,
                        "thDescription": HS_Description,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablehsCode').DataTable();
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
        url: '/inventory/hsCode/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadHsCodes();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


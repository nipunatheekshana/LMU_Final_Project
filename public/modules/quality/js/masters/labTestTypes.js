console.log('labTestTypes.js loadimng');
var Child_url = '/quality/labTestTypes_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Lab Test Type')
    $('#btnCreateNew').on('click', function () {
        location.href = "/quality/labTestTypes_configure";
    });

    var table = $('#tablelabTestTypes').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thlabTestTypeCode", 'width': "20%" },
            { "data": "thlabTestTypeName", 'width': "50%" },
            { "data": "action", 'width': "20%" },
        ],
    });

    loadLabTestTypes();
});

function loadLabTestTypes() {
    $.ajax({
        type: 'GET',
        url: '/quality/labTestTypes/loadLabTestTypes',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var LabTestTypeCode = response.result[i]['testTypeCode'];
                    var LabTestTypeName = response.result[i]['testTypeName'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thlabTestTypeCode": LabTestTypeCode,
                        "thlabTestTypeName": LabTestTypeName,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablelabTestTypes').DataTable();
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
        url: '/quality/labTestTypes/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadLabTestTypes();
            }

            else {
                swal("Cannot Delete Lab Test Type", "Lab Test Type already in use", "error");
            }

        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


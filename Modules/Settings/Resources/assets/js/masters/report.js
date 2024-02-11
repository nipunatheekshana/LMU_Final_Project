console.log('report.js loading');
var Child_url = '/settings/report_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Report')
    $('#btnCreateNew').on('click', function () {
        location.href = "/settings/report_configure";
    });

    var table = $('#tablereport').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4, 5],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "5%" },
            { "data": "threport_name", 'width': "25%" },
            { "data": "thremodule", 'width': "20%" },
            { "data": "threport_file_location", 'width': "25%" },
            { "data": "threport_level", 'width': "10%" },
            { "data": "action", 'width': "15%" },
        ],
    });

    loadReports();
});

function loadReports() {
    $.ajax({
        type: 'GET',
        url: '/settings/report/loadReports',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var report_name = response.result[i]['report_name'];
                    var module = response.result[i]['module'];
                    var report_file_location = response.result[i]['report_file_location'];
                    var report_level = response.result[i]['report_level'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "threport_name": report_name,
                        "thremodule": module,
                        "threport_file_location": report_file_location,
                        "threport_level": report_level,
                        "action": edit,
                    });
                }

                var table = $('#tablereport').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}


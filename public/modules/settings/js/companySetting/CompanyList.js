console.log('CompanyList.js loading')
$(document).ready(function () {

    $('#btnCreateNew').text('Create New Company')
    $('#btnCreateNew').on('click', function () {
        location.href = "/settings/create_Company";
    });

    var table = $('#tableCompanyList').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",
        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "5%" },
            { "data": "thName", 'width': "45%" },
            { "data": "thAbbr", 'width': "10%" },
            { "data": "themail", 'width': "20%" },
            { "data": "actions", 'width': "20%" },
        ],

    });
    $('#btnDelete').click(function () {
        var deleteText = $('#DeleteText').val();
        var id = $('#DeleteID').val();
        if (deleteText == 'DELETE') {
            _delete(id);
        }
        else {
            toastr.warning('Invalid Text');
        }
    });
    loadCompanies();
});

function loadCompanies() {
    $.ajax({
        type: 'GET',
        url: '/settings/CompanyList/loadCompanies',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var activeStatus = response.result[i]['enabled'];
                    var statusLabel = (activeStatus === 1) ? 'Active' : 'Inactive';
                    var statusColor = (activeStatus === 1) ? 'success' : 'danger';
                    var name = response.result[i]['companyName'] + ' <span class="badge badge-' + statusColor + '">' + statusLabel + '</span>';

                    var abbr = '<span class="badge badge-warning">' + response.result[i]['abbr'] +'</span> ';
                    var email = response.result[i]['email'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="deleteConformation(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thName": name,
                        "thAbbr": abbr,
                        "themail": email,
                        "actions": edit + dele,
                    });
                }

                var table = $('#tableCompanyList').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
};
function deleteConformation(id) {
    $('#deleteConformationModel').modal('toggle');
    $('#DeleteID').val(id);
}
function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/settings/CompanyList/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadCompanies();
                $('#deleteConformationModel').modal('toggle');
            }
        }, error: function (data) {
            console.log(data.result);
        }
    });
};
function view(id) {
    location.href = "/settings/create_Company?" + id + "&view";
}
function edit(id) {

    location.href = "/settings/create_Company?" + id;

}

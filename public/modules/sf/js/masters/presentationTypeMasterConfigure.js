console.log('presentationTypeMasterConfigure .js loadimng');
var parent_url = '/sf/presentationTypeMaster_list'
$(document).ready(function () {

    $('#btnSave').on('click', function () {
        var form = $('#frmpresentationTypeMaster').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });
    $('#fish_species').change(function () {
        loadRelatedPresentationTypes(this.value);
    });


    var table = $('#tablepresentationTypeMaster').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thFishName", 'width': "22.5%" },
            { "data": "thPrsntCode", 'width': "22.5%" },
            { "data": "thPrsntName", 'width': "22.5%" },
            { "data": "action", 'width': "22.5%" },
        ],
    });
    loadFishSpecies();
    loadPresentationType();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/presentationTypeMasterConfigure/save",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {
            $('#btnSave').html('waiting')

        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success(response.message);
                $('#frmpresentationTypeMasterConfigure ').trigger("reset");
                location.href = parent_url;

                $('#btnSave').html('Done')
            }
            else {
                toastr.error(response.message);
            }
        },
        error: function (error) {
            console.log(error);

            if (error.status == 422) { // when status code is 422, it's a validation issue
                console.log(error.responseJSON);
                // you can loop through the errors object and show it to the user
                console.warn(error.responseJSON.errors);
                // display errors on each form field
                $.each(error.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    //  el[0].style.border = '1px solid red';

                    errorElement(el);
                    toastr.warning(error[0]);
                    console.clear()
                });
            }
            else {
                toastr.error('Something went wrong');
            }
        },
        complete: function () {
            $('#btnSave').html('Save')
        }
    });
};
function update(data) {
    $.ajax({
        type: "POST",
        url: "/sf/presentationTypeMasterConfigure/update",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {
            $('#btnSave').html('waiting')

        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success(response.message);
                $('#frmpresentationTypeMasterConfigure ').trigger("reset");
                location.href = parent_url;

                $('#btnSave').html('Done')
            }
            else {
                toastr.error(response.message);
            }
        },
        error: function (error) {
            console.log(error);

            if (error.status == 422) { // when status code is 422, it's a validation issue
                console.log(error.responseJSON);
                // you can loop through the errors object and show it to the user
                console.warn(error.responseJSON.errors);
                // display errors on each form field
                $.each(error.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    //  el[0].style.border = '1px solid red';

                    errorElement(el);
                    toastr.warning(error[0]);
                    console.clear()
                });
            }
            else {
                toastr.error('Something went wrong');
            }
        },
        complete: function () {
            $('#btnSave').html('Update')
        }
    });
};

function loadPresentationType() {

    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
        if (param.length == 2) {
            console.log('view ')
            $('#btnSave').hide();

        } else {
            console.log('edit ');
            $('#btnSave').text('Update');

        }

    }
    if (id) {
        $.ajax({
            type: "GET",
            url: '/sf/presentationTypeMasterConfigure/loadPresentationType/' + id,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            async: false,
            beforeSend: function () {

            },
            success: function (response) {

                if (response.success) {
                    var data = response.result;
                    $('#PrsntCode').val(data.PrsntCode);
                    $('#PrsntName').val(data.PrsntName);
                    $('#hiddenId').val(data.id);
                    $('#fish_species').val(data.fish_species);
                    loadRelatedPresentationTypes(data.fish_species);
                    $('#list_index').val(data.list_index);
                    if (data.enabled) {
                        $("#enabled").prop("checked", true);
                    }
                    else {
                        $("#enabled").prop("checked", false);
                    }
                    $('#btnSave').html('Update')
                }

            },
            error: function (error) {
                console.log(error);

            },
            complete: function () {

            }

        });
    }

}

function loadFishSpecies() {
    $.ajax({
        type: 'GET',
        url: '/sf/presentationTypeMasterConfigure/loadFishSpecies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                $('#fish_species').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function loadRelatedPresentationTypes(id) {
    $.ajax({
        type: 'GET',
        url: '/sf/presentationTypeMasterConfigure/loadRelatedPresentationTypes/' + id,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var PrsntCode = response.result[i]['PrsntCode'];
                    var PrsntName = response.result[i]['PrsntName'];
                    var FishName = response.result[i]['FishName'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thFishName": FishName,
                        "thPrsntCode": PrsntCode,
                        "thPrsntName": PrsntName,
                        "action": edit + dele,
                    });
                }

                var table = $('#tablepresentationTypeMaster').DataTable();
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
        url: '/sf/presentationTypeMaster/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadRelatedPresentationTypes($('#fish_species').val());
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}

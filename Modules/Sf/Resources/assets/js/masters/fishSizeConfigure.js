console.log('fishSizeConfigure .js loadimng');
var parent_url = '/sf/fishSize_list'
$(document).ready(function () {

    $('#btnSave').prop("disabled", true);
    $('#minValue').prop("readonly", true);
    $('#SizeCode').prop("readonly", true);
    $('#FishSpeciesId').prop("disabled", true);

    var table = $('#tablefishSize').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thfishSize", 'width': "22.5%" },
            { "data": "thminValue", 'width': "22.5%" },
            { "data": "thmaxValue", 'width': "22.5%" },
            { "data": "action", 'width': "22.5%" },
        ],
    });


    $('#btnSave').on('click', function () {
        var form = $('#frmfishSizeConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });

    $('#CompanyId').change(function () {
        if (this.value != '') {
            $('#FishSpeciesId').prop("disabled", false);
        } else {
            var table = $('#tablefishSize').DataTable();
            table.clear();
            $('#FishSpeciesId').prop("disabled", true);
            $('#minValue').val('');
            $('#maxValue').val('');

            $('#FishSpeciesId').val('');

        }
    });

    $('#FishSpeciesId').change(function () {
        if (this.value != '') {
            $('#btnSave').prop("disabled", false);
            var compid = $('#CompanyId').val();
            $('#maxValue').val('');

            getNewMinValue(compid, this.value);
            loadRelatedFishSizes(compid, this.value)
        } else {
            var table = $('#tablefishSize').DataTable();
            table.clear();
            $('#maxValue').val('');

            $('#btnSave').prop("disabled", true);
            $('#minValue').val('');

        }
    });

    $('#maxValue').change(function () {
        if (this.value != '') {
            validateMInMAx(this.value);
        }
        $('#SizeCode').val($('#minValue').val() + '-' + this.value)
    });


    loadCompanies();
    loadFishSpecis();
    loadFishSize();


});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/fishSizeConfigure/save",
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

                var compid = $('#CompanyId').val();
                var fishSPid = $('#FishSpeciesId').val();

                getNewMinValue(compid, fishSPid);
                loadRelatedFishSizes(compid, fishSPid)

                $('#maxValue').val('');
                $('#SizeCode').val('');


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
        url: "/sf/fishSizeConfigure/update",
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
                $('#frmfishSizeConfigure ').trigger("reset");
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

function loadFishSize() {

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
            url: "/sf/fishSizeConfigure/loadFishSize/" + id,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            async: false,
            beforeSend: function () {

            },
            success: function (response) {

                if (response.success) {

                    console.log(response.result);
                    var data = response.result;

                    $('#hiddenId').val(data.id);

                    $('#CompanyId').val(data.CompanyId);
                    $('#FishSpeciesId').val(data.FishSpeciesId);
                    $('#minValue').val(data.minValue);
                    $('#maxValue').val(data.maxValue);
                    $('#SizeCode').val(data.SizeCode);
                    $('#SizeDescription').val(data.SizeDescription);

                    $('#list_index').val(data.list_index);
                    if (data.enabled) {
                        $("#enabled").prop("checked", true);
                    }
                    else {
                        $("#enabled").prop("checked", false);
                    }

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

function loadCompanies() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishSizeConfigure/loadCompanies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.companyName + ' </option>';
                });
                $('#CompanyId').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadFishSpecis() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishSizeConfigure/loadFishSpecis',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                $('#FishSpeciesId').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function getNewMinValue(compid, fishSPid) {

    $.ajax({
        type: 'GET',
        url: '/sf/fishSizeConfigure/getNewMinValue/' + compid + '/' + fishSPid,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#minValue').val(response.result);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function validateMInMAx(max) {

    var min = $('#minValue').val();

    console.log(max)
    if (Number(max) < Number(min)) {
        toastr.warning('Max value is lover than min');
        $('#maxValue').val('');

        var el = $('#maxValue');
        el[0].style.border = '1px solid red';
        setTimeout(function () {
            el[0].style.border = '';
        }, 4000);
    }
}
function loadRelatedFishSizes(compid, fishSPid) {
    $.ajax({
        type: 'GET',
        url: '/sf/fishSizeConfigure/loadRelatedFishSizes/' + compid + '/' + fishSPid,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var SizeCode = response.result[i]['SizeCode'];
                    var minValue = response.result[i]['minValue'];
                    var maxValue = response.result[i]['maxValue'];

                    var list_index = response.result[i]['list_index'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thfishSize": SizeCode,
                        "thminValue": minValue,
                        "thmaxValue": maxValue,
                        "index": list_index,
                        "action": dele,
                    });
                }

                var table = $('#tablefishSize').DataTable();
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
        url: '/sf/fishSize/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                var compid = $('#CompanyId').val();
                var fishSPid = $('#FishSpeciesId').val();
                loadRelatedFishSizes(compid, fishSPid);
                getNewMinValue(compid, fishSPid)
            } else {
                toastr.warning(response.message)
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

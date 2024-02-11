console.log('fishReceiveParamSettingsConfigure .js loadimng');
var parent_url = '/sf/fishReceiveParamSettings_list'
$(document).ready(function () {

    $('#btnClear').hide();

    var table = $('#tablefishReceiveParamSettings').DataTable({
        searching: false,
        paging: false,
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thfishReceiveParamSettings", 'width': "26.6%" },
            { "data": "thQParam", 'width': "26.6%" },
            { "data": "action", 'width': "26.6%" },
        ],
    });

    $('#btnSave').on('click', function () {
        var form = $('#frmfishReceiveParamSettingsConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }
    });

    $('#btnClear').click(function () {
        $('#frmfishReceiveParamSettingsConfigure ').trigger("reset");
        $('#btnSave').html('Save')
        $('#btnClear').hide();
    });
    $('#CompanyID').change(function () {
        loadRelatedParam();
    });
    $('#FishSpeciesID').change(function () {
        loadRelatedParam();
    });
    $('#FishPrasentationID').change(function () {
        loadRelatedParam();
    });
    $('#QParamID').change(function () {
        loadMinMaxValue(this.value);
    });
    $('#DefaultVal').change(function () {
        checkDefaultValuRange(this.value)
    });

    loadFishPrasentation();
    loadQParamID();
    loadCompanies();
    loadFishSpecies();
    CheckUrlParameter();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/fishReceiveParamSettingsConfigure/save",
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
                $('#QParamID').prop('selectedIndex', 0);
                $('#paramName').val('');

                // location.href = parent_url;
                loadRelatedParam();
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
        url: "/sf/fishReceiveParamSettingsConfigure/update",
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
                $('#frmfishReceiveParamSettingsConfigure ').trigger("reset");
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
function CheckUrlParameter() {

    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
        if (param.length == 2) {
            console.log('view ')
            $('#btnSave').hide();

        } else {
            console.log('edit ');
            // $('#btnSave').text('Update');

        }

    }
    if (id) {
        loadfishReceiveParamSetting(id)
    }

}
function loadfishReceiveParamSetting(id) {
    $.ajax({
        type: "GET",
        url: "/sf/fishReceiveParamSettingsConfigure/loadfishReceiveParamSetting/" + id,
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

                $('#CompanyID').val(data.CompanyID);
                $('#paramName').val(data.paramName);
                $('#FishSpeciesID').val(data.FishSpeciesID);
                $('#QParamID').val(data.QParamID);
                $('#MinValue').val(data.MinValue);
                $('#MaxVal').val(data.MaxVal);
                $('#list_index').val(data.list_index);
                $('#DefaultVal').val(data.DefaultVal);
                $('#FishPrasentationID').val(data.FishPrasentationID);

                if (data.enabled) {
                    $("#enabled").prop("checked", true);
                }
                else {
                    $("#enabled").prop("checked", false);
                }

                $('#btnSave').text('Update');
                $('#btnClear').show();


                loadRelatedParam();

            }

        },
        error: function (error) {
            console.log(error);

        },
        complete: function () {

        }

    });
}
function loadFishSpecies() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishReceiveParamSettingsConfigure/loadFishSpecies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                $('#FishSpeciesID').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadCompanies() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishReceiveParamSettingsConfigure/loadCompanies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.companyName + ' </option>';
                });
                $('#CompanyID').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadFishPrasentation() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishReceiveParamSettingsConfigure/loadFishPrasentation',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.PrsntName + ' </option>';
                });
                $('#FishPrasentationID').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadQParamID() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishReceiveParamSettingsConfigure/loadQParamID',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.QParamName + ' </option>';
                });
                $('#QParamID').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadMinMaxValue(id) {
    $.ajax({
        type: 'GET',
        url: '/sf/fishReceiveParamSettingsConfigure/loadMinMaxValue/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result;
                $('#MinValue').val(data.MinValue);
                $('#MaxVal').val(data.MaxValue);




            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadRelatedParam() {
    var CompanyID = $('#CompanyID').val();
    var FishSpeciesID = $('#FishSpeciesID').val();
    var FishPrasentationID = $('#FishPrasentationID').val();

    if (CompanyID != '' && FishSpeciesID != '' && FishPrasentationID != '') {
        $.ajax({
            type: "POST",
            url: "/sf/fishReceiveParamSettingsConfigure/loadRelatedParam",
            data: { CompanyID: CompanyID, FishSpeciesID: FishSpeciesID, FishPrasentationID: FishPrasentationID },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (response) {
                console.log(response)
                if (response.success) {

                    var data = [];
                    for (i = 0; i < response.result.length; i++) {
                        var id = response.result[i]['id'];
                        var paramName = response.result[i]['paramName'];
                        var QParamName = response.result[i]['QParamName'];
                        var list_index = response.result[i]['list_index'];
                        var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                        var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                        data.push({
                            "thId": id,
                            "thfishReceiveParamSettings": paramName,
                            "thQParam": QParamName,
                            "index": list_index,
                            "action": edit + dele,
                        });
                    }

                    var table = $('#tablefishReceiveParamSettings').DataTable();
                    table.clear();
                    table.rows.add(data).draw();
                }
            }, error: function (data) {
                console.log(data);
                console.log('something went wrong');
            }
        });
    }

}
function checkDefaultValuRange(Default) {
    var min = $('#MinValue').val();
    var max = $('#MaxVal').val();
    if (Number(min) > Number(Default)) {

        toastr.error('Default value is lover than min Value');
        var max = $('#DefaultVal').val('');

        $('#DefaultVal')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#DefaultVal')[0].style.border = '';
        }, 4000);
    }
    else if (Number(max) < Number(Default)) {

        toastr.error('Default value is Heigher than Max Value');
        var max = $('#DefaultVal').val('');

        $('#DefaultVal')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#DefaultVal')[0].style.border = '';
        }, 4000);
    }

}
function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/sf/fishReceiveParamSettings/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadRelatedParam();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
function edit(id) {
    loadfishReceiveParamSetting(id)
}

console.log('qualityRuleParametersConfigure .js loadimng');
var parent_url = '/quality/qualityRuleParameters_list'
$(document).ready(function () {

    $('#btnClear').hide();

    var table = $('#tablequalityRuleParameters').DataTable({
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
            { "data": "thqualityRuleParameters", 'width': "26.6%" },
            { "data": "thQParam", 'width': "26.6%" },
            { "data": "action", 'width': "26.6%" },
        ],
    });

    $('#btnSave').on('click', function () {
        var form = $('#frmqualityRuleParametersConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }
    });

    $('#btnClear').click(function () {
        $('#frmqualityRuleParametersConfigure ').trigger("reset");
        $('#btnSave').html('Save')
        $('#btnClear').hide();
    });


    $('#QualityRuleID').change(function () {
        loadRelatedParam();
    });
    $('#QParameterId').change(function () {
        loadMinMaxValue(this.value);

    });

    $('#DefaultValue').change(function () {
        checkDefaultValuRange(this.value)
    });
    $('#MinValue').change(function () {
        checkMinMaxRang();
    });
    $('#MaxValue').change(function () {
        checkMinMaxRang();
    });
    loadQParameterId();
    loadQualityRuleID();

    CheckUrlParameter();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/quality/qualityRuleParametersConfigure/save",
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
                $('#QParameterId').prop('selectedIndex', 0);
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
        url: "/quality/qualityRuleParametersConfigure/update",
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
                $('#frmqualityRuleParametersConfigure ').trigger("reset");
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
        loadQualityRuleParameter(id)
    }

}
function loadQualityRuleParameter(id) {
    $.ajax({
        type: "GET",
        url: "/quality/qualityRuleParametersConfigure/loadQualityRuleParameter/" + id,
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

                $('#QualityRuleID').val(data.QualityRuleID);
                $('#QParameterId').val(data.QParameterId);
                $('#QParamName').val(data.QParamName);
                $('#QParamDescription').val(data.QParamDescription);
                $('#MinValue').val(data.MinValue);
                $('#MaxValue').val(data.MaxValue);
                $('#DefaultValue').val(data.DefaultValue);
                $('#status_value_comment').val(data.status_value_comment);

                if (data.is_status_value_required) {
                    $("#is_status_value_required").prop("checked", true);
                }
                if (data.is_status_value_number) {
                    $("#is_status_value_number").prop("checked", true);
                }
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



function loadQParameterId() {
    $.ajax({
        type: 'GET',
        url: '/quality/qualityRuleParametersConfigure/loadQParameterId',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.QParamName + ' </option>';
                });
                $('#QParameterId').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadQualityRuleID() {
    $.ajax({
        type: 'GET',
        url: '/quality/qualityRuleParametersConfigure/loadQualityRuleID',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.QualityRuleName + ' </option>';
                });
                $('#QualityRuleID').append(html);


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
        url: '/quality/qualityRuleParametersConfigure/loadMinMaxValue/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result;
                $('#MinValue').val(data.MinValue);
                $('#MaxValue').val(data.MaxValue);
                $('#QParamName').val(data.QParamName)
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadRelatedParam() {
    var QualityRuleID = $('#QualityRuleID').val();

    if (QualityRuleID != '' && QParameterId != '') {
        $.ajax({
            type: "POST",
            url: "/quality/qualityRuleParametersConfigure/loadRelatedParam",
            data: { QualityRuleID: QualityRuleID },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (response) {
                console.log(response)
                if (response.success) {

                    var data = [];
                    for (i = 0; i < response.result.length; i++) {
                        var id = response.result[i]['id'];
                        var QParamName = response.result[i]['QParamName'];
                        var qparameter = response.result[i]['qparameter'];
                        var list_index = response.result[i]['list_index'];
                        var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                        var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                        data.push({
                            "thId": id,
                            "thqualityRuleParameters": QParamName,
                            "thQParam": qparameter,
                            "index": list_index,
                            "action": edit + dele,
                        });
                    }

                    var table = $('#tablequalityRuleParameters').DataTable();
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
    var max = $('#MaxValue').val();
    if (Number(min) > Number(Default)) {

        toastr.error('Default value is lover than min Value');
        var max = $('#DefaultValue').val('');

        $('#DefaultValue')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#DefaultValue')[0].style.border = '';
        }, 4000);
    }
    else if (Number(max) < Number(Default)) {

        toastr.error('Default value is Heigher than Max Value');
        var max = $('#DefaultValue').val('');

        $('#DefaultValue')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#DefaultValue')[0].style.border = '';
        }, 4000);
    }

}


function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/quality/qualityRuleParameters/delete/' + id,
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
    loadQualityRuleParameter(id)
}
function checkMinMaxRang() {
    var min = $('#MinValue').val();
    var max = $('#MaxValue').val();

    if (min != '' && max != '' && Number(min) > Number(max)) {
        toastr.error('Min valu Is Heigher than Max value');
        $('#MinValue').val('');
        $('#MaxValue').val('');

        $('#MaxValue')[0].style.border = '1px solid red';
        $('#MinValue')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#MaxValue')[0].style.border = '';
            $('#MinValue')[0].style.border = '';

        }, 4000);
    }

}

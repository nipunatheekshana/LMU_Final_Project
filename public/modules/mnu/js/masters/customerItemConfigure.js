console.log('customerItemConfigure .js loadimng');
var parent_url = '/mnu/customerItem_list'
$(document).ready(function () {

    $('#innerItemList').hide();

    $('#btnSave').on('click', function () {
        var form = $('#frmcustomerItemConfigure ').get(0);
        var data = new FormData(form);
        var parameterArr = InitiateParametersArry();

        for (var i = 0; i < parameterArr.length; i++) {
            data.append('arr[]', JSON.stringify(parameterArr[i]));
        }

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });
    $('#itemType').change(function () {
        if (this.value == 'Inner_Bom') {
            loadItems('inner');
            $('#innerItemList').hide();
            loadMasterLableParameters('inner')
        }
        else if (this.value == 'Outer_Bom') {
            loadItems('outter');
            $('#innerItemList').show();
            loadMasterLableParameters('outter')
        }
        else {
            loadItems('all');
        }
    });
    $('#item').change(function () {
        loadNumberOfLables(this.value)
    });
    $('#btnResetParameters').click(function () {
        var itemType = $('#itemType').val();
        if (itemType == 'Inner_Bom') {
            loadMasterLableParameters('inner')
        }
        else if (itemType == 'Outer_Bom') {
            loadMasterLableParameters('outter')
        }
    });
    $('#btnSaveDataTypeFormat').click(function () {
        var paraId = $('#paraId').val();
        var format = $('#format').val();

        $('#format_' + paraId).val(format);
        $('#paraId').val('');
        $('#format').val('');
        $('#DataTypeFormatModel').modal('toggle');
        $('#format').html('<option value="">-Select-</option>');

    });

    var table = $('#tableParameterList').DataTable({
        responsive: true,
        paging: false,
        "searching": false,
        'columnDefs': [
            {
                "targets": [6, 7, 8, 9, 10],
                "visible": false,
            },
            {
                "targets": [0, 1, 2, 3, 4, 5],
                "className": "text-center",
            }
        ],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thParameter", 'width': "18%" },
            { "data": "thDiscription", 'width': "18%" },
            { "data": "thDataType", 'width': "18%" },
            { "data": "thFormat", 'width': "18%" },
            { "data": "thSampledata", 'width': "18%" },
            { "data": "label_format_id", 'width': "18%" },
            { "data": "script_field", 'width': "18%" },
            { "data": "script_tabel", 'width': "18%" },
            { "data": "script_conditions", 'width': "18%" },
            { "data": "data_type", 'width': "18%" },

        ],
    });

    loadCustomers();
    loadPrinters();
    loadItems('all');
    loadCustomerItem();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/mnu/customerItemConfigure/save",
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
                $('#frmcustomerItemConfigure ').trigger("reset");
                // location.href = parent_url;

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
        url: "/mnu/customerItemConfigure/update",
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
                $('#frmcustomerItemConfigure ').trigger("reset");
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
function loadCustomerItem() {

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
            url: "/mnu/customerItemConfigure/loadCustomerItem/" + id,
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
                    var data = response.result.CustomerItem;

                    $('#hiddenId').val(data.id);

                    $('#customer').val(data.customer);
                    $('#item').val(data.item);
                    $('#lbl_prodname1').val(data.lbl_prodname1);
                    $('#lbl_prodname2').val(data.lbl_prodname2);
                    $('#lbl_prodname3').val(data.lbl_prodname3);
                    $('#pl_prodname1').val(data.pl_prodname1);
                    $('#pl_prodname2').val(data.pl_prodname2);
                    $('#pl_summary_name').val(data.pl_summary_name);
                    $('#pl_short_name').val(data.pl_short_name);
                    $('#in_prodname1').val(data.in_prodname1);
                    $('#in_prodname2').val(data.in_prodname2);
                    $('#in_short_name').val(data.in_short_name);
                    $('#ot_prodname1').val(data.ot_prodname1);
                    $('#ot_prodname2').val(data.ot_prodname2);
                    $('#ot_short_name').val(data.ot_short_name);
                    $('#gtin_no').val(data.gtin_no);
                    $('#ean13_no').val(data.ean13_no);
                    $('#cus_prod_code_1').val(data.cus_prod_code_1);
                    $('#cus_prod_code_2').val(data.cus_prod_code_2);
                    $('#default_printer').val(data.default_printer);
                    $('#numOfLables').val(data.numOfLables);



                    loadCustomerItemParameters(response.result.CustomerItemParameter);
                    loadNumberOfLables(data.item);
                    if (data.is_sale_item) {
                        $("#is_sale_item").prop("checked", true);
                    }
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
function loadCustomers() {
    $.ajax({
        type: 'GET',
        url: '/mnu/customerItemConfigure/loadCustomers',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.CusName + ' </option>';
                });
                $('#customer').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadPrinters() {
    $.ajax({
        type: 'GET',
        url: '/mnu/customerItemConfigure/loadPrinters',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.printer_name + ' </option>';
                });
                $('#default_printer').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadItems(type) {
    $.ajax({
        type: 'GET',
        url: '/mnu/customerItemConfigure/loadItems/' + type,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';

                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.item_name + ' </option>';
                });
                $('#item').html(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function coppyTOClipBoard(text) {
    try {
        navigator.clipboard.writeText(text);

        toastr.success("Copied the Parameter: " + text);
    } catch (err) {
        console.log(err);
    }

}
function loadMasterLableParameters(itemType) {
    $.ajax({
        type: 'GET',
        url: '/mnu/customerItemConfigure/loadMasterLableParameters/' + itemType,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var parameter = response.result[i]['parameter'];
                    var parameter_description = response.result[i]['parameter_description'];
                    var data_type = response.result[i]['data_type'];
                    var format = response.result[i]['format'];
                    var sample_data = response.result[i]['sample_data'];
                    var label_format_id = response.result[i]['label_format_id'];
                    var script_field = response.result[i]['script_field'];
                    var script_tabel = response.result[i]['script_tabel'];
                    var script_conditions = response.result[i]['script_conditions'];
                    var DataTypeName = response.result[i]['DataTypeName'];
                    var formatEl = ''
                    if (DataTypeName == 'Text') {
                        formatEl = '<input type="hidden"  value="' + format + '" readonly>';
                    } else {
                        formatEl = '<input type="text" id="format_' + id + '" onclick="loadDataTypeFormats(' + data_type + ',' + id + ')"  value="' + format + '">';
                    }

                    data.push({
                        "thId": id,
                        "thParameter": parameter,
                        "thDiscription": parameter_description,
                        "thDataType": DataTypeName,
                        "thFormat": formatEl,
                        "thSampledata": '<input type="text" value="' + sample_data + '">',
                        "label_format_id": label_format_id,
                        "script_field": script_field,
                        "script_tabel": script_tabel,
                        "script_conditions": script_conditions,
                        'data_type': data_type
                    });
                }

                var table = $('#tableParameterList').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
};
function InitiateParametersArry() {

    var table = $('#tableParameterList').DataTable();

    var arr = [];

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        arr.push({
            'id': data.thId,
            'parameter': data.thParameter,
            'parameter_description': data.thDiscription,
            'data_type': data.data_type,
            'format': this.cell(rowIdx, 4).nodes().to$().find('input').val(),
            'sample_data': this.cell(rowIdx, 5).nodes().to$().find('input').val(),
            'label_format_id': data.label_format_id,
            'script_field': data.script_field,
            'script_tabel': data.script_tabel,
            'script_conditions': data.script_conditions,

        });
    });
    console.log(arr)

    return arr

}
function loadDataTypeFormats(dataType, paraId) {
    $.ajax({
        type: 'GET',
        url: '/mnu/customerItemConfigure/loadDataTypeFormats/' + dataType,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.format + '" > ' + value.format + ' </option>';
                });
                $('#format').append(html);

                $('#paraId').val(paraId);
                $('#DataTypeFormatModel').modal('toggle');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });

}
function loadNumberOfLables(ItemId) {
    $.ajax({
        type: 'GET',
        url: '/mnu/customerItemConfigure/loadNumberOfLables/' + ItemId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#numOfLables').val(response.result);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadCustomerItemParameters(parameters) {
    // console.log(data);
    var data = [];

    $.each(parameters, function (index, value) {
        var id = value.id;
        var parameter = value.id;
        var parameter_description = value.parameter_description;
        var data_type = value.data_type;
        var format = value.format;
        var sample_data = value.sample_data;
        var label_format_id = value.label_format_id;
        var script_field = value.script_field;
        var script_tabel = value.script_tabel;
        var script_conditions = value.script_conditions;
        var DataTypeName = value.DataTypeName;
        var formatEl = ''
        if (DataTypeName == 'Text') {
            formatEl = '<input type="hidden"  value="' + format + '" readonly>';
        } else {
            formatEl = '<input type="text" id="format_' + id + '" onclick="loadDataTypeFormats(' + data_type + ',' + id + ')"  value="' + format + '">';
        }

        data.push({
            "thId": id,
            "thParameter": parameter,
            "thDiscription": parameter_description,
            "thDataType": DataTypeName,
            "thFormat": formatEl,
            "thSampledata": '<input type="text" value="' + sample_data + '">',
            "label_format_id": label_format_id,
            "script_field": script_field,
            "script_tabel": script_tabel,
            "script_conditions": script_conditions,
            'data_type': data_type
        });
    });
    var table = $('#tableParameterList').DataTable();
    table.clear();
    table.rows.add(data).draw();
}

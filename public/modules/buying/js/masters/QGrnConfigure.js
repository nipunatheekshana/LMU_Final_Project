console.log('QGrnConfigure .js loadimng');
var parent_url = '/buying/QGrn_list'
$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmQGrnConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });



    loadDropDownData();
    loadQGrn();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/buying/QGrnConfigure/save",
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
                $('#frmQGrnConfigure ').trigger("reset");
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
        url: "/buying/QGrnConfigure/update",
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
                $('#frmQGrnConfigure ').trigger("reset");
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
function loadDropDownData() {
    $.ajax({
        type: 'GET',
        url: '/buying/QGrnConfigure/loadDropDownData',
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var dropdownData = {
                    Supplier: { elementID: '#supplier_id', key: 'supplier_name' },
                    GrnTicket: { elementID: '#supplier_ticket_id', key: 'ticket_no' },
                    Boat: { elementID: '#boat_id', key: 'BoatName' },
                    FishCoolingMethod: { elementID: '#boat_cooling_method', key: 'MethodName' },
                    CatchMethod: { elementID: '#boat_fishing_method_id', key: 'CatchMethodName' },
                    Landingsite: { elementID: '#boat_landing_site_id', key: 'LandingSiteName' },
                    financeUser: { elementID: '#finance_close_user_id', key: 'name' },
                    unloadUser: { elementID: '#unload_end_user_id', key: 'name' },
                    payCurrency: { elementID: '#finance_currency_id_pay', key: 'currency_name' },
                    baseCurrency: { elementID: '#finance_currency_id_base', key: 'currency_name' }

                };

                $.each(dropdownData, function (dataKey, dataValue) {
                    var options = '';
                    options += '<option value="">-Select-</option>';

                    $.each(response.result[dataKey], function (index, value) {
                        options += '<option value="' + value.id + '">' + value[dataValue.key] + '</option>';
                    });
                    $(dataValue.elementID).append(options);
                });
            }
        },
        error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function loadQGrn() {

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
            url: "/buying/QGrnConfigure/loadQGrn/" + id,
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

                    $('#qgrn_no').val(data.qgrn_no);
                    $('#qgrn_date').val(data.qgrn_date);
                    $('#qgrn_type').val(data.qgrn_type);
                    $('#batch_no').val(data.batch_no);
                    $('#supplier_id').val(data.supplier_id);
                    $('#supplier_ticket_id').val(data.supplier_ticket_id);
                    $('#supplier_vehicle_no').val(data.supplier_vehicle_no);
                    $('#boat_id').val(data.boat_id);
                    $('#boat_registration_number').val(data.boat_registration_number);
                    $('#boat_licence_no').val(data.boat_licence_no);
                    $('#boat_licence_exp_date').val(data.boat_licence_exp_date);
                    $('#boat_skipper_name').val(data.boat_skipper_name);
                    $('#boat_number_of_crew').val(data.boat_number_of_crew);
                    $('#boat_number_of_tanks').val(data.boat_number_of_tanks);
                    $('#boat_trip_start_date').val(data.boat_trip_start_date);
                    $('#boat_trip_end_date').val(data.boat_trip_end_date);
                    $('#boat_cooling_method').val(data.boat_cooling_method);
                    $('#boat_fishing_method_id').val(data.boat_fishing_method_id);
                    $('#boat_landing_site_id').val(data.boat_landing_site_id);
                    $('#unload_status').val(data.unload_status);
                    $('#unload_start_time').val(data.unload_start_time);
                    $('#unload_end_time').val(data.unload_end_time);
                    $('#unload_end_user_id').val(data.unload_end_user_id);
                    $('#finance_status').val(data.finance_status);
                    $('#voucher_status').val(data.voucher_status);
                    $('#finance_close_time').val(data.finance_close_time);
                    $('#finance_close_user_id').val(data.finance_close_user_id);
                    $('#finance_currency_id_pay').val(data.finance_currency_id_pay);
                    $('#finance_gross_value_pay').val(data.finance_gross_value_pay);
                    $('#finance_currency_id_base').val(data.finance_currency_id_base);
                    $('#finance_gross_value_base').val(data.finance_gross_value_base);
                    $('#costing_export_income').val(data.costing_export_income);
                    $('#costing_localsale_income').val(data.costing_localsale_income);
                    $('#total_qty').val(data.total_qty);
                    $('#total_fish_weight').val(data.total_fish_weight);
                    $('#unprocessed_pcs').val(data.unprocessed_pcs);
                    $('#processed_pcs').val(data.processed_pcs);
                    $('#transfer_pcs').val(data.transfer_pcs);
                    $('#reject_pcs').val(data.reject_pcs);
                    $('#receive_hold_reason').val(data.receive_hold_reason);
                    $('#finance_close_reason').val(data.finance_close_reason);
                    $('#voucher_close_reason').val(data.voucher_close_reason);



                    // if (data.isInternal) {
                    //     $("#isInternal").prop("checked", true);
                    // }
                    // if (data.enabled) {
                    //     $("#enabled").prop("checked", true);
                    // }
                    // else {
                    //     $("#enabled").prop("checked", false);
                    // }

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

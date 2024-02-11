console.log('vehicleConfigure .js loadimng');
var parent_url = '/settings/vehicle_list'
$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmvehicleConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });



    loadDropdownData();
    loadVehicle();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/settings/vehicleConfigure/save",
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
                $('#frmvehicleConfigure ').trigger("reset");
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
        url: "/settings/vehicleConfigure/update",
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
                $('#frmvehicleConfigure ').trigger("reset");
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
function loadDropdownData() {
    $.ajax({
        type: 'GET',
        url: '/settings/vehicleConfigure/loadDropdownData',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var VehicleType=response.result.VehicleType
                ,Employee=response.result.Employee
                ,employees
                ,vehicleTypes;
                $.each(Employee, function (index, value) {

                    employees += '<option value="' + value.id + '" > ' + value.employee_name + ' </option>';
                });
                $.each(VehicleType, function (index, value) {

                    vehicleTypes += '<option value="' + value.id + '" > ' + value.VehicleTypeName + ' </option>';
                });
                $('#default_driver').append(employees);
                $('#type').append(vehicleTypes);



            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function loadVehicle() {

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
            url: "/settings/vehicleConfigure/loadVehicle/" + id,
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

                    $('#license_plate').val(data.license_plate);
                    $('#make').val(data.make);
                    $('#model').val(data.model);
                    $('#engine_no').val(data.engine_no);
                    $('#chassis_no').val(data.chassis_no);
                    $('#fuel_type').val(data.fuel_type);
                    $('#acquisition_date').val(data.acquisition_date);
                    $('#acquisition_value').val(data.acquisition_value);
                    $('#ownership').val(data.ownership);
                    $('#type').val(data.type);
                    $('#last_odometer_value').val(data.last_odometer_value);
                    $('#last_odometer_date_time').val(data.last_odometer_date_time);
                    $('#location').val(data.location);
                    $('#default_driver').val(data.default_driver);
                    $('#insuarance_policy_no').val(data.insuarance_policy_no);
                    $('#insuarance_company').val(data.insuarance_company);
                    $('#insuarance_valid_till').val(data.insuarance_valid_till);
                    $('#revenue_licence_no').val(data.revenue_licence_no);
                    $('#revenue_licence_valid_till').val(data.revenue_licence_valid_till);
                    $('#emission_test_no').val(data.emission_test_no);
                    $('#emission_test_company').val(data.emission_test_company);
                    $('#emission_test_valid_till').val(data.emission_test_valid_till);
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

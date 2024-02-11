console.log('warehouseConfigure .js loadimng');
var parent_url = '/inventory/warehouse_list'
$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmwarehouseConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });
    loadDropDownData();
    loadWarehouse();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/inventory/warehouseConfigure/save",
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
                $('#frmwarehouseConfigure ').trigger("reset");
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
        url: "/inventory/warehouseConfigure/update",
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
                $('#frmwarehouseConfigure ').trigger("reset");
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


function loadWarehouse() {

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
            url: "/inventory/warehouseConfigure/loadWarehouse/" + id,
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

                    $('#warehouse_name').val(data.warehouse_name);
                    $('#warehouse_type').val(data.warehouse_type);
                    $('#parent_warehouse').val(data.parent_warehouse);
                    $('#warehouse_address_1').val(data.warehouse_address_1);
                    $('#warehouse_address_2').val(data.warehouse_address_2);
                    $('#warehouse_city').val(data.warehouse_city);
                    $('#warehouse_state').val(data.warehouse_state);
                    $('#warehouse_country').val(data.warehouse_country);
                    $('#warehouse_email').val(data.warehouse_email);
                    $('#warehouse_phone').val(data.warehouse_phone);
                    $('#default_intransit_warehouse').val(data.default_intransit_warehouse);
                    $('#default_account').val(data.default_account);
                    if (data.is_group) {
                        $("#is_group").prop("checked", true);
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
function loadDropDownData() {
    $.ajax({
        type: 'GET',
        url: '/inventory/warehouseConfigure/loadDropDownData',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var WarehouseType =response.result.WarehouseType
                , Warehouse =response.result.Warehouse
                , WarehouseGroup =response.result.WarehouseGroup
                , Country =response.result.Country
                ,WarehouseTypes
                ,Warehouses
                ,WarehouseGroups
                ,Countries;

                $.each(WarehouseType, function (index, value) {
                    WarehouseTypes += '<option value="' + value.id + '" > ' + value.warehouse_type_name +' </option>';
                });
                $.each(Warehouse, function (index, value) {
                    Warehouses += '<option value="' + value.id + '" > ' + value.warehouse_name + ' </option>';
                });
                $.each(WarehouseGroup, function (index, value) {
                    WarehouseGroups += '<option value="' + value.id + '" > ' + value.warehouse_name + ' </option>';
                });
                $.each(Country, function (index, value) {
                    Countries += '<option value="' + value.id + '" > ' + value.country_name + ' </option>';
                });
                $('#warehouse_type').append(WarehouseTypes);
                $('#default_intransit_warehouse').append(Warehouses);
                $('#parent_warehouse').append(WarehouseGroups);
                $('#warehouse_country').append(Countries);



            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

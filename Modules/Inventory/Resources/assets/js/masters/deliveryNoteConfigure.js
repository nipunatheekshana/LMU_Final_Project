console.log('deliveryNoteConfigure .js loadimng');
var parent_url = '/inventory/delivery_list'
$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmdeliveryNoteConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });



    loadDropDownData();
    loadDeliveryNote();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/inventory/deliveryNoteConfigure/save",
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
                $('#frmdeliveryNoteConfigure ').trigger("reset");
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
        url: "/inventory/deliveryNoteConfigure/update",
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
                $('#frmdeliveryNoteConfigure ').trigger("reset");
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
        url: '/inventory/deliveryNoteConfigure/loadDropDownData',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var DeliveryTrip =response.result.DeliveryTrip
                , Customer =response.result.Customer
                ,Customers
                ,DeliveryTrips;
                $.each(DeliveryTrip, function (index, value) {
                    DeliveryTrips += '<option value="' + value.id + '" > ' + value.employee_name + '-'+value.license_plate+' </option>';
                });
                $.each(Customer, function (index, value) {
                    Customers += '<option value="' + value.id + '" > ' + value.CusName + ' </option>';
                });
                $('#delivery_trip_id').append(DeliveryTrips);
                $('#customer').append(Customers);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function loadDeliveryNote() {

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
            url: "/inventory/deliveryNoteConfigure/loadDeliveryNote/" + id,
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

                    $('#delivery_note_no').val(data.delivery_note_no);
                    $('#delivery_trip_id').val(data.delivery_trip_id);
                    $('#customer').val(data.customer);
                    $('#date').val(data.date);
                    $('#total_qty').val(data.total_qty);
                    $('#total_gross_weight').val(data.total_gross_weight);

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

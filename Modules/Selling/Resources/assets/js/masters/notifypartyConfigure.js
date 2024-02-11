console.log('notifypartyConfigure.js loading');
var parent_url = '/selling/notifyparty_list';
$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmaddressConfigure').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });

    $('#Longitude').change(function () {
        longlat();
    });
    $('#Latitude').change(function () {
        longlat();
    });

    loadCountries();
    loadAddressType();
    loadAddress();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/selling/notifypartyConfigure/save",
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
                $('#frmaddressConfigure').trigger("reset");
                parent_url = response.result;

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
        url: "/selling/notifypartyConfigure/update",
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
                $('#frmaddressConfigure').trigger("reset");
                parent_url = response.result;
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
function loadCountries() {
    $.ajax({
        type: 'GET',
        url: '/selling/notifypartyConfigure/loadCountries',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.country_name + ' </option>';
                });
                $('#Country').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadAddressType() {
    $.ajax({
        type: 'GET',
        url: '/selling/notifypartyConfigure/loadAddressType',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.AddressType + ' </option>';
                });
                $('#AddressType').append(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadAddress() {

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
            url: "/selling/notifypartyConfigure/loadAddress/" + id,
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

                    $('#AddressTitle').val(data.AddressTitle);
                    $('#emailAddress').val(data.emailAddress);
                    $('#Phone').val(data.Phone);
                    $('#Fax').val(data.Fax);
                    $('#Longitude').val(data.Longitude);
                    $('#LongLat').val(data.LongLat);
                    $('#Latitude').val(data.Latitude);
                    $('#AddressType').val(data.AddressType);
                    $('#Addressline1').val(data.Addressline1);
                    $('#Addressline2').val(data.Addressline2);
                    $('#CityTown').val(data.CityTown);
                    $('#Country').val(data.Country);
                    $('#PostalCode').val(data.PostalCode);
                    $('#list_index').val(data.list_index);
                    if (data.PreferedBillingAddress) {
                        $("#PreferedBillingAddress").prop("checked", true);
                    }
                    if (data.PreferedShippingAddress) {
                        $("#PreferedShippingAddress").prop("checked", true);
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
function longlat() {
    var long = $('#Longitude').val();
    var lat = $('#Latitude').val();
    var longLat = long + ',' + lat;
    $('#LongLat').val(longLat);
}

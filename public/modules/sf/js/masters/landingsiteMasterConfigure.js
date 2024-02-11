console.log('landingsiteMasterConfigure .js loadimng');
var parent_url = '/sf/landingsiteMaster_list'
$(document).ready(function () {

    $('#landingSiteImageLarge').hide();
    $('#btnDeleteImage').hide();


    $('#btnSave').on('click', function () {
        var form = $('#frmlandingsiteMaster ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });
    $('.image-popup').magnificPopup({
        type: 'image',
        zoom: {
            enabled: true,
            duration: 300,
            easing: 'ease-in-out',
            opener: function (openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });

    $('#btnDeleteImage').click(function () {
        var id = $('#hiddenId').val();
        $.ajax({
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/sf/landingsiteMasterConfigure/DeleteImage/' + id,
            success: function (response) {
                console.log(response);

                if (response.success) {
                    toastr.success(response.message);
                    loadlandingsiteMaster();
                }
            }, error: function (data) {
                console.log(data);
            }
        });
    });

    loadCountries();
    loadlandingsiteMaster();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/landingsiteMasterConfigure/save",
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
                $('#frmlandingsiteMasterConfigure ').trigger("reset");
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
        url: "/sf/landingsiteMasterConfigure/update",
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
                $('#frmlandingsiteMasterConfigure ').trigger("reset");
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
        url: '/sf/landingsiteMasterConfigure/loadCountries',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.country_name + ' </option>';
                });
                $('#countryCode').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}


function loadlandingsiteMaster() {

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
            url: "/sf/landingsiteMasterConfigure/loadlandingsiteMaster/" + id,
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

                    if (!data.LandingSiteImage == '') {
                        $('#landingSiteImageLarge').show();
                        $('#btnDeleteImage').show();

                        $("#landingSiteImageSmall").attr("src",  '/storage/' + data.LandingSiteImage);
                        $("#landingSiteImageLarge").attr("href",  '/storage/' +data.LandingSiteImage);
                    }
                    else {
                        $('#landingSiteImageLarge').hide();
                        $('#btnDeleteImage').hide();


                    }

                    $('#id').val(data.id);
                    $('#LandingSiteName').val(data.LandingSiteName);
                    $('#Longitude').val(data.Longitude);
                    $('#Latitude').val(data.Latitude);
                    $('#LongLat').val(data.LongLat);
                    $('#countryCode').val(data.countryCode);


                    $('#hiddenId').val(data.id);
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

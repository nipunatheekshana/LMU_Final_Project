console.log('boatConfigure .js loadimng');
var parent_url = '/sf/boat_list'
$(document).ready(function () {
    $('#buttonDeleteBoatImage').hide();
    $('#buttonDeleteSkipperImage').hide();
    $('#buttonDeleteLicenceImage').hide();
    $('#holdReasonContainer').hide();

    $('#btnSave').click(function () {
        var form = $('#frmboatConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }
    });

    $('#buttonDeleteBoatImage').click(function(){
        deleteImage('boat');
    });
    $('#buttonDeleteSkipperImage').click(function(){
        deleteImage('signature');
    });
    $('#buttonDeleteLicenceImage').click(function(){
        deleteImage('licence');
    });

    $('#BoatHold').change(function () {
        if (this.checked) {
            $('#holdReasonContainer').show();
        } else {
            $('#holdReasonContainer').hide();
        }
    });


    loadBoatCategories();
    loadBoatHoldReason();
    loadCountries();
    loadboat();


});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/boatConfigure/save",
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
                $('#frmboatConfigure ').trigger("reset");
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
        url: "/sf/boatConfigure/update",
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
                $('#frmboatConfigure ').trigger("reset");
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
function loadboat() {

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
            url: "/sf/boatConfigure/loadboat/" + id,
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

                    if (!data.boatImg == '') {
                        $("#boatImgBox").attr("src",  '/storage/' +  data.boatImg);
                        $('#buttonDeleteBoatImage').show();
                    }
                    if (!data.skipperSign == '') {
                        $("#skipperSignBox").attr("src",  '/storage/' +  data.skipperSign);
                        $('#buttonDeleteSkipperImage').show();
                    }
                    if (!data.licenceImage == '') {
                        $("#licenceImageBox").attr("src",  '/storage/' +  data.licenceImage);
                        $('#buttonDeleteLicenceImage').show();
                    }

                    $('#hiddenId').val(data.id);

                    $('#BoatID').val(data.BoatID);
                    $('#BoatRegNo').val(data.BoatRegNo);
                    $('#BoatCode').val(data.BoatCode);
                    $('#RegCountry').val(data.RegCountry);
                    $('#BoatName').val(data.BoatName);
                    $('#BoatShortName').val(data.BoatShortName);
                    $('#Call_Sign').val(data.Call_Sign);
                    $('#BoatCategory').val(data.BoatCategory);
                    $('#BoatLength').val(data.BoatLength);
                    $('#EngineCapacity').val(data.EngineCapacity);
                    $('#BoatWeight').val(data.BoatWeight);
                    $('#LicenseNo').val(data.LicenseNo);
                    $('#LicenseExpDate').val(data.LicenseExpDate);
                    $('#OwnerName').val(data.OwnerName);
                    $('#SkipperName').val(data.SkipperName);
                    $('#NoofTanks').val(data.NoofTanks);
                    $('#NoofCrew').val(data.NoofCrew);
                    $('#HoldReason').val(data.HoldReason);
                    $('#list_index').val(data.list_index);
                    if (data.LicenseRequired) {
                        $("#LicenseRequired").prop("checked", true);
                    }
                    if (data.LogSheetRequired) {
                        $("#LogSheetRequired").prop("checked", true);
                    }
                    if (data.BoatHold) {
                        $("#BoatHold").prop("checked", true);
                    }
                    if (data.enabled) {
                        $("#enabled").prop("checked", true);
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
function loadCountries() {
    $.ajax({
        type: 'GET',
        url: '/sf/boatConfigure/loadCountries',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.country_name + ' </option>';
                });
                $('#RegCountry').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadBoatCategories() {
    $.ajax({
        type: 'GET',
        url: '/sf/boatConfigure/loadBoatCategories',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.BoatCatName + ' </option>';
                });
                $('#BoatCategory').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadBoatHoldReason() {
    $.ajax({
        type: 'GET',
        url: '/sf/boatConfigure/loadBoatHoldReason',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.HoldTypeName + ' </option>';
                });
                $('#HoldReason').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function deleteImage(img) {
    var id = $('#hiddenId').val();

    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/sf/boatConfigure/deleteImage/' + id + '/' + img,
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.error('Image Deleted')
                switch (img) {
                    case 'boat':
                        $("#boatImgBox").attr("src", "../../assets/media/image/portfolio-six.jpg");
                        $('#buttonDeleteBoatImage').hide();
                        break;
                    case 'signature':
                        $("#skipperSignBox").attr("src", "../../assets/media/image/portfolio-six.jpg");
                        $('#buttonDeleteSkipperImage').hide();
                        break;
                    case 'licence':
                        $("#licenceImageBox").attr("src", "../../assets/media/image/portfolio-six.jpg");
                        $('#buttonDeleteLicenceImage').hide();
                        break;

                    default:
                        break;
                }

            }
        }, error: function (data) {
            console.log(data);
        }
    });
}

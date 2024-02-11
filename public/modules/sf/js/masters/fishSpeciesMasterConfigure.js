console.log('fishSpeciesMasterConfigure .js loadimng');
var parent_url = '/sf/fishSpeciesMaster_list'
$(document).ready(function () {
    $('#buttonDeleteImage').hide();

    $('#btnSave').on('click', function () {
        var form = $('#frmfishSpeciesMaster ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });
    $('#buttonDeleteImage').click(function () {
        var id = $('#hiddenId').val();
        deleteImage(id);
    });


    loadUOM();
    loadfishSpeciesMaster();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/fishSpeciesMasterConfigure/save",
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
                $('#frmfishSpeciesMasterConfigure ').trigger("reset");
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
        url: "/sf/fishSpeciesMasterConfigure/update",
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
                $('#frmfishSpeciesMasterConfigure ').trigger("reset");
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


function loadfishSpeciesMaster() {

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
            url: "/sf/fishSpeciesMasterConfigure/loadfishSpeciesMaster/" + id,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            async: false,
            beforeSend: function () {

            },
            success: function (response) {
                console.log(response)
                if (response.success) {
                    var data = response.result;

                    if (!data.img == '') {
                        $("#imageBox").attr("src", '/storage/' + data.img);
                        $('#buttonDeleteImage').show();
                    }
                    $('#FishCode').val(data.FishCode);
                    $('#FishName').val(data.FishName);
                    $('#ScName').val(data.ScName);
                    $('#default_weight_unit').val(data.default_weight_unit);
                    $('#average_weight').val(data.average_weight);

                    $('#ShortName').val(data.ShortName);
                    if (data.BulkMode) {
                        $("#BulkMode").prop("checked", true);
                    }
                    $('#QRiskLevel').val(data.QRiskLevel);
                    $('#hiddenId').val(data.id);

                    $('#currentFishSerialNo').val(data.currentFishSerialNo);
                    $('#minFishSerialNo').val(data.minFishSerialNo);
                    $('#maxFishSerialNo').val(data.maxFishSerialNo);

                    $('#list_index').val(data.list_index);
                    if (data.is_reef_fish) {
                        $("#is_reef_fish").prop("checked", true);
                    }
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
function loadUOM() {
    $.ajax({
        type: 'GET',
        url: '/sf/fishSpeciesMasterConfigure/loadUOM',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.UomName + ' </option>';
                });
                $('#default_weight_unit').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function deleteImage(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/sf/fishSpeciesMasterConfigure/deleteImage/' + id,
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.error('Image Deleted')
                $("#imageBox").attr("src", "../../assets/media/image/portfolio-six.jpg");
                $('#buttonDeleteImage').hide();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

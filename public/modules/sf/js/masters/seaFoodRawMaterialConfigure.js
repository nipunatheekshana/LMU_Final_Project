console.log('seaFoodRawMaterialConfigure .js loadimng');
var parent_url = '/sf/seaFoodRawMaterial_list'
$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmseaFoodRawMaterialConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });

    $('#rm_species').change(function () {
        loadReceiveGrade(this.value);
        loadReceivePresentation(this.value);
        loadDefaultWeightAndUom(this.value)
    });


    loaCompanies()
    loaduom();
    loadFishSpecis();
    loaditemGoup();
    loadseaFoodRawMaterial();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/seaFoodRawMaterialConfigure/save",
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
                // $('#frmseaFoodRawMaterialConfigure ').trigger("reset");
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
        url: "/sf/seaFoodRawMaterialConfigure/update",
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
                $('#frmseaFoodRawMaterialConfigure ').trigger("reset");
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
function loadseaFoodRawMaterial() {

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
            url: "/sf/seaFoodRawMaterialConfigure/loadseaFoodRawMaterial/" + id,
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

                    loadReceiveGrade(data.rm_species);
                    loadReceivePresentation(data.rm_species);

                    $('#Item_Code').val(data.Item_Code);
                    $('#item_name').val(data.item_name);
                    $('#Item_description').val(data.Item_description);
                    $('#rm_species').val(data.rm_species);
                    $('#ReceivePresentation').val(data.ReceivePresentation);
                    $('#ReceiveGrade').val(data.ReceiveGrade);
                    $('#ReceiveSizeVarient').val(data.ReceiveSizeVarient);
                    $('#item_group').val(data.item_group);
                    $('#uom').val(data.stock_uom);
                    $('#weight_uom').val(data.weight_uom);
                    $('#avg_weight_per_unit').val(data.avg_weight_per_unit);
                    $('#uom').val(data.purchase_uom);
                    $('#CompanyID').val(data.CompanyID);

                    $('#list_index').val(data.list_index);

                    if (data.is_inspection_required_before_receive) {
                        $("#is_inspection_required_before_receive").prop("checked", true);
                    }
                    if (data.is_inspection_required_before_delivery) {
                        $("#is_inspection_required_before_delivery").prop("checked", true);
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
function loadFishSpecis() {
    $.ajax({
        type: 'GET',
        url: '/sf/seaFoodRawMaterialConfigure/loadFishSpecis',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                $('#rm_species').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadReceivePresentation(id) {
    $.ajax({
        type: 'GET',
        url: '/sf/seaFoodRawMaterialConfigure/loadReceivePresentation/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.PrsntName + ' </option>';
                });
                $('#ReceivePresentation').html(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadReceiveGrade(id) {
    $.ajax({
        type: 'GET',
        url: '/sf/seaFoodRawMaterialConfigure/loadReceiveGrade/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.QFishGrade + ' </option>';
                });
                $('#ReceiveGrade').html(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loaditemGoup() {
    $.ajax({
        type: 'GET',
        url: '/sf/seaFoodRawMaterialConfigure/loaditemGoup',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.GroupName + ' </option>';
                });
                $('#item_group').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loaduom() {
    $.ajax({
        type: 'GET',
        url: '/sf/seaFoodRawMaterialConfigure/loaduom',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.UomName + ' </option>';
                });
                $('#uom').append(html);
                $('#weight_uom').append(html);



            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadDefaultWeightAndUom(id) {
    $.ajax({
        type: 'GET',
        url: '/sf/seaFoodRawMaterialConfigure/loadDefaultWeightAndUom/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#avg_weight_per_unit').val(response.result.average_weight);
                $('#weight_uom').val(response.result.default_weight_unit);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loaCompanies() {
    $.ajax({
        type: 'GET',
        url: '/sf/seaFoodRawMaterialConfigure/loaCompanies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.companyName + ' </option>';
                });
                $('#CompanyID').append(html);



            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

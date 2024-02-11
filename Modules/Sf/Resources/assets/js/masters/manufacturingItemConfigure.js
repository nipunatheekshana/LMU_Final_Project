console.log('manufacturingItemConfigure .js loadimng');
var parent_url = '/sf/manufacturingItem_list'
$(document).ready(function () {
    $('#buttonDeleteImage').hide();


    $('#btnSave').on('click', function () {
        var form = $('#frmmanufacturingItemConfigure ').get(0);
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

    $('#process').change(function () {
        loadProcessWorkstations(this.value);
    });

    $('#buttonDeleteImage').click(function () {
        var id = $('#hiddenId').val();
        deleteImage(id);
    });

    loadProcess();
    loadcompanies();
    loadFishSpecis();
    loadCuttingType();
    loadUom();
    loadItemGroup();
    loadmanufacturingItem();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/manufacturingItemConfigure/save",
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
                $('#frmmanufacturingItemConfigure ').trigger("reset");
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
        url: "/sf/manufacturingItemConfigure/update",
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
                $('#frmmanufacturingItemConfigure ').trigger("reset");
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

function loadmanufacturingItem() {

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
            url: "/sf/manufacturingItemConfigure/loadmanufacturingItem/" + id,
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

                    if (!data.image == '') {
                        $("#imageBox").attr("src", '/storage/' + data.image);
                        $('#buttonDeleteImage').show();
                    }
                    $('#hiddenId').val(data.id);

                    loadReceiveGrade(data.rm_species);
                    loadReceivePresentation(data.rm_species);

                    $('#CompanyID').val(data.CompanyID);
                    $('#Item_Code').val(data.Item_Code);
                    $('#item_name').val(data.item_name);
                    $('#Item_description').val(data.Item_description);
                    $('#rm_species').val(data.rm_species);
                    $('#ProductPresentation').val(data.ProductPresentation);
                    $('#ProductCutType').val(data.ProductCutType);
                    $('#ProductQuality').val(data.ProductQuality);
                    $('#ProductSpec').val(data.ProductSpec);
                    $('#ReceiveGrade').val(data.ReceiveGrade);
                    $('#stock_uom').val(data.stock_uom);
                    $('#avg_weight_per_unit').val(data.avg_weight_per_unit);
                    $('#weight_uom').val(data.weight_uom);
                    $('#item_group').val(data.item_group);
                    $('#process').val(data.process);
                    loadProcessWorkstations(data.process);
                    $('#work_station').val(data.work_station);

                    $('#list_index').val(data.list_index);


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
function loadcompanies() {
    $.ajax({
        type: 'GET',
        url: '/sf/manufacturingItemConfigure/loadcompanies',
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
function loadFishSpecis() {
    $.ajax({
        type: 'GET',
        url: '/sf/manufacturingItemConfigure/loadFishSpecis',
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
        url: '/sf/manufacturingItemConfigure/loadReceivePresentation/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.PrsntName + ' </option>';
                });
                $('#ProductPresentation').html(html);


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
        url: '/sf/manufacturingItemConfigure/loadReceiveGrade/' + id,
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
function loadDefaultWeightAndUom(id) {
    $.ajax({
        type: 'GET',
        url: '/sf/manufacturingItemConfigure/loadDefaultWeightAndUom/' + id,
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


function loadCuttingType() {
    $.ajax({
        type: 'GET',
        url: '/sf/manufacturingItemConfigure/loadCuttingType',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.CutTypeName + ' </option>';
                });
                $('#ProductCutType').append(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadUom() {
    $.ajax({
        type: 'GET',
        url: '/sf/manufacturingItemConfigure/loadUom',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.UomName + ' </option>';
                });
                $('#stock_uom').append(html);
                $('#weight_uom').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadItemGroup() {
    $.ajax({
        type: 'GET',
        url: '/sf/manufacturingItemConfigure/loadItemGroup',
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
function loadProcess() {
    $.ajax({
        type: 'GET',
        url: '/sf/manufacturingItemConfigure/loadProcess',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.ProcessName + ' </option>';
                });
                $('#process').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadProcessWorkstations(ProcessId) {
    $.ajax({
        type: 'GET',
        url: '/sf/manufacturingItemConfigure/loadProcessWorkstations/' + ProcessId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.WorkstationName + ' </option>';
                });
                $('#work_station').html(html);


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
        url: '/sf/manufacturingItemConfigure/deleteImage/' + id,
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

console.log('byproductItemConfigure .js loadimng');
var parent_url = '/sf/byproductItem_list'
$(document).ready(function () {
    $('#btnProcessWorkstation').prop('disabled', true);
    $('#btnPriceList').prop('disabled', true);


    $('#btnSave').on('click', function () {
        var form = $('#frmbyproductItemConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });
    var table = $('#tableProcessWorkStations').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thProcess", 'width': "20%" },
            { "data": "thWorkstation", 'width': "40%" },
            { "data": "action", 'width': "15%" },
        ],
    });
    var tablePrice = $('#tablePrice').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thUom", 'width': "20%" },
            { "data": "thPriceList", 'width': "40%" },
            { "data": "thPrice", 'width': "40%" },
            { "data": "action", 'width': "15%" },
        ],
    });

    $('#rm_species').change(function () {
        loadDefaultWeightAndUom(this.value)
    });
    $('#btnProcessWorkstation').click(function () {
        loadProcessWorkstations()
    });
    $('#modelprocessWorkstationbtnAdd').click(function () {
        saveItemProcessWorkstation()
    });
    $('#btnPriceList').click(function () {
        loadPriceListModleData()
    });
    $('#modelPriceListBtnAdd').click(function () {
        savePriceList()
    });
    loadcompanies();
    loadFishSpecis();
    loadUom();
    loadItemGroup();
    loadbyproductItem();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/sf/byproductItemConfigure/save",
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
                $('#frmbyproductItemConfigure ').trigger("reset");
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
        url: "/sf/byproductItemConfigure/update",
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
                $('#frmbyproductItemConfigure ').trigger("reset");
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

function loadbyproductItem() {

    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
        if (param.length == 2) {
            console.log('view ')
            $('#btnSave').hide();

        } else {
            console.log('edit ');
            $('#btnProcessWorkstation').prop('disabled', false);
            $('#btnPriceList').prop('disabled', false);


            $('#btnSave').text('Update');

        }

    }
    if (id) {
        $.ajax({
            type: "GET",
            url: "/sf/byproductItemConfigure/loadbyproductItem/" + id,
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
                    loadItemProcessWorkstation(data.id)
                    loadItemPrice(data.id)
                    $('#CompanyID').val(data.CompanyID);
                    $('#Item_Code').val(data.Item_Code);
                    $('#item_name').val(data.item_name);
                    $('#Item_description').val(data.Item_description);
                    $('#rm_species').val(data.rm_species);
                    $('#stock_uom').val(data.stock_uom);
                    $('#avg_weight_per_unit').val(data.avg_weight_per_unit);
                    $('#weight_uom').val(data.weight_uom);
                    $('#item_group').val(data.item_group);



                    $('#list_index').val(data.list_index);
                    if (data.is_sales_item) {
                        $("#is_sales_item").prop("checked", true);
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
function loadProcessWorkstations() {
    $.ajax({
        type: 'GET',
        url: '/sf/byproductItemConfigure/loadProcessWorkstations',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -select- </option>';

                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.concatenated_names + ' </option>';
                });
                $('#ProcessWorkstation').html(html);
                $('#modelprocessWorkstation').modal('show');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadcompanies() {
    $.ajax({
        type: 'GET',
        url: '/sf/byproductItemConfigure/loadcompanies',
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
        url: '/sf/byproductItemConfigure/loadFishSpecis',
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

function loadDefaultWeightAndUom(id) {
    $.ajax({
        type: 'GET',
        url: '/sf/byproductItemConfigure/loadDefaultWeightAndUom/' + id,
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
function loadUom() {
    $.ajax({
        type: 'GET',
        url: '/sf/byproductItemConfigure/loadUom',
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
        url: '/sf/byproductItemConfigure/loadItemGroup',
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
function saveItemProcessWorkstation() {
    $.ajax({
        type: 'POST',
        url: '/sf/byproductItemConfigure/saveItemProcessWorkstation',
        data: { 'itemId': $('#hiddenId').val(), 'ProcessWorkStation': $('#ProcessWorkstation').val() },
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response)
            if (response.success) {
                loadItemProcessWorkstation( $('#hiddenId').val());
                $('#modelprocessWorkstation').modal('hide');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadItemProcessWorkstation(itemId) {
    $.ajax({
        type: 'GET',
        url: '/sf/byproductItemConfigure/loadItemProcessWorkstation/' + itemId,
        success: function (response) {
            console.log(response.result);
            if (response.success) {
                var data = response.result.map(item => ({
                    thProcess: item.ProcessName,
                    thWorkstation: item.WorkstationName,
                    action: `<button class="btn btn-danger mr-1" onclick="deleteItemProcessWorkstation(${item.id})"><i class="fa fa-trash" aria-hidden="true"></i></button>`
                }));

                $('#tableProcessWorkStations').DataTable().clear().rows.add(data).draw();
            }
        },
        error: function () {
            console.log('Something went wrong.');
        }
    });
}

function deleteItemProcessWorkstation(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/sf/byproductItemConfigure/deleteItemProcessWorkstation/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadItemProcessWorkstation( $('#hiddenId').val());
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
function loadPriceListModleData() {
    $.ajax({
        type: 'GET',
        url: '/sf/byproductItemConfigure/loadPriceListModleData',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var dropdownData = {
                    PriceList: { elementID: '#price_list', key: 'price_list_name', id: 'id' },
                    UOM: { elementID: '#uom', key: 'UomName', id: 'id' },
                };
                $.each(dropdownData, function (dataKey, dataValue) {
                    var options = '';
                    options += '<option value="">-Select-</option>';

                    $.each(response.result[dataKey], function (index, value) {
                        options += '<option value="' + value[dataValue.id] + '">' + value[dataValue.key] + '</option>';
                    });
                    $(dataValue.elementID).html(options);
                });
                $('#modelPriceList').modal('show');

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function savePriceList() {
    // Validate the data before making the AJAX request
    var itemId = $('#hiddenId').val();
    var priceList = $('#price_list').val();
    var uom = $('#uom').val();
    var price = $('#price').val();

    // Perform data validation
    if (!itemId || !priceList || !uom || !price) {
        toastr.warning('Please fill in all the required fields.')
        return;
    }

    $.ajax({
        type: 'POST',
        url: '/sf/byproductItemConfigure/savePriceList',
        data: {
            'itemId': itemId,
            'pricelist': priceList,
            'uom': uom,
            'price': price
        },
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response)
            if (response.success) {
                loadItemPrice(itemId);
                $('#modelPriceList').modal('hide');
            }
        },
        error: function (data) {
            console.log(data);
            console.log('Something went wrong.');
        }
    });
}
function loadItemPrice(itemId) {
    $.ajax({
        type: 'GET',
        url: '/sf/byproductItemConfigure/loadItemPrice/' + itemId,
        success: function (response) {
            console.log(response.result);
            if (response.success) {
                var data = response.result.map(item => ({
                    thUom: item.UomName,
                    thPriceList: item.price_list_name,
                    thPrice: item.price,
                    action: `<button class="btn btn-danger mr-1" onclick="deleteItemPriceList(${item.id})"><i class="fa fa-trash" aria-hidden="true"></i></button>`
                }));

                $('#tablePrice').DataTable().clear().rows.add(data).draw();
            }
        },
        error: function () {
            console.log('Something went wrong.');
        }
    });
}

function deleteItemPriceList(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/sf/byproductItemConfigure/deleteItemPriceList/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadItemPrice( $('#hiddenId').val());
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

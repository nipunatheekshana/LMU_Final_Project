console.log('ItemConfigure .js loadimng');
var parent_url = '/inventory/Item_list'
$(document).ready(function () {

    $('#barcodeAcordinationRaw').hide();
    $('#SupplierAndManueAcordinationRaw').hide();
    $('#assetAcordinationRaw').hide();
    $('#SerialNumberSeriesRow').hide();
    $('#shelfLifeInDaysRow').hide();
    $('#BatchNumberSeriesRow').hide();





    $('#btnSave').on('click', function () {
        var form = $('#frmItemConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });


    $('#btnBarcodeModel').click(function () {
        $('#BarcodeMOdel').modal('toggle');
    });
    $('#btnSupplierModel').click(function () {
        $('#SupplierModel').modal('toggle');
    });
    $('#btnManufacturer').click(function () {
        $('#ManufacturerModel').modal('toggle');
    });

    $('#btnSaveBarcode').click(function () {
        var form = $('#frmBarcode ').get(0);
        var data = new FormData(form);

        if ($('#btnSaveBarcode').text().trim() == 'Save') {
            saveBarcode(data);
        }
        else {
            updateBarcode(data);
        }

    });
    $('#btnSaveSupplier').click(function () {
        var form = $('#frmSupplier ').get(0);
        var data = new FormData(form);

        if ($('#btnSaveSupplier').text().trim() == 'Save') {
            saveSupplier(data);
        }
        else {
            updateSupplier(data);
        }

    });
    $('#btnSaveManufacturer').click(function () {
        var form = $('#frmManufacturer ').get(0);
        var data = new FormData(form);

        if ($('#btnSaveManufacturer').text().trim() == 'Save') {
            saveManufacturer(data);
        }
        else {
            updateManufacturer(data);
        }

    });
    $('#is_fixed_asset').change(function () {
        if (this.checked) {
            $('#assetAcordinationRaw').show();
        } else {
            $('#assetAcordinationRaw').hide();
        }
    });
    $('#has_serial_no').change(function () {
        if (this.checked) {
            $('#SerialNumberSeriesRow').show();
        } else {
            $('#SerialNumberSeriesRow').hide();
        }
    });
    $('#has_expiry_date').change(function () {
        if (this.checked) {
            $('#shelfLifeInDaysRow').show();
        } else {
            $('#shelfLifeInDaysRow').hide();
        }
    });
    $('#has_batch_no').change(function () {
        if (this.checked) {
            $('#BatchNumberSeriesRow').show();
        } else {
            $('#BatchNumberSeriesRow').hide();
        }
    });

    var table = $('#tableBarcodes').DataTable({
        responsive: true,
        "info": false,
        'columnDefs': [{
            "targets": [0, 1, 2, 3],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thBarcode", 'width': "30%" },
            { "data": "thBarcodeType", 'width': "30%" },
            { "data": "action", 'width': "30%" },
        ],
    });

    var table = $('#tableSuppliers').DataTable({
        responsive: true,
        "info": false,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thsupplier", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });
    var table = $('#tablemanufacturer').DataTable({
        responsive: true,
        "info": false,
        'columnDefs': [{
            "targets": [0, 1, 2],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thmanufacturer", 'width': "40%" },
            { "data": "action", 'width': "40%" },
        ],
    });

    $('#country_of_origin').select2({
        placeholder: 'Select'
    });
    $('#customs_tariff_number').select2({
        placeholder: 'Select'
    });

    loadNamingSeris();
    loadCompanies();
    loadItemGroup();
    loadBrand();
    loadAssetCatagories();
    loadUOM();
    loadDefaultBuyingPriceList();
    loadDefaultsellingPriceList();
    loadDefaultManufacture();
    loadHS_code();
    loadCurrentItems();
    loadQualityRules();
    loadCountries();
    loadItem();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/inventory/ItemConfigure/save",
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
                $('#frmItemConfigure ').trigger("reset");
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
        url: "/inventory/ItemConfigure/update",
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
                $('#frmItemConfigure ').trigger("reset");
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
function loadItem() {

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
            url: "/inventory/ItemConfigure/loadItem/" + id,
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


                    loadBarcodeType();
                    $('#barcodeAcordinationRaw').show();

                    loadSuppliers();
                    $('#SupplierAndManueAcordinationRaw').show();



                    var data = response.result;
                    loadBarcodes(data.id);
                    loadSuppliersTable(data.id);
                    loadManufacturerTable(data.id);

                    $('#hiddenId').val(data.id);
                    $('#ItemIdForBarcode').val(data.id);
                    $('#ItemIdForSupplier').val(data.id);
                    $('#ItemIdForManufacturer').val(data.id);




                    $('#CompanyID').val(data.CompanyID);
                    $('#Item_Code').val(data.Item_Code);
                    $('#item_name').val(data.item_name);
                    $('#Item_description').val(data.Item_description);
                    $('#item_group').val(data.item_group);
                    $('#BrandID').val(data.BrandID);
                    $('#asset_category').val(data.asset_category);
                    $('#asset_item_short_code').val(data.asset_item_short_code);
                    $('#asset_naming_series').val(data.asset_naming_series);
                    $('#opening_stock').val(data.opening_stock);
                    $('#stock_uom').val(data.stock_uom);
                    $('#valuation_rate').val(data.valuation_rate);
                    $('#valuation_method').val(data.valuation_method);
                    $('#standard_rate').val(data.standard_rate);
                    $('#avg_weight_per_unit').val(data.avg_weight_per_unit);
                    $('#weight_uom').val(data.weight_uom);
                    // $('#end_of_life').val(data.end_of_life);
                    $('#default_warranty_period_days').val(data.default_warranty_period_days);
                    $('#default_material_request_type').val(data.default_material_request_type);
                    $('#over_billing_allowance').val(data.over_billing_allowance);
                    $('#over_purchase_receipt_allowance').val(data.over_purchase_receipt_allowance);
                    // $('#over_delivery_receipt_allowance').val(data.over_delivery_receipt_allowance);
                    $('#batch_number_series').val(data.batch_number_series);
                    // $('#serial_no_series').val(data.serial_no_series);
                    // $('#variant_based_on').val(data.variant_based_on);
                    $('#min_order_qty').val(data.min_order_qty);
                    $('#lead_time_days').val(data.lead_time_days);
                    // $('#default_buying_pricelist').val(data.default_buying_pricelist);
                    $('#safety_stock').val(data.safety_stock);
                    $('#last_purchase_rate').val(data.last_purchase_rate);
                    $('#before_receive_rule').val(data.before_receive_rule);
                    $('#before_delivery_rule').val(data.before_delivery_rule);
                    // $('#max_discount').val(data.max_discount);
                    $('#default_selling_pricelist').val(data.default_selling_pricelist);
                    $('#default_bom').val(data.default_bom);
                    // $('#default_supplier').val(data.default_supplier);
                    $('#default_item_manufacturer').val(data.default_item_manufacturer);
                    $('#default_manufacturer_part_no').val(data.default_manufacturer_part_no);
                    $('#customs_tariff_number').val(data.customs_tariff_number);
                    // $('#country_of_origin').val(data.country_of_origin);
                    $('#web_description').val(data.web_description);


                    $('#list_index').val(data.list_index);

                    if (data.allow_alternative_item) {
                        $("#allow_alternative_item").prop("checked", true);
                    }
                    if (data.is_sales_item) {
                        $("#is_sales_item").prop("checked", true);
                    }
                    if (data.is_purchase_item) {
                        $("#is_purchase_item").prop("checked", true);
                    }
                    if (data.is_stock_item) {
                        $("#is_stock_item").prop("checked", true);
                    }
                    if (data.is_manufacturing_item) {
                        $("#is_manufacturing_item").prop("checked", true);
                    }
                    if (data.is_seafood_item) {
                        $("#is_seafood_item").prop("checked", true);
                    }
                    if (data.is_by_product) {
                        $("#is_by_product").prop("checked", true);
                    }
                    if (data.is_fixed_asset) {
                        $("#is_fixed_asset").prop("checked", true);
                    }
                    if (data.is_auto_create_assets) {
                        $("#is_auto_create_assets").prop("checked", true);
                    }
                    if (data.has_batch_no) {
                        $("#has_batch_no").prop("checked", true);
                    }
                    // if (data.has_expiry_date) {
                    //     $("#has_expiry_date").prop("checked", true);
                    // }
                    if (data.has_serial_no) {
                        $("#has_serial_no").prop("checked", true);
                    }
                    if (data.has_variants) {
                        $("#has_variants").prop("checked", true);
                    }
                    if (data.is_inspection_required_before_receive) {
                        $("#is_inspection_required_before_receive").prop("checked", true);
                    }
                    if (data.delivered_by_supplier) {
                        $("#delivered_by_supplier").prop("checked", true);
                    }
                    if (data.is_inspection_required_before_delivery) {
                        $("#is_inspection_required_before_delivery").prop("checked", true);
                    }
                    // if (data.inspection_before_delivery_rule) {
                    //     $("#inspection_before_delivery_rule").prop("checked", true);
                    // }
                    if (data.is_customer_provided_item) {
                        $("#is_customer_provided_item").prop("checked", true);
                    }
                    if (data.show_in_website) {
                        $("#show_in_website").prop("checked", true);
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

function saveBarcode(data) {
    $.ajax({
        type: "POST",
        url: "/inventory/ItemConfigure/saveBarcode",
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
                $('#BarcodeMOdel').modal('toggle');
                loadBarcodes(response.result);
                $('#frmBarcode ').trigger("reset");

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
        }
    });
};
function saveSupplier(data) {
    $.ajax({
        type: "POST",
        url: "/inventory/ItemConfigure/saveSupplier",
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
                $('#SupplierModel').modal('toggle');
                loadSuppliersTable(response.result);
                $('#frmSupplier ').trigger("reset");

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
        }
    });
}
function saveManufacturer(data) {
    $.ajax({
        type: "POST",
        url: "/inventory/ItemConfigure/saveManufacturer",
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
                $('#ManufacturerModel').modal('toggle');
                loadManufacturerTable(response.result);
                $('#frmManufacturer ').trigger("reset");

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
        }
    });
}



function loadCompanies() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadCompanies',
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
function loadItemGroup() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadItemGroup',
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
function loadBrand() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadBrand',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.brand_name + ' </option>';
                });
                $('#BrandID').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadBrand() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadBrand',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.brand_name + ' </option>';
                });
                $('#BrandID').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadAssetCatagories() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadAssetCatagories',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.asset_category_name + ' </option>';
                });
                $('#asset_category').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadUOM() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadUOM',
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
function loadDefaultBuyingPriceList() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadDefaultBuyingPriceList',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.price_list_name + ' </option>';
                });
                $('#default_buying_pricelist').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadDefaultsellingPriceList() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadDefaultsellingPriceList',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.price_list_name + ' </option>';
                });
                $('#default_selling_pricelist').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadDefaultManufacture() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadDefaultManufacture',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.name + ' </option>';
                });
                $('#default_item_manufacturer').append(html);
                $('#manufacturer').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadHS_code() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadHS_code',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.HSCode + ' </option>';
                });
                $('#customs_tariff_number').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function loadCurrentItems() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadCurrentItems',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.item_name + ' </option>';
                });
                $('#variant_of').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadQualityRules() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadQualityRules',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.QualityRuleName + ' </option>';
                });
                $('#inspection_before_delivery_rule').append(html);
                $('#inspection_before_receive_rule').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadBarcodeType() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadBarcodeType',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.barcodeType + ' </option>';
                });
                $('#barcode_type').append(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function loadBarcodes(id) {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadBarcodes/' + id,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var barcode = response.result[i]['barcode'];
                    var barcodeType = response.result[i]['barcodeType'];
                    var dele = '<button class="btn btn-danger mr-1" onclick="_deleteBarcode(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thBarcode": barcode,
                        "thBarcodeType": barcodeType,
                        "action": dele,
                    });
                }

                var table = $('#tableBarcodes').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
};
function _deleteBarcode(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/inventory/ItemConfigure/deleteBarcode/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadBarcodes($('#hiddenId').val());
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function loadSuppliers() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadSuppliers',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.supplier_name + ' </option>';
                });
                $('#supplier').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadSuppliersTable(id) {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadSuppliersTable/' + id,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var supplier = response.result[i]['supplier'];
                    var list_index = response.result[i]['list_index'];
                    var dele = '<button class="btn btn-danger mr-1" onclick="_deleteSupplier(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thsupplier": supplier,
                        "index": list_index,
                        "action": dele,
                    });
                }

                var table = $('#tableSuppliers').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function _deleteSupplier(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/inventory/ItemConfigure/deleteSupplier/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadSuppliersTable($('#hiddenId').val());
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
function loadManufacturerTable(id) {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadManufacturerTable/' + id,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var name = response.result[i]['name'];
                    var list_index = response.result[i]['list_index'];
                    var dele = '<button class="btn btn-danger mr-1" onclick="_deleteManufacturer(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thmanufacturer": name,
                        "index": list_index,
                        "action": dele,
                    });
                }

                var table = $('#tablemanufacturer').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function _deleteManufacturer(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/inventory/ItemConfigure/deleteManufacturer/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadManufacturerTable($('#hiddenId').val());
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
function loadNamingSeris() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadNamingSeris',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.namingFormat + ' </option>';
                });
                $('#asset_naming_series').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadCountries() {
    $.ajax({
        type: 'GET',
        url: '/inventory/ItemConfigure/loadCountries',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.country_name + ' </option>';
                });
                $('#country_of_origin').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

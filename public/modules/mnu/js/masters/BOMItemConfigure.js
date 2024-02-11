console.log('BOMItemConfigure .js loadimng');
var otherItemId = 0;
var mainItemId = 0;

var parent_url = '/mnu/BOMItem_list'

$(document).ready(function () {
    $('#OuterBomMainItem').hide();

    $('#btnSave').on('click', function () {
        var form = $('#frmBOMItemConfigure ').get(0);
        var data = new FormData(form);

        appendOtherItemsToFormData(data);
        appendMainItemsToFormData(data);

        for (var pair of data.entries()) {
            console.log(pair[0] + ' => ' + pair[1]);
        }
        if ($('#btnSave').text().trim() == 'Save') {

            save(data);
        }
        else {
            update(data);
        }

    });
    var table = $('#tableRelatedOuterBOMItem').DataTable({
        responsive: true,
        "paging": false,
        "searching": false,
        "info": false,
        'columnDefs': [{
            "targets": [0, 1, , 2, 3, 4, 5],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thItemCode", 'width': "18%" },
            { "data": "thItemName", 'width': "18%" },
            { "data": "thNetWeight", 'width': "18%" },
            { "data": "thGrossWeight", 'width': "18%" },
            { "data": "action", 'width': "18%" },
        ],
    });
    var table = $('#tableAssignedCustomers').DataTable({
        responsive: true,
        "paging": false,
        "searching": false,
        "info": false,
        'columnDefs': [{
            "targets": [0, 1, , 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thName", 'width': "30%" },
            { "data": "thLableName", 'width': "30%" },
            { "data": "thBarcode", 'width': "20%" },
            { "data": "action", 'width': "10%" },
        ],
    });

    $('#btnAddOtherItem').click(function () {
        var html = `   <div class="form-row" id="` + otherItemId + `">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Item</label>
                            <select class="form-control" onchange="loadOtherItemUnitWeight(`+ otherItemId + `)" name="Otheritem_name_` + otherItemId + `" id="Otheritem_name_` + otherItemId + `">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Quantity</label>
                            <input type="number" class="form-control" onchange="calOtherItemTotalWeight(`+ otherItemId + `)" name="Otheritem_qty_` + otherItemId + `" id="Otheritem_qty_` + otherItemId + `" >
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Unit Weight</label>
                            <input type="number" class="form-control" name="Otheritem_weight_`+ otherItemId + `" id="Otheritem_weight_` + otherItemId + `"  readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Total Weight</label>
                            <input type="number" class="form-control" name="Otheritem_totalWeight_`+ otherItemId + `" id="Otheritem_totalWeight_` + otherItemId + `"  readonly>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Reprocess</label>
                            <input type="checkbox" class="ml-3"  name="Otheritem_reprocess_`+ otherItemId + `" id="Otheritem_reprocess_` + otherItemId + `" >
                        </div>
                        <div class="col-md-1 mb-3">
                            <button type="button" class="btn btn-secondary btn-floating mt-4 ml-2" onclick="removeOtherItem(`+ otherItemId + `)">
                                <i class="ti-trash"></i>
                            </button>
                        </div>

                    </div>`
        $('#otherItemContainer').append(html);
        loadOtherItems("Otheritem_name_" + otherItemId);
        otherItemId = otherItemId + 1
    });
    $('#btnAddMainItem').click(function () {
        var html = `<div class="form-row" id="MainItem_` + mainItemId + `">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Item</label>
                            <select class="form-control" onchange="loadMainItemUnitWeight(`+ mainItemId + `)" name="mainItem_name_` + mainItemId + `" id="mainItem_name_` + mainItemId + `">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Quantity</label>
                            <input type="number" class="form-control" onchange="calMainItemTotalWeight(`+ mainItemId + `)" name="mainItem_qty_` + mainItemId + `" id="mainItem_qty_` + mainItemId + `"
                                >
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Net Weight</label>
                            <input type="number" class="form-control" name="mainItem_netWeight_`+ mainItemId + `" id="mainItem_netWeight_` + mainItemId + `"  readonly>
                            <input type="hidden" id="mainItem_netWeight_hidden_` + mainItemId + `" >

                            </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Gross Weight</label>
                            <input type="number" class="form-control" name="mainItem_GrossWeight_`+ mainItemId + `" id="mainItem_GrossWeight_` + mainItemId + `"  readonly>
                            <input type="hidden" id="mainItem_GrossWeight_hidden_` + mainItemId + `" >
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Reprocess</label>
                            <input type="checkbox" class="ml-3"  name="mainItem_reprocess_`+ mainItemId + `" id="mainItem_reprocess_` + mainItemId + `" >
                        </div>
                        <div class="col-md-1 mb-3">
                            <button type="button" class="btn btn-secondary btn-floating mt-4 ml-2" onclick="removeMainItem(`+ mainItemId + `)">
                                <i class="ti-trash"></i>
                            </button>
                        </div>
                    </div>`
        $('#mainItemContainer').append(html);
        loadMainItems("mainItem_name_" + mainItemId);
        mainItemId = mainItemId + 1
    });

    $('#BOM_itemType').change(function () {
        if (this.value == 'Inner_Bom') {
            $('#RelatedItemRaw').show();
            $('#InnerBomMainItem').show();
            $('#OuterBomMainItem').hide();
        } else {
            $('#RelatedItemRaw').hide();
            $('#InnerBomMainItem').hide();
            $('#OuterBomMainItem').show();
        }
    });
    $('#mainItem_name').change(function () {
        loadUnitWeight('mainItem');
        validateConstantItems(this.value, 'mainItem');
    });
    $('#ContainerItem_name').change(function () {
        loadUnitWeight('containerItem');
        validateConstantItems(this.value, 'containerItem');
    });
    $('#lableItemName').change(function () {
        loadUnitWeight('lableItemName');
        validateConstantItems(this.value, 'lableItemName');
    });
    $('#process').change(function () {
        loadProcessWorkstations(this.value);
    });



    loadProcess();
    loadMainItem();
    loadContainerItem();
    loadLableItem();
    loadBOMItem();


});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/mnu/BOMItemConfigure/save",
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
                $('#frmBOMItemConfigure ').trigger("reset");
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
        url: "/mnu/BOMItemConfigure/update",
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
                $('#frmBOMItemConfigure ').trigger("reset");
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

function loadBOMItem() {

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
            url: "/mnu/BOMItemConfigure/loadBOMItem/" + id,
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
                    var BOM_Item = response.result.BOM_Item;

                    $('#hiddenId').val(BOM_Item.id);

                    $('#Item_Code').val(BOM_Item.Item_Code);
                    $('#item_name').val(BOM_Item.item_name);
                    $('#Item_description').val(BOM_Item.Item_description);
                    $('#averageNet_weight').val(BOM_Item.avg_weight_per_unit);
                    $('#averageGross_weight').val(BOM_Item.avg_gross_weight_per_unit);
                    $('#process').val(BOM_Item.process);
                    loadProcessWorkstations(BOM_Item.process);
                    $('#work_station').val(BOM_Item.work_station);



                    if (response.result.inner_bom) {
                        $('#BOM_itemType').val('Inner_Bom');
                        $('#RelatedItemRaw').show();
                        $('#InnerBomMainItem').show();
                        $('#OuterBomMainItem').hide();
                        addMainItems(response.result.mainItem, 'inner');
                    } else if (response.result.outer_bom) {
                        $('#BOM_itemType').val('Outer_Bom');
                        $('#RelatedItemRaw').hide();
                        $('#InnerBomMainItem').hide();
                        $('#OuterBomMainItem').show();
                        addMainItems(response.result.mainItem, 'outter');
                    }

                    var containerItem = response.result.containerItem
                    if (containerItem != null) {
                        $('#ContainerItem_name').val(containerItem.item_id);
                        $('#conteinerItem_weight').val(containerItem.unit_net_weight);
                        if (containerItem.include_in_reprocessing) {
                            $('#conteinerItem_reprocess').prop("checked", true);
                        }
                    }
                    var lableItem = response.result.lableItem
                    if (lableItem != null) {
                        $('#lableItemName').val(lableItem.item_id);
                        $('#lableItem_Qty').val(lableItem.qty);
                        $('#lableItemWeight').val(lableItem.unit_net_weight);
                        if (lableItem.include_in_reprocessing) {
                            $('#lableItem_reprocess').prop("checked", true);
                        }
                        calLableItemTotalWeight()
                    }

                    addOtherItems(response.result.otherItem)


                    if (BOM_Item.enabled) {
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
function removeOtherItem(id) {
    $('#' + id).remove();
    CalTotalGrossWeight();
}
function removeMainItem(id) {
    $('#MainItem_' + id).remove();
    CalTotalGrossWeight();
}
function loadOtherItems(element) {
    $.ajax({
        type: 'GET',
        url: '/mnu/BOMItemConfigure/loadOtherItems',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.item_name + ' </option>';
                });
                $('#' + element).append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadOtherItemUnitWeight(id) {
    var itemId = $('#Otheritem_name_' + id).val();
    $.ajax({
        type: 'GET',
        url: '/mnu/BOMItemConfigure/loadOtherItemUnitWeight/' + itemId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#Otheritem_weight_' + id).val(response.result)
                $('#Otheritem_qty_' + id).val(1)

                calOtherItemTotalWeight(id);
                $('#otherItemCount').val(otherItemId);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function calOtherItemTotalWeight(id) {
    var totalWeight = $('#Otheritem_weight_' + id).val() * $('#Otheritem_qty_' + id).val();
    $('#Otheritem_totalWeight_' + id).val(totalWeight);
    CalTotalGrossWeight();
}
function appendOtherItemsToFormData(data) {
    for (let i = 0; i <= otherItemId; i++) {
        if ($('#Otheritem_name_' + i).val() != undefined) {
            data.append('Otheritem_name_' + i, $('#Otheritem_name_' + i).val());
            data.append('Otheritem_qty_' + i, $('#Otheritem_qty_' + i).val());
            data.append('Otheritem_weight_' + i, $('#Otheritem_weight_' + i).val());
            if ($('#Otheritem_reprocess_' + i).checked == true) {
                data.append('Otheritem_reprocess_' + i, 1);
            } else {
                data.append('Otheritem_reprocess_' + i, 0);
            }
        }
    }
}
function appendMainItemsToFormData(data) {
    for (let i = 0; i <= mainItemId; i++) {
        if ($('#mainItem_name_' + i).val() != undefined) {
            data.append('mainItem_name_' + i, $('#mainItem_name_' + i).val());
            data.append('mainItem_qty_' + i, $('#mainItem_qty_' + i).val());
            data.append('mainItem_netWeight_' + i, $('#mainItem_netWeight_' + i).val());
            data.append('mainItem_GrossWeight_' + i, $('#mainItem_GrossWeight_' + i).val());
            if ($('#mainItem_reprocess_' + i).checked == true) {
                data.append('mainItem_reprocess_' + i, 1);
            } else {
                data.append('mainItem_reprocess_' + i, 0);
            }
        }
    }
}
function loadMainItem() {
    $.ajax({
        type: 'GET',
        url: '/mnu/BOMItemConfigure/loadMainItem',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.item_name + ' </option>';
                });
                $('#mainItem_name').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadContainerItem() {
    $.ajax({
        type: 'GET',
        url: '/mnu/BOMItemConfigure/loadContainerItem',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.item_name + ' </option>';
                });
                $('#ContainerItem_name').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadLableItem() {
    $.ajax({
        type: 'GET',
        url: '/mnu/BOMItemConfigure/loadLableItem',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.item_name + ' </option>';
                });
                $('#lableItemName').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadUnitWeight(itomCat) {
    var itemId = '';
    if (itomCat == 'mainItem') {
        itemId = $('#mainItem_name').val();
    } else if (itomCat == 'containerItem') {
        itemId = $('#ContainerItem_name').val();
    } else {
        itemId = $('#lableItemName').val();
    }
    $.ajax({
        type: 'GET',
        url: '/mnu/BOMItemConfigure/loadUnitWeight/' + itemId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                if (itomCat == 'mainItem') {
                    $('#mainItem_weight').val(response.result);
                    $('#averageNet_weight').val(response.result);
                    CalTotalGrossWeight();
                } else if (itomCat == 'containerItem') {
                    $('#conteinerItem_weight').val(response.result);
                    CalTotalGrossWeight();
                } else {
                    $('#lableItemWeight').val(response.result);
                    $('#lableItem_Qty').val(1);
                    calLableItemTotalWeight()

                }
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function calLableItemTotalWeight() {
    var totalWeight = $('#lableItem_Qty').val() * $('#lableItemWeight').val();
    $('#lableItem_totalWeight').val(totalWeight);
    CalTotalGrossWeight();
}
function CalTotalGrossWeight() {

    var totalGrossWeight = 0;


    if ($('#mainItm_weight').val() != '') {
        totalGrossWeight = totalGrossWeight + Number($('#mainItem_weight').val())
    }
    if ($('#conteinerItem_weight').val() != '') {
        totalGrossWeight = totalGrossWeight + Number($('#conteinerItem_weight').val())
    }
    if ($('#lableItem_totalWeight').val() != '') {
        totalGrossWeight = totalGrossWeight + Number($('#lableItem_totalWeight').val())
    }
    for (let i = 0; i <= otherItemId; i++) {
        if ($('#Otheritem_totalWeight_' + i).val() != undefined) {
            var val = Number($('#Otheritem_totalWeight_' + i).val())
            totalGrossWeight = totalGrossWeight + val
        }
    }
    for (let i = 0; i <= mainItemId; i++) {
        if ($('#mainItem_GrossWeight_' + i).val() != undefined) {
            var val = Number($('#mainItem_GrossWeight_' + i).val())
            totalGrossWeight = totalGrossWeight + val
        }
    }

    $('#averageGross_weight').val(totalGrossWeight);
}
function loadMainItems(element) {
    $.ajax({
        type: 'GET',
        url: '/mnu/BOMItemConfigure/loadMainItems',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.item_name + ' </option>';
                });
                $('#' + element).append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadMainItemUnitWeight(id) {
    var itemId = $('#mainItem_name_' + id).val();
    $.ajax({
        type: 'GET',
        url: '/mnu/BOMItemConfigure/loadMainItemUnitWeight/' + itemId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#mainItem_netWeight_' + id).val(response.result.avg_weight_per_unit)
                $('#mainItem_GrossWeight_' + id).val(response.result.avg_gross_weight_per_unit)
                $('#mainItem_qty_' + id).val(1)
                $('#mainItem_netWeight_hidden_' + id).val(response.result.avg_weight_per_unit)
                $('#mainItem_GrossWeight_hidden_' + id).val(response.result.avg_gross_weight_per_unit)

                CalTotalGrossWeight();
                $('#MainItemCount').val(mainItemId);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function calMainItemTotalWeight(id) {
    var totalnetWeight = Number($('#mainItem_netWeight_hidden_' + id).val()) * Number($('#mainItem_qty_' + id).val());
    var totalgrossWeight = Number($('#mainItem_GrossWeight_hidden_' + id).val()) * Number($('#mainItem_qty_' + id).val());

    $('#mainItem_netWeight_' + id).val(totalnetWeight);
    $('#mainItem_GrossWeight_' + id).val(totalgrossWeight);

    CalTotalGrossWeight();
}
function addMainItems(data, bomType) {
    if (data != null) {

        if (bomType == 'inner') {
            $('#mainItem_name').val(data.item_id);
            $('#mainItem_weight').val(data.unit_net_weight);
            if (data.include_in_reprocessing) {
                $('#mainItem_reprocess').prop("checked", true);
            }
        } else {
            $.each(data, function (index, value) {

                var html = `<div class="form-row" id="MainItem_` + mainItemId + `">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">Item</label>
                                <select class="form-control" onchange="loadMainItemUnitWeight(`+ mainItemId + `)" name="mainItem_name_` + mainItemId + `" id="mainItem_name_` + mainItemId + `">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="validationCustom01">Quantity</label>
                                <input type="number" class="form-control" onchange="calMainItemTotalWeight(`+ mainItemId + `)" name="mainItem_qty_` + mainItemId + `" id="mainItem_qty_` + mainItemId + `"
                                    >
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="validationCustom01">Net Weight</label>
                                <input type="number" class="form-control" name="mainItem_netWeight_`+ mainItemId + `" id="mainItem_netWeight_` + mainItemId + `"  readonly>
                                <input type="hidden" id="mainItem_netWeight_hidden_` + mainItemId + `" >
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationCustom01">Gross Weight</label>
                                <input type="number" class="form-control" name="mainItem_GrossWeight_`+ mainItemId + `" id="mainItem_GrossWeight_` + mainItemId + `"  readonly>
                                <input type="hidden" id="mainItem_GrossWeight_hidden_` + mainItemId + `" >
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="validationCustom01">Reprocess</label>
                                <input type="checkbox" class="ml-3"  name="mainItem_reprocess_`+ mainItemId + `" id="mainItem_reprocess_` + mainItemId + `" >
                            </div>
                            <div class="col-md-1 mb-3">
                                <button type="button" class="btn btn-secondary btn-floating mt-4 ml-2" onclick="removeMainItem(`+ mainItemId + `)">
                                    <i class="ti-trash"></i>
                                </button>
                            </div>
                        </div>`
                $('#mainItemContainer').append(html);
                loadMainItems("mainItem_name_" + mainItemId);

                console.log(value.qty)
                $('#mainItem_name_' + mainItemId).val(value.item_id);
                $('#mainItem_qty_' + mainItemId).val(value.qty);
                $('#mainItem_netWeight_' + mainItemId).val(value.total_net_weight);
                $('#mainItem_GrossWeight_' + mainItemId).val(value.total_gross_weight);
                if (value.include_in_reprocessing) {
                    $('#mainItem_reprocess_' + mainItemId).prop("checked", true);
                }
                mainItemId = mainItemId + 1
            });

        }
    }
}
function addOtherItems(data) {
    if (data != null) {
        $.each(data, function (index, value) {
            var html = `   <div class="form-row" id="` + otherItemId + `">
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom02">Item</label>
                                    <select class="form-control" onchange="loadOtherItemUnitWeight(`+ otherItemId + `)" name="Otheritem_name_` + otherItemId + `" id="Otheritem_name_` + otherItemId + `">
                                        <option value="">-Select-</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <label for="validationCustom01">Quantity</label>
                                    <input type="number" class="form-control" onchange="calOtherItemTotalWeight(`+ otherItemId + `)" name="Otheritem_qty_` + otherItemId + `" id="Otheritem_qty_` + otherItemId + `" >
                                </div>
                                <div class="col-md-1 mb-3">
                                    <label for="validationCustom01">Unit Weight</label>
                                    <input type="number" class="form-control" name="Otheritem_weight_`+ otherItemId + `" id="Otheritem_weight_` + otherItemId + `"  readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom01">Total Weight</label>
                                    <input type="number" class="form-control" name="Otheritem_totalWeight_`+ otherItemId + `" id="Otheritem_totalWeight_` + otherItemId + `"  readonly>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <label for="validationCustom01">Reprocess</label>
                                    <input type="checkbox" class="ml-3"  name="Otheritem_reprocess_`+ otherItemId + `" id="Otheritem_reprocess_` + otherItemId + `" >
                                </div>
                                <div class="col-md-1 mb-3">
                                    <button type="button" class="btn btn-secondary btn-floating mt-4 ml-2" onclick="removeOtherItem(`+ otherItemId + `)">
                                        <i class="ti-trash"></i>
                                    </button>
                                </div>

                            </div>`
            $('#otherItemContainer').append(html);
            loadOtherItems("Otheritem_name_" + otherItemId);

            $('#Otheritem_name_' + otherItemId).val(value.item_id);
            $('#Otheritem_qty_' + otherItemId).val(value.qty);
            $('#Otheritem_weight_' + otherItemId).val(value.unit_net_weight);
            if (value.include_in_reprocessing) {
                $('#Otheritem_reprocess_' + otherItemId).prop("checked", true);
            }
            calOtherItemTotalWeight(otherItemId)
            otherItemId = otherItemId + 1

        });
    }

}
function validateConstantItems(id, itemType) {
    if (itemType != 'mainItem') {
        if ($('#mainItem_name').val() != '') {
            var itemId = $('#mainItem_name').val()
            if (itemId == id) {
                toastr.warning('Item Already added');
                $('#mainItem_name').val('');
                $('#mainItem_weight').val('');
            }
        }
    }
    if (itemType != 'containerItem') {
        if ($('#ContainerItem_name').val() != '') {
            var itemId = $('#ContainerItem_name').val()
            if (itemId == id) {
                toastr.warning('Item Already added');
                $('#ContainerItem_name').val('');
                $('#conteinerItem_weight').val('');
            }
        }
    }

    if (itemType != 'lableItemName') {
        if ($('#lableItemName').val() != '') {
            var itemId = $('#lableItemName').val()
            if (itemId == id) {
                toastr.warning('Item Already added');
                $('#lableItemName').val('');
                $('#lableItem_Qty').val('');
                $('#lableItemWeight').val('');
                $('#lableItem_totalWeight').val('');
            }
        }
    }

    // for (let i = 0; i <= otherItemId; i++) {
    //     if ($('#Otheritem_totalWeight_' + i).val() != undefined) {
    //         var val = Number($('#Otheritem_totalWeight_' + i).val())
    //         totalGrossWeight = totalGrossWeight + val
    //     }
    // }
    // for (let i = 0; i <= mainItemId; i++) {
    //     if ($('#mainItem_GrossWeight_' + i).val() != undefined) {
    //         var val = Number($('#mainItem_GrossWeight_' + i).val())
    //         totalGrossWeight = totalGrossWeight + val
    //     }
    // }
}
function loadProcess() {
    $.ajax({
        type: 'GET',
        url: '/mnu/BOMItemConfigure/loadProcess',
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
        url: '/mnu/BOMItemConfigure/loadProcessWorkstations/' + ProcessId,
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

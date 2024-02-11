console.log('customerOrderConfigure .js loadimng');
var parent_url = '/selling/customerOrder_list'

var notifyIndex = 0;
var parentId;
var outerSumIndex = 0;
var innerSumIndex = 0;

var PrevNotifyIndex = 0;


$(document).ready(function () {
    $('#btnApprove').hide();
    $('#btnDeny').hide();
    $('#btnSubmit').hide();
    $('#btnSave').show();

    var PreviousOrdersTable = $('#tablecustomerOrder').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thcustomerOrder", 'width': "80%" },
        ],
    });
    var notifyTable = $('#tableNotify').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thnotify", 'width': "80%" },
        ],
    });
    var ItemTable = $('#tableItem').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1],
            "className": "text-center",
        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thItem", 'width': "80%" },
        ],
    });

    //RAW on click event
    $('#tableNotify tbody').on('click', 'tr', function () {
        var data = notifyTable.row(this).data();
        loadNotify(data.thId, 'manual');
    });
    //RAW on click event
    $('#tableItem tbody').on('click', 'tr', function () {
        var data = ItemTable.row(this).data();
        addItem(data.thId);
    });
    //RAW on click event
    $('#tablecustomerOrder tbody').on('click', 'tr', function () {
        var data = PreviousOrdersTable.row(this).data();
        loadPreviousOrderDetails(data.thId);
    });

    $('#btnSave').click(function () {
        var form = $('#frmcustomerOrderConfigure ').get(0);
        var data = new FormData(form);

        appendNotifyAndItemsToFormData(data);
        appendOuterSummaryToFormData(data);
        appendInnerSummaryToFormData(data);


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
    $('#btnPreviousOrders').click(function () {
        PrevNotifyIndex = 0
        $('#PrevNotifyContainer').empty();
        loadCustomersPreviousOrders();
    });
    $('#btnAddNotifyParty').click(function () {
        loadNotifyParties();
        $('#notifyPartyModel').modal('toggle');
    });
    $('#btnSelectAll').click(function () {
        if ($('#btnSelectAll').text().trim() == 'Select All') {
            selectAll('select');
        }
        else {
            selectAll('unselect');
        }
    });
    $('#btnAddPreviousItems').click(function () {
        createPreviousOrderArry();
    });
    $('#btnSubmit').click(function () {
        Conformation(1)
        // setOrderStatus(1);
    });
    $('#btnApprove').click(function () {
        Conformation(2);
    });
    $('#btnDeny').click(function () {
        Conformation(3);
    });



    $('#customer').change(function () {
        loadCustomerBillingAddresses(this.value);
        loadCustomerShippingAddresses(this.value)
    })
    $('#customer_billing_address').change(function () {
        loadAddress(this.value, 'billing')
    })
    $('#customer_shipping_address').change(function () {
        loadAddress(this.value, 'shipping')
    })

    $('#customer').select2({
        placeholder: 'Select'
    });

    getOrderNumber();
    loadCustomers();
    loadCustomerOrder();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/selling/customerOrderConfigure/save",
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
                $('#frmcustomerOrderConfigure ').trigger("reset");
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

                    el[0].style.border = '1px solid red';
                    setTimeout(function () {
                        el[0].style.border = '';
                    }, 4000);
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
        url: "/selling/customerOrderConfigure/update",
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
                $('#frmcustomerOrderConfigure ').trigger("reset");
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

                    el[0].style.border = '1px solid red';
                    setTimeout(function () {
                        el[0].style.border = '';
                    }, 4000);
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
function loadCustomers() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadCustomers',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.CusName + ' </option>';
                });
                $('#customer').append(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadCustomerOrder() {

    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
        if (param.length == 2) {
            console.log('view');

            $('#btnSave').hide();
            $('#btnPreviousOrders').prop("disabled", true);

        } else {
            console.log('edit ');
            $('#btnSave').text('Update');
            $('#btnPreviousOrders').prop("disabled", true);
        }

    }
    if (id) {
        $.ajax({
            type: "GET",
            url: "/selling/customerOrderConfigure/loadCustomerOrder/" + id,
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
                    var data = response.result.CustomerOrder;

                    $('#hiddenId').val(data.id);

                    $('#order_number').val(data.order_number);
                    $('#order_date').val(data.order_date);
                    $('#target_date').val(data.target_date);
                    $('#customer_po_no').val(data.customer_po_no);
                    $('#customer_ref_no').val(data.customer_ref_no);
                    $('#customer').val(data.customer);
                    $('#total_avg_gross_weight').val(data.total_avg_gross_weight);
                    $('#total_avg_net_weight').val(data.total_avg_net_weight);
                    $('#total_price').val(data.total_price);


                    loadCustomerBillingAddresses(data.customer);
                    loadCustomerShippingAddresses(data.customer);

                    $('#customer_shipping_address').val(data.customer_shipping_address);
                    loadAddress(data.customer_shipping_address, 'shipping');


                    $('#customer_billing_address').val(data.customer_billing_address);
                    loadAddress(data.customer_billing_address, 'billing');

                    if (data.enabled) {
                        $("#enabled").prop("checked", true);
                    }
                    else {
                        $("#enabled").prop("checked", false);
                    }

                    loadOuterSummary(response.result.CustomerOrderOuterSummary);
                    loadInnerSummary(response.result.CustomerOrderInnerSummary);

                    //load notifys
                    $.each(response.result.notify, function (index, value) {
                        loadNotify(value.notify_party, 'Auto');
                    });
                    additems(response.result.CustomerOrderDetail);

                    //state management'
                    if (data.order_status == 0) {
                        // disableInputs();
                        $('#btnSave').show();
                        $('#btnSubmit').show();
                    }
                    else if (data.order_status == 1) {
                        // disableInputs();
                        $('#btnSave').show();
                        $('#btnApprove').show();
                        $('#btnDeny').show();
                    }
                    else if (data.order_status == 2) {
                        // disableInputs();
                        $('#btnSave').hide();
                    }
                    else if (data.order_status == 3) {
                        // disableInputs();
                        $('#btnSave').hide();
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
function loadOuterSummary(data) {
    console.log(data);
    $.each(data, function (index, value) {

        var html = `<div class="form-row">
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Product ID</label>
                            <input type="text" class="form-control" id="OuterSumProdId_` + outerSumIndex + `" value="` + value.item + `" readonly>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Product Name</label>
                            <input type="text" class="form-control" id="OuterSumProdName_` + outerSumIndex + `" value="` + value.item_name + `" readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Total Quantity</label>
                            <input type="text" class="form-control" id="OuterSumQty_` + outerSumIndex + `" value="` + value.total_qty + `" readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Total Average Net Weight</label>
                            <input type="text" class="form-control" id="OuterSumWeight_` + outerSumIndex + `" value="` + value.total_avg_net_weight + `" readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Total Price</label>
                            <input type="text" class="form-control" id="OuterSumPrice_` + outerSumIndex + `" value="` + value.total_price + `" readonly>
                        </div>
                    </div>`

        $('#OutterSummaryContainer').append(html);

        outerSumIndex++
    });
}
function loadInnerSummary(data) {
    $.each(data, function (index, value) {
        var html = `<div class="form-row">
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Product ID</label>
                            <input type="text" class="form-control" id="innerSumProdId_` + innerSumIndex + `" value="` + value.item + `" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Product Name</label>
                            <input type="text" class="form-control" id="innerSumProdName_` + innerSumIndex + `" value="` + value.item_name + `" readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Total Quantity</label>
                            <input type="text" class="form-control" id="innerSumQty_` + innerSumIndex + `" value="` + value.total_qty + `" readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Total Average Net Weight</label>
                            <input type="text" class="form-control" id="innerSumWeight_` + innerSumIndex + `" value="` + value.total_avg_net_weight + `" readonly>
                        </div>

                    </div>`
        $('#innerSummaryContainer').append(html);

        innerSumIndex++
    })
}
function additems(data) {

    $.each(data, function (index, value) {
        for (let i = 0; i <= notifyIndex - 1; i++) {
            if (Number($('#notifyID_' + i).val()) == value.notify_party) {

                var ItemIndex = $('#notifyItemCount_' + i).val();

                var html = `<div class="form-row" id="item_` + i + '_' + ItemIndex + `">
                <div class="col-md-1 mb-3">
                    <label for="validationCustom01">Prod Id</label>
                    <input type="text" class="form-control" id="itemId_` + i + '_' + ItemIndex + `" value="` + value.item_code + `" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom02">Prod Name</label>
                    <input type="text" class="form-control" id="itemName_` + i + '_' + ItemIndex + `" value="` + value.item_name + `" readonly>
                </div>
                <div class="col-md-1 mb-3">
                    <label for="validationCustom01">Avg Weight</label>
                    <input type="number" class="form-control"  id="itemWeight_` + i + '_' + ItemIndex + `" value="` + value.avg_net_weight + `" readonly>
                    <input type="hidden" class="form-control"  id="itemGrossWeight_` + i + '_' + ItemIndex + `" value="` + value.avg_gross_weight + `" readonly>

                </div>
                <div class="col-md-1 mb-3">
                    <label for="validationCustom01">Qty</label>
                    <input type="number" class="form-control" id="itemQty_` + i + '_' + ItemIndex + `" onchange="calAvgNetWeightAndPrice(` + i + ',' + ItemIndex + `)" value="` + value.qty + `">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationCustom01">Total AVG Net Weight</label >
                    <input type="number" class="form-control" id="itemTotWeight_` + i + '_' + ItemIndex + `" value="` + value.total_avg_net_weight + `" readonly>
                    <input type="hidden" class="form-control" id="itemTotGrossWeight_` + i + '_' + ItemIndex + `" value="` + value.total_avg_gross_weight + `" readonly>

                </div>
                <div class="col-md-1 mb-3">
                    <label for="validationCustom01">Unit Price</label >
                    <input type="number" class="form-control" id="itemPrice_` + i + '_' + ItemIndex + `"  onchange="calAvgNetWeightAndPrice(` + i + ',' + ItemIndex + `)">
                </div>
                <div class="col-md-1 mb-3">
                    <label for="validationCustom01">Total Price</label>
                    <input type="number" class="form-control" id="itemTotPrice_` + i + '_' + ItemIndex + `" readonly>
                </div>
                <div class="col-md-1 mb-3">
                    <button type="button" class="btn btn-secondary btn-floating mt-4 ml-2" onclick="removeItem(`+ i + `,` + ItemIndex + `)">
                        <i class="ti-trash"></i>
                    </button>
                </div>
            </div>`

                $('#itemContainer_' + i).append(html)

                // setting itemCount
                $('#notifyItemCount_' + i).val(Number(ItemIndex) + 1)
            }
        }




    });
    console.log(data);
}
function loadNotifyParties() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadNotifyParties',
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var AddressTitle = response.result[i]['AddressTitle'];
                    data.push({
                        "thId": id,
                        "thnotify": AddressTitle,
                    });
                }

                var table = $('#tableNotify').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function loadNotify(id, state) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadNotify/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result
                if (validateNotify(data.id)) {
                    addNotifyParty(data.id, data.AddressTitle, state);
                } else {
                    if (state == 'manual') {
                        $('#notifyPartyModel').modal('toggle');
                    }
                }
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function validateNotify(id) {
    for (let i = 0; i <= notifyIndex; i++) {
        if ($('#notifyID_' + i).val() != undefined) {
            if (Number($('#notifyID_' + i).val()) == id) {
                toastr.warning("Notify Alredy Added");
                return false
            }
        }
    }
    return true
};
function addNotifyParty(id, title, state) {

    var html = ` <div id="notify_` + notifyIndex + `">


                    <div class="accordion accordion-primary custom-accordion mb-4">
                        <div class="accordion-row open">
                            <a href="#" class="accordion-header">
                                <span>`+ title + ` </span>
                                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                <i class="accordion-status-icon open fa fa-chevron-down"></i>
                            </a>
                            <div class="accordion-body">
                                <div id="itemContainer_`+ notifyIndex + `">
                                    <input type="hidden" id="notifyItemCount_`+ notifyIndex + `" name="notifyItemCount_` + notifyIndex + `" value="0">
                                    <input type="hidden" id="notifyID_`+ notifyIndex + `" name="notifyID_` + notifyIndex + `" value="` + id + `">
                                    <div class="form-row">
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-primary btn-rounded" style="float: left" onclick="loadItems(`+ notifyIndex + `)">
                                                Add Items
                                            </button>
                                        </div>
                                        <div class="col-md-10 mb-3">
                                            <button type="button" class="btn btn-secondary btn-rounded" style="float: left" onclick="removeNotify(`+ notifyIndex + `)">
                                                Delete Notify
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
    $('#notifyContainer').append(html)
    if (state == 'manual') {
        $('#notifyPartyModel').modal('toggle');
    }


    notifyIndex++
}
function loadItems(parentIndex) {
    var cusID = $('#customer').val();
    if (cusID == '') {

        $('#customer')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#customer')[0].style.border = '';
        }, 4000);
        toastr.warning("Please Select Customer");

    } else {
        $.ajax({
            type: 'GET',
            url: '/selling/customerOrderConfigure/loadItems/' + cusID,
            success: function (response) {
                console.log(response.result)
                if (response.success) {
                    var data = [];
                    for (i = 0; i < response.result.length; i++) {
                        var id = response.result[i]['id'];
                        var item_name = response.result[i]['item_name'];
                        data.push({
                            "thId": id,
                            "thItem": item_name,
                        });
                    }

                    var table = $('#tableItem').DataTable();
                    table.clear();
                    table.rows.add(data).draw();

                    $('#ItemModel').modal('toggle');

                    parentId = parentIndex;
                }
            }, error: function (data) {
                console.log('something went wrong');
            }
        });
    }


}
function validateItem(itemId) {
    var itemCoumt = Number($('#notifyItemCount_' + parentId).val());
    console.log
    for (let i = 0; i <= itemCoumt; i++) {
        if ($('#itemId_' + parentId + '_' + i).val() != undefined) {
            if (Number($('#itemId_' + parentId + '_' + i).val()) == itemId) {
                toastr.warning("Item Alredy Added");
                return false
            }
        }
    }
    return true
}
function addItem(itemId) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/getItem/' + itemId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result
                if (validateItem(data.id)) {
                    var ItemIndex = $('#notifyItemCount_' + parentId).val();

                    var html = `<div class="form-row" id="item_` + parentId + '_' + ItemIndex + `">
                                    <div class="col-md-1 mb-3">
                                        <label for="validationCustom01">Product ID</label>
                                        <input type="text" class="form-control" id="itemId_` + parentId + '_' + ItemIndex + `" value="` + data.id + `" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Product Name</label>
                                        <input type="text" class="form-control" id="itemName_` + parentId + '_' + ItemIndex + `" value="` + data.item_name + `" readonly>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="validationCustom01">Average Weight</label>
                                        <input type="number" class="form-control"  id="itemWeight_` + parentId + '_' + ItemIndex + `" value="` + data.avg_weight_per_unit + `" readonly>
                                        <input type="hidden" class="form-control"  id="itemGrossWeight_` + parentId + '_' + ItemIndex + `" value="` + data.avg_gross_weight_per_unit + `" readonly>

                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="validationCustom01">Quantity</label>
                                        <input type="number" class="form-control" id="itemQty_` + parentId + '_' + ItemIndex + `" onchange="calAvgNetWeightAndPrice(` + parentId + ',' + ItemIndex + `)" value="` + 1 + `">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="validationCustom01">Total Average Net Weight</label >
                                        <input type="number" class="form-control" id="itemTotWeight_` + parentId + '_' + ItemIndex + `" value="` + data.avg_weight_per_unit + `" readonly>
                                        <input type="hidden" class="form-control" id="itemTotGrossWeight_` + parentId + '_' + ItemIndex + `" value="` + data.avg_gross_weight_per_unit + `" readonly>

                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="validationCustom01">Unit Price</label >
                                        <input type="number" class="form-control" id="itemPrice_` + parentId + '_' + ItemIndex + `"  onchange="calAvgNetWeightAndPrice(` + parentId + ',' + ItemIndex + `)">
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="validationCustom01">Total Price</label>
                                        <input type="number" class="form-control" id="itemTotPrice_` + parentId + '_' + ItemIndex + `" readonly>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <button type="button" class="btn btn-secondary btn-floating mt-4 ml-2" onclick="removeItem(`+ parentId + `,` + ItemIndex + `)">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                </div>`

                    $('#itemContainer_' + parentId).append(html)

                    // setting itemCount
                    $('#notifyItemCount_' + parentId).val(Number(ItemIndex) + 1)


                }

                $('#ItemModel').modal('toggle');
                parentId = null;

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });

    calTotalAvgWeightAndPrice();


}
function removeNotify(index) {
    let text = "Do you Want to Delete This 'Notify'";
    if (confirm(text) == true) {
        $('#notify_' + index).remove();
        calTotalAvgWeightAndPrice();
    }
}
function removeItem(index, itemCount) {
    let text = "Do you Want to Delete This 'Item'";
    if (confirm(text) == true) {
        $('#item_' + index + '_' + itemCount).remove();
        calTotalAvgWeightAndPrice();
    }

}
function calAvgNetWeightAndPrice(parentIndex, itemIndex) {
    var qty = $('#itemQty_' + parentIndex + '_' + itemIndex).val();

    //cal total net weight
    if ($('#itemWeight_' + parentIndex + '_' + itemIndex).val() != '') {
        var itemWeight = $('#itemWeight_' + parentIndex + '_' + itemIndex).val();
        var totalWeight = Number(itemWeight) * Number(qty);
        $('#itemTotWeight_' + parentIndex + '_' + itemIndex).val(totalWeight)
    }
    //cal total gross weight
    if ($('#itemGrossWeight_' + parentIndex + '_' + itemIndex).val() != '') {
        var itemGrossWeight = $('#itemGrossWeight_' + parentIndex + '_' + itemIndex).val();
        var totalGrossWeight = Number(itemGrossWeight) * Number(qty);
        $('#itemTotGrossWeight_' + parentIndex + '_' + itemIndex).val(totalGrossWeight)
    }
    //cal total price
    if ($('#itemPrice_' + parentIndex + '_' + itemIndex).val() != '') {
        var itemPrice = $('#itemPrice_' + parentIndex + '_' + itemIndex).val();
        var totalPrice = Number(itemPrice) * Number(qty);
        $('#itemTotPrice_' + parentIndex + '_' + itemIndex).val(totalPrice)
    }
    calTotalAvgWeightAndPrice();
}
function calTotalAvgWeightAndPrice() {
    var totalNetWeight = 0
    var totalGrossWeight = 0
    var totalPrice = 0

    for (let t = 0; t <= notifyIndex; t++) {

        var itemCoumt = $('#notifyItemCount_' + t).val();

        for (let i = 0; i <= itemCoumt; i++) {

            if ($('#itemTotWeight_' + t + '_' + i).val() != undefined) {
                var val = Number($('#itemTotWeight_' + t + '_' + i).val())
                totalNetWeight = totalNetWeight + val
            }
        }
        for (let i = 0; i <= itemCoumt; i++) {

            if ($('#itemTotGrossWeight_' + t + '_' + i).val() != undefined) {
                var val = Number($('#itemTotGrossWeight_' + t + '_' + i).val())
                totalGrossWeight = totalGrossWeight + val
            }
        }
        for (let i = 0; i <= itemCoumt; i++) {

            if ($('#itemTotPrice_' + t + '_' + i).val() != undefined) {
                var val = Number($('#itemTotPrice_' + t + '_' + i).val())
                totalPrice = totalPrice + val
            }
        }

    }
    $('#total_avg_net_weight').val(totalNetWeight);
    $('#total_avg_gross_weight').val(totalGrossWeight);
    $('#total_price').val(totalPrice);
    createOuterSummary();
}
function loadCustomerBillingAddresses(CusId) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadCustomerBillingAddresses/' + CusId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.AddressTitle + ' </option>';
                });
                $('#customer_billing_address').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadCustomerShippingAddresses(CusId) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadCustomerShippingAddresses/' + CusId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.AddressTitle + ' </option>';
                });
                $('#customer_shipping_address').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadAddress(AddressId, type) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadAddress/' + AddressId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {

                var data = response.result;
                var html = "";
                html += `<div class="col-md-12">
                            <div class="card">
                                <div class="card-body ">
                                    <div>
                                        <h6>`+ data.AddressTitle + `(` + data.typeName + `)</h6>
                                        `+ data.Addressline1 + `</br>
                                        `+ data.Addressline2 + `</br>
                                        `+ data.CityTown + `</br>
                                        `+ data.country_name + `</br>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                if (type == 'billing') {
                    $('#billingAddressContainer').html(html);
                } else {
                    $('#shippingAddressContainer').html(html);
                }
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function createOuterSummary() {
    outerSumIndex = 0;
    $('#OutterSummaryContainer').empty();

    for (let t = 0; t <= notifyIndex - 1; t++) {

        var itemCoumt = Number($('#notifyItemCount_' + t).val());

        for (let i = 0; i <= itemCoumt - 1; i++) {
            var itemID;
            var itemName;
            var qty;
            var weight;
            var price;
            var hasItem = false;
            var index;

            if ($('#itemId_' + t + '_' + i).val() != undefined) {
                itemID = Number($('#itemId_' + t + '_' + i).val())
                for (let j = 0; j <= outerSumIndex - 1; j++) {
                    // console.log(outerSumIndex);
                    if ($('#OuterSumProdId_' + j).val() != undefined) {
                        if (Number($('#OuterSumProdId_' + j).val()) == itemID) {
                            hasItem = true;
                            index = j
                        }
                    }
                }
            }
            if ($('#itemName_' + t + '_' + i).val() != undefined) {

                if ($('#itemName_' + t + '_' + i).val() != undefined) {
                    itemName = $('#itemName_' + t + '_' + i).val()
                }
                if ($('#itemQty_' + t + '_' + i).val() != undefined) {
                    qty = Number($('#itemQty_' + t + '_' + i).val())
                }
                if ($('#itemTotWeight_' + t + '_' + i).val() != undefined) {
                    weight = Number($('#itemTotWeight_' + t + '_' + i).val())
                }
                if ($('#itemTotPrice_' + t + '_' + i).val() != undefined) {
                    price = Number($('#itemTotPrice_' + t + '_' + i).val())
                }

                if (hasItem) {
                    console.log(itemID)

                    if ($('#OuterSumQty_' + index).val() != undefined) {
                        var oldQty = Number($('#OuterSumQty_' + index).val())
                        $('#OuterSumQty_' + index).val(oldQty + qty)
                    }
                    if ($('#OuterSumWeight_' + index).val() != undefined) {
                        var oldWeight = Number($('#OuterSumWeight_' + index).val())
                        $('#OuterSumWeight_' + index).val(oldWeight + weight)
                    }
                    if ($('#OuterSumPrice_' + index).val() != undefined) {
                        var oldPrice = Number($('#OuterSumPrice_' + index).val())
                        $('#OuterSumPrice_' + index).val(oldPrice + price)
                    }
                } else {
                    console.log(itemID)
                    var html = `<div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom01">Product ID</label>
                                    <input type="text" class="form-control" id="OuterSumProdId_` + outerSumIndex + `" value="` + itemID + `">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Product Name</label>
                                    <input type="text" class="form-control" id="OuterSumProdName_` + outerSumIndex + `" value="` + itemName + `">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom01">Total Quantity</label>
                                    <input type="text" class="form-control" id="OuterSumQty_` + outerSumIndex + `" value="` + qty + `">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom01">Total Average Net Weight</label>
                                    <input type="text" class="form-control" id="OuterSumWeight_` + outerSumIndex + `" value="` + weight + `">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom01">Total Price</label>
                                    <input type="text" class="form-control" id="OuterSumPrice_` + outerSumIndex + `" value="` + price + `">
                                </div>
                            </div>`

                    $('#OutterSummaryContainer').append(html);

                    outerSumIndex++
                }
            }

        }
    }

    getinnerItems();
}
function appendNotifyAndItemsToFormData(data) {

    data.append('notifyCount', notifyIndex - 1);

    for (let t = 0; t <= notifyIndex - 1; t++) {
        var itemCoumt = Number($('#notifyItemCount_' + t).val());
        data.append('notifyItemCount_' + t, itemCoumt - 1);
        data.append('notifyID_' + t, $('#notifyID_' + t).val());


        for (let i = 0; i <= itemCoumt - 1; i++) {
            if ($('#itemId_' + t + '_' + i).val() != undefined) {
                data.append('itemId_' + t + '_' + i, $('#itemId_' + t + '_' + i).val());
                data.append('itemName_' + t + '_' + i, $('#itemName_' + t + '_' + i).val());
                data.append('itemWeight_' + t + '_' + i, $('#itemWeight_' + t + '_' + i).val());
                data.append('itemGrossWeight_' + t + '_' + i, $('#itemGrossWeight_' + t + '_' + i).val());
                data.append('itemQty_' + t + '_' + i, $('#itemQty_' + t + '_' + i).val());
                data.append('itemTotWeight_' + t + '_' + i, $('#itemTotWeight_' + t + '_' + i).val());
                data.append('itemTotGrossWeight_' + t + '_' + i, $('#itemTotGrossWeight_' + t + '_' + i).val());
                data.append('itemPrice_' + t + '_' + i, $('#itemPrice_' + t + '_' + i).val());
                data.append('itemTotPrice_' + t + '_' + i, $('#itemTotPrice_' + t + '_' + i).val());

            }
        }

    }
}
function appendOuterSummaryToFormData(data) {
    data.append('OuterSumCount', outerSumIndex - 1);

    for (let i = 0; i <= outerSumIndex - 1; i++) {
        if ($('#OuterSumProdId_' + i).val() != undefined) {
            data.append('OuterSumProdId_' + i, $('#OuterSumProdId_' + i).val());
            data.append('OuterSumProdName_' + i, $('#OuterSumProdName_' + i).val());
            data.append('OuterSumQty_' + i, $('#OuterSumQty_' + i).val());
            data.append('OuterSumWeight_' + i, $('#OuterSumWeight_' + i).val());
            data.append('OuterSumPrice_' + i, $('#OuterSumPrice_' + i).val());
        }
    }
}
function getinnerItems() {
    innerSumIndex = 0;
    $('#innerSummaryContainer').empty();

    for (let i = 0; i <= outerSumIndex - 1; i++) {
        if ($('#OuterSumProdId_' + i).val() != undefined) {

            var OuterBomId = Number($('#OuterSumProdId_' + i).val());
            var OuterQty = Number($('#OuterSumQty_' + i).val());


            $.ajax({
                type: 'GET',
                url: '/selling/customerOrderConfigure/getinnerItems/' + OuterBomId,
                async: false,
                success: function (response) {
                    console.log(response)
                    if (response.success) {
                        createInnerSummary(response.result, OuterQty)
                    }
                }, error: function (data) {
                    console.log(data);
                    console.log('something went wrong');
                }
            });
        }
    }
}
function createInnerSummary(data, qty) {

    $.each(data, function (index, value) {
        var hasItem = false;
        var indx;
        for (let i = 0; i <= innerSumIndex; i++) {

            if ($('#innerSumProdId_' + i).val() != undefined) {
                if (Number($('#innerSumProdId_' + i).val()) == value.id) {
                    hasItem = true;
                    indx = i;
                }
            }
        }
        if (hasItem) {
            console.log('index_' + i + '_has_' + value.id)

            var oldQty = Number($('#innerSumQty_' + indx).val())
            $('#innerSumQty_' + indx).val(oldQty + qty)

            var oldWeight = Number($('#innerSumWeight_' + indx).val())
            $('#innerSumWeight_' + indx).val(oldWeight + value.avg_weight_per_unit * qty)
        } else {
            console.log('index_' + i + '_els_' + value.id)
            addInnerSummaryRow(value, qty);
        }

    });

}
function addInnerSummaryRow(value, qty) {
    var html = `<div class="form-row">
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom01">Product ID</label>
                        <input type="text" class="form-control" id="innerSumProdId_` + innerSumIndex + `" value="` + value.id + `">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">Product Name</label>
                        <input type="text" class="form-control" id="innerSumProdName_` + innerSumIndex + `" value="` + value.item_name + `">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom01">Total Quantity</label>
                        <input type="text" class="form-control" id="innerSumQty_` + innerSumIndex + `" value="` + qty + `">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom01">Total Average Net Weight</label>
                        <input type="text" class="form-control" id="innerSumWeight_` + innerSumIndex + `" value="` + value.avg_weight_per_unit * qty + `">
                    </div>

                </div>`
    $('#innerSummaryContainer').append(html);

    innerSumIndex++
}
function appendInnerSummaryToFormData(data) {
    data.append('innerSumCount', innerSumIndex - 1);

    for (let i = 0; i <= innerSumIndex - 1; i++) {
        if ($('#innerSumProdId_' + i).val() != undefined) {
            data.append('innerSumProdId_' + i, $('#innerSumProdId_' + i).val());
            data.append('innerSumProdName_' + i, $('#innerSumProdName_' + i).val());
            data.append('innerSumQty_' + i, $('#innerSumQty_' + i).val());
            data.append('innerSumWeight_' + i, $('#innerSumWeight_' + i).val());
        }
    }
}
function loadCustomersPreviousOrders() {
    var cusID = $('#customer').val();
    if (cusID == '') {

        $('#customer')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#customer')[0].style.border = '';
        }, 4000);
        toastr.warning("Please Select Customer");

    } else {
        $.ajax({
            type: 'GET',
            url: '/selling/customerOrderConfigure/loadCustomersPreviousOrders/' + cusID,
            success: function (response) {
                console.log(response.result)
                if (response.success) {

                    var data = [];
                    for (i = 0; i < response.result.length; i++) {
                        var id = response.result[i]['id'];
                        var order_number = response.result[i]['order_number'];

                        data.push({
                            "thId": id,
                            "thcustomerOrder": order_number,

                        });
                    }

                    var table = $('#tablecustomerOrder').DataTable();
                    table.clear();
                    table.rows.add(data).draw();

                    $('#previousOrderModel').modal('toggle');

                }
            }, error: function (data) {
                console.log('something went wrong');
            }
        });
    }

}
function loadPreviousOrderDetails(orderId) {
    PrevNotifyIndex = 0
    $('#PrevNotifyContainer').empty();

    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadPreviousOrderDetails/' + orderId,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                //load notifys
                $.each(response.result.notify, function (index, value) {
                    loadPreviousOrderNotify(value.notify_party);
                });
                addPreviousItems(response.result.CustomerOrderDetail);

            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function loadPreviousOrderNotify(id) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadNotify/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result
                addPreviousOrderNotifyParty(data.id, data.AddressTitle);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function addPreviousOrderNotifyParty(id, title) {

    var html = ` <div id="prevNotify_` + PrevNotifyIndex + `">

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Notify Party</label>
                            <input type="text" class="form-control" value="`+ title + `" readonly>
                        </div>
                        <div class="col-md-1 mb-3">

                            <div class="form-group form-check pt-4 pr-3">
                                <input type="checkbox" class="form-check-input" id="prevNotifySelect_`+ PrevNotifyIndex + `"  onchange="selectNotify(` + PrevNotifyIndex + `)">
                            </div>
                        </div>
                    </div>
                    <div class="accordion accordion-primary custom-accordion mb-4">
                        <div class="accordion-row open">
                            <a href="#" class="accordion-header">
                                <span>`+ title + `</span>
                                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                <i class="accordion-status-icon open fa fa-chevron-down"></i>
                            </a>
                            <div class="accordion-body">
                                <div id="PrevItemContainer_`+ PrevNotifyIndex + `">
                                <input type="hidden" id="prevNotifyItemCount_`+ PrevNotifyIndex + `" name="prevNotifyItemCount_` + PrevNotifyIndex + `" value="0">
                                <input type="hidden" id="prevNotifyID_`+ PrevNotifyIndex + `" name="prevNotifyID_` + PrevNotifyIndex + `" value="` + id + `">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
    $('#PrevNotifyContainer').append(html)

    PrevNotifyIndex++
}
function addPreviousItems(data) {

    $.each(data, function (index, value) {
        for (let i = 0; i <= PrevNotifyIndex - 1; i++) {
            if (Number($('#prevNotifyID_' + i).val()) == value.notify_party) {

                var ItemIndex = $('#prevNotifyItemCount_' + i).val();

                var html = `<div class="form-row" id="prevItem_` + i + '_' + ItemIndex + `">
                <div class="col-md-1 mb-3">
                    <label for="validationCustom01">Prod Id</label>
                    <input type="text" class="form-control" id="prevItemId_` + i + '_' + ItemIndex + `" value="` + value.item_code + `" readonly>
                    <input type="hidden"  id="prevItemDetailId_` + i + '_' + ItemIndex + `" value="` + value.id + `" readonly>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationCustom02">Prod Name</label>
                    <input type="text" class="form-control" id="prevItemName_` + i + '_' + ItemIndex + `" value="` + value.item_name + `" readonly>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationCustom01">Avg Weight</label>
                    <input type="number" class="form-control"  id="prevItemWeight_` + i + '_' + ItemIndex + `" value="` + value.avg_net_weight + `" readonly>
                    <input type="hidden" class="form-control"  id="prevItemGrossWeight_` + i + '_' + ItemIndex + `" value="` + value.avg_gross_weight + `" readonly>

                </div>
                <div class="col-md-1 mb-3">
                    <label for="validationCustom01">Qty</label>
                    <input type="number" class="form-control" id="prevItemQty_` + i + '_' + ItemIndex + `"  value="` + value.qty + `" readonly>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationCustom01">Total AVG Net Weight</label >
                    <input type="number" class="form-control" id="prevItemTotWeight_` + i + '_' + ItemIndex + `" value="` + value.total_avg_net_weight + `" readonly>
                    <input type="hidden" class="form-control" id="prevItemTotGrossWeight_` + i + '_' + ItemIndex + `" value="` + value.total_avg_gross_weight + `" readonly>

                </div>
                <div class="col-md-1 mb-3">
                    <label for="validationCustom01">Unit Price</label >
                    <input type="number" class="form-control" id="prevItemPrice_` + i + '_' + ItemIndex + `"  readonly>
                </div>
                <div class="col-md-1 mb-3">
                    <label for="validationCustom01">Total Price</label>
                    <input type="number" class="form-control" id="prevItemTotPrice_` + i + '_' + ItemIndex + `" readonly>
                </div>
                <div class="col-md-1 mb-3">
                <div class="form-group form-check pt-4 pr-3">
                    <input type="checkbox" class="form-check-input"  id="prevItemSelect_` + i + '_' + ItemIndex + `" >
                </div>
                </div>
            </div>`

                $('#PrevItemContainer_' + i).append(html)

                // setting itemCount
                $('#prevNotifyItemCount_' + i).val(Number(ItemIndex) + 1)
            }
        }




    });
    console.log(data);
}
function selectAll(value) {
    if (value == 'select') {
        for (let t = 0; t <= PrevNotifyIndex - 1; t++) {

            $("#prevNotifySelect_" + t).prop("checked", true);
            var itemCoumt = Number($('#prevNotifyItemCount_' + t).val());

            for (let i = 0; i <= itemCoumt - 1; i++) {
                if ($('#prevItemSelect_' + t + '_' + i).val() != undefined) {
                    $("#prevItemSelect_" + t + '_' + i).prop("checked", true);
                }
            }
        }
        $('#btnSelectAll').html('Un Select All')
    }
    else {
        for (let t = 0; t <= PrevNotifyIndex - 1; t++) {

            $("#prevNotifySelect_" + t).prop("checked", false);
            var itemCoumt = Number($('#prevNotifyItemCount_' + t).val());

            for (let i = 0; i <= itemCoumt - 1; i++) {
                if ($('#prevItemSelect_' + t + '_' + i).val() != undefined) {
                    $("#prevItemSelect_" + t + '_' + i).prop("checked", false);
                }
            }
        }
        $('#btnSelectAll').html('Select All')
    }
};
function selectNotify(index) {

    if ($("#prevNotifySelect_" + index).is(':checked')) {
        var itemCoumt = Number($('#prevNotifyItemCount_' + index).val());

        for (let i = 0; i <= itemCoumt - 1; i++) {
            if ($('#prevItemSelect_' + index + '_' + i).val() != undefined) {
                $("#prevItemSelect_" + index + '_' + i).prop("checked", true);
            }
        }
    } else {
        var itemCoumt = Number($('#prevNotifyItemCount_' + index).val());
        for (let i = 0; i <= itemCoumt - 1; i++) {
            if ($('#prevItemSelect_' + index + '_' + i).val() != undefined) {
                $("#prevItemSelect_" + index + '_' + i).prop("checked", false);
            }
        }
    }
}
function createPreviousOrderArry() {
    var orderArray = [];
    var notifyArray = [];

    for (let t = 0; t <= PrevNotifyIndex - 1; t++) {
        var itemCoumt = Number($('#prevNotifyItemCount_' + t).val());
        var notifyid = Number($('#prevNotifyID_' + t).val())
        for (let i = 0; i <= itemCoumt - 1; i++) {
            var orderDetailId = Number($('#prevItemDetailId_' + t + '_' + i).val())
            var itemId = Number($('#prevItemId_' + t + '_' + i).val())
            var ItemName = $('#prevItemName_' + t + '_' + i).val()
            var ItemWeight = Number($('#prevItemWeight_' + t + '_' + i).val())
            var ItemGrossWeight = Number($('#prevItemGrossWeight_' + t + '_' + i).val())
            var Qty = Number($('#prevItemQty_' + t + '_' + i).val())
            var ItemTotWeight = Number($('#prevItemTotWeight_' + t + '_' + i).val())
            var ItemTotGrossWeight = Number($('#prevItemTotGrossWeight_' + t + '_' + i).val())
            var ItemPrice = Number($('#prevItemPrice_' + t + '_' + i).val())
            var ItemTotPrice = Number($('#prevItemTotPrice_' + t + '_' + i).val())

            if ($("#prevItemSelect_" + t + '_' + i).is(':checked')) {
                orderArray.push({
                    "notify": notifyid,
                    "orderDetailId": orderDetailId,
                    "itemId": itemId,
                    "ItemName": ItemName,
                    "ItemWeight": ItemWeight,
                    "ItemGrossWeight": ItemGrossWeight,
                    "Qty": Qty,
                    "ItemTotWeight": ItemTotWeight,
                    "ItemTotGrossWeight": ItemTotGrossWeight,
                    "ItemPrice": ItemPrice,
                    "ItemTotPrice": ItemTotPrice,
                });
                var hasItem = false;

                $.each(notifyArray, function (index, value) {
                    if (value.notify == notifyid) {
                        hasItem = true
                    }

                });
                if (!hasItem) {
                    notifyArray.push({
                        "notify": notifyid,
                    });
                }

            }
        }
    }


    addItemsAndNotifyFromPreviousOrder(orderArray, notifyArray)

}
function addItemsAndNotifyFromPreviousOrder(orderArray, notifyArray) {
    $.each(notifyArray, function (index, value) {
        loadNotify(value.notify, 'Auto');
    });
    $.each(orderArray, function (index, value) {
        addItemFromPreviousOrder(value)
    });

    $('#previousOrderModel').modal('toggle');
}
function addItemFromPreviousOrder(data) {
    console.log(data);
    // var parentIndex;

    for (let i = 0; i <= notifyIndex - 1; i++) {
        if ($('#notifyID_' + i).val() != undefined) {
            if (Number($("#notifyID_" + i).val()) == data.notify) {
                // parentIndex = i;
                parentId = i;
            }
        }
    }
    if (validateItem(data.itemId)) {
        var ItemIndex = $('#notifyItemCount_' + parentId).val();

        var html = `<div class="form-row" id="item_` + parentId + '_' + ItemIndex + `">
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Prod Id</label>
                            <input type="text" class="form-control" id="itemId_` + parentId + '_' + ItemIndex + `" value="` + data.itemId + `" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">Prod Name</label>
                            <input type="text" class="form-control" id="itemName_` + parentId + '_' + ItemIndex + `" value="` + data.ItemName + `" readonly>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Avg Weight</label>
                            <input type="number" class="form-control"  id="itemWeight_` + parentId + '_' + ItemIndex + `" value="` + data.ItemWeight + `" readonly>
                            <input type="hidden" class="form-control"  id="itemGrossWeight_` + parentId + '_' + ItemIndex + `" value="` + data.ItemGrossWeight + `" readonly>

                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Qty</label>
                            <input type="number" class="form-control" id="itemQty_` + parentId + '_' + ItemIndex + `" onchange="calAvgNetWeightAndPrice(` + parentId + ',' + ItemIndex + `)" value="` + data.Qty + `">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">Total AVG Net Weight</label >
                            <input type="number" class="form-control" id="itemTotWeight_` + parentId + '_' + ItemIndex + `" value="` + data.ItemTotWeight + `" readonly>
                            <input type="hidden" class="form-control" id="itemTotGrossWeight_` + parentId + '_' + ItemIndex + `" value="` + data.ItemTotGrossWeight + `" readonly>

                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Unit Price</label >
                            <input type="number" class="form-control" id="itemPrice_` + parentId + '_' + ItemIndex + `"  onchange="calAvgNetWeightAndPrice(` + parentId + ',' + ItemIndex + `)" value="` + data.ItemPrice + `">
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">Total Price</label>
                            <input type="number" class="form-control" id="itemTotPrice_` + parentId + '_' + ItemIndex + `" value="` + data.ItemTotPrice + `" readonly>
                        </div>
                        <div class="col-md-1 mb-3">
                            <button type="button" class="btn btn-secondary btn-floating mt-4 ml-2" onclick="removeItem(`+ parentId + `,` + ItemIndex + `)">
                                <i class="ti-trash"></i>
                            </button>
                        </div>
                    </div>`

        $('#itemContainer_' + parentId).append(html)

        // setting itemCount
        $('#notifyItemCount_' + parentId).val(Number(ItemIndex) + 1)
    }
    parentId = null;
    calTotalAvgWeightAndPrice();
}
function getOrderNumber() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/getOrderNumber',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#order_number').val(response.result);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function setOrderStatus(state) {
    var id = $('#hiddenId').val();
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/setOrderStatus/' + state + '/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                toastr.success(response.message);
                if (state == 1) {
                    location.href = parent_url;
                } else if (state == 2) {
                    $('#btnApprove').fadeOut('slow');
                    $('#btnSave').fadeOut('slow');
                    $('#btnSubmit').fadeOut('slow');
                    $('#btnDeny').fadeOut('slow');
                }
                else if (state == 3) {
                    location.href = parent_url;
                    $('#btnApprove').fadeOut('slow');
                    $('#btnSave').fadeOut('slow');
                    $('#btnSubmit').fadeOut('slow');
                    $('#btnDeny').fadeOut('slow');
                }
                return true;

            } else {
                toastr.error(response.message);
                return true;

            }
        }, error: function (data) {

            console.log(data);
            console.log('something went wrong');
            return false;

        }
    });
}
function disableInputs() {
    $(":input").prop("disabled", true);
    $("#btnSubmit").prop("disabled", false);
    $("#btnApprove").prop("disabled", false);
    $("#btnSave").prop("disabled", false);;
}
function Conformation(state) {
    var text1 = '';
    var text2 = '';

    switch (state) {
        case 1:
            text1 = 'submited'
            text2 = 'submit'
            break;
        case 2:
            text1 = 'approved'
            text2 = 'approve'
            break;
        case 3:
            text1 = 'Denied'
            text2 = 'deny'
            break;

        default:
            text1 = '';
            text2 = '';
            break;
    }
    swal({
        title: 'Are You Sure To ' + toTitleCase(text2) + ' Plan ?',
        text: 'you are about to ' + text2 + ' the production of Selected plan',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willdo) => {
            if (willdo) {
                if (setOrderStatus(state)) {
                    swal({
                        title: 'Plan ' + text2 + ' Sucess!',
                        text: 'Selected Plan is ' + text1 + ' !',
                        icon: 'success',
                    });
                }

            } else {
                swal({
                    title: 'Not ' + text2 + '!',
                    text: 'Selected Plan is not ' + text1 + '!',
                    icon: 'error',
                });
            }
        });
}
function toTitleCase(str) {
    return str.replace(/(?:^|\s)\w/g, function (match) {
        return match.toUpperCase();
    });
}


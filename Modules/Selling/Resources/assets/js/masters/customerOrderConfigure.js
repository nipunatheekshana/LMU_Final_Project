console.log('customerOrderConfigure .js loadimng');
var parent_url = '/selling/customerOrder_list'
var itemArr = [];
var PreviousItemArr = [];
var checkBoxId = 0;
var arrayIndex = 0;
var tempId = null;
var isInternalOrder = false;
$(document).ready(function () {
    $('#btnApprove').hide();
    $('#btnDeny').hide();
    $('#btnSubmit').hide();
    $('#btnSave').show();
    $('#btnChangeRequest').hide();
    $('#ChangeRequestContainer').hide();
    $('#btnCreateChangeRequest').hide();
    $('#customerRequestsAccordination').hide();


    var groupColumn = 8;
    var tableItems = $('#tableItems').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        order: [[groupColumn, 'asc']],
        displayLength: 25,
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;

            api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before('<tr class="group"><td colspan="8">' + group + '</td></tr>');

                        last = group;
                    }
                });
        },
        'columnDefs': [
            {
                "targets": [8, 9, 10, 11],
                "visible": false,
            },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                "className": "text-center",

            }
        ],

        "columns": [
            { "data": "thProdId", 'width': "6.6%" },
            { "data": "thproductName", 'width': "2%" },
            { "data": "thAvgWeight", 'width': "6.6%" },
            { "data": "thQty", 'width': "6.6%" },
            { "data": "thTotNetWeight", 'width': "6.6%" },
            { "data": "thUnitPrice", 'width': "6.6%" },
            { "data": "thTotalPrice", 'width': "6.6%" },
            { "data": "action", 'width': "6.6%" },
            { "data": "notifyName" },
            { "data": "notifyID" },
            { "data": "avgGrossWeight" },
            { "data": "totalGrossWeight" },

        ],
    });
    var tableOuterSummary = $('#tableOuterSummary').DataTable({

        // scrollY: 400,
        // scrollX: true,
        // scrollCollapse: true,
        paging: false,
        responsive: true,
        info: false,
        'columnDefs': [
            {
                "targets": [0, 1, 2, 3, 4],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "ProdId", 'width': "10%" },
            { "data": "productName", 'width': "20%" },
            { "data": "TotQty", 'width': "20%" },
            { "data": "TotNetWeight", 'width': "20%" },
            { "data": "TotalPrice", 'width': "20%" },
        ],
    });
    var tableInnerSummary = $('#tableInnerSummary').DataTable({

        // scrollY: 400,
        // scrollX: true,
        // scrollCollapse: true,
        paging: false,
        responsive: true,
        info: false,
        'columnDefs': [
            {
                "targets": [0, 1, 2, 3],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "id" },
            { "data": "item_name" },
            { "data": "qty" },
            { "data": "total_net_weight" },
        ],
    });
    var tablePreviousCustomerOrders = $('#tablePreviousCustomerOrders').DataTable({
        // scrollY: 400,
        // scrollX: true,
        // scrollCollapse: true,
        select: {
            style: 'single'
        },
        paging: false,
        responsive: true,
        info: false,
        'columnDefs': [{
            "targets": [0, 1, 2, 3],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thcustomerOrder", 'width': "22.5%" },
            { "data": "thcustomerName", 'width': "22.5%" },
            { "data": "thStateLable", 'width': "20%" },
        ],
    });
    var tablePreviousOrderItems = $('#tablePreviousOrderItems').DataTable({
        paging: false,
        responsive: true,
        info: false,
        order: [[groupColumn, 'asc']],
        displayLength: 25,
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;

            api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before('<tr class="group"><td colspan="8">' + group + '</td></tr>');

                        last = group;
                    }
                });
        },
        'columnDefs': [
            {
                "targets": [8, 9, 10, 11],
                "visible": false,
            },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                "className": "text-center",

            }
        ],

        "columns": [
            { "data": "thProdId", 'width': "6.6%" },
            { "data": "thproductName", 'width': "2%" },
            { "data": "thAvgWeight", 'width': "6.6%" },
            { "data": "thQty", 'width': "6.6%" },
            { "data": "thTotNetWeight", 'width': "6.6%" },
            { "data": "thUnitPrice", 'width': "6.6%" },
            { "data": "thTotalPrice", 'width': "6.6%" },
            { "data": "action", 'width': "6.6%" },
            { "data": "notifyName" },
            { "data": "notifyID" },
            { "data": "avgGrossWeight" },
            { "data": "totalGrossWeight" },

        ],
    });
    var tableChangeRequests = $('#tableChangeRequests').DataTable({
        // scrollY: 400,
        // scrollX: true,
        // scrollCollapse: true,
        select: {
            style: 'single'
        },
        paging: false,
        responsive: true,
        info: false,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4, 5],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thdate", 'width': "30%" },
            { "data": "thOldQty", 'width': "15%" },
            { "data": "thNewQty", 'width': "15%" },
            { "data": "thOldPrice", 'width': "15%" },
            { "data": "thNewPrice", 'width': "15%" },
            { "data": "thStatus", 'width': "10%" },
        ],
    });
    var tableInnerSummary = $('#tableAllChangeRequests').DataTable({

        // scrollY: 400,
        // scrollX: true,
        // scrollCollapse: true,
        paging: false,
        responsive: true,
        info: false,
        'columnDefs': [
            {
                "targets": [0, 1, 2, 3, 4, 5, 6],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thdateTime" },
            { "data": "thNotify" },
            { "data": "thItem" },
            { "data": "thOldQty" },
            { "data": "thNewQty" },
            { "data": "thStatus" },
            { "data": "action" },
        ],
    });

    // Order by the grouping
    $('#tableItems tbody').on('click', 'tr.group', function () {
        var currentOrder = tableItems.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            tableItems.order([groupColumn, 'desc']).draw();
        } else {
            tableItems.order([groupColumn, 'asc']).draw();
        }
    });
    // //RAW on click event
    $('#tablePreviousCustomerOrders tbody').on('click', 'tr', function () {
        var data = tablePreviousCustomerOrders.row(this).data();
        loadPreviousOrderDetails(data.thId);
    });

    $('#customer').select2({
        placeholder: 'Select'
    });
    $('#notify').select2({
        placeholder: 'Select Fish Type(s)'
    });
    $('#item').select2({
        placeholder: 'Select Fish Type(s)'
    });


    $('#btnaddItem').click(function () {
        if (isCustomerSelected()) {
            resetAddItemModel();
            loadItems();
            loadNotifyParties();
            $('#modelAddItem').modal('toggle');
        }
    });
    $('#btnAddToTable').click(function () {
        var data = getItemInfo();

        if ($('#btnAddToTable').text().trim() == 'Add') {
            if (validateForm()) {

                var itemId = getSelect2Data('item', 'id');
                var notifyId = getSelect2Data('notify', 'id');

                if (!isAdded(itemId, notifyId)) {
                    addItemsToTheTable(data, true);
                }
            }
        } else {
            if (validateForm()) {
                if (!isExcist()) {
                    updateTable(data);
                }
            }
        }

    });
    $('#btnSave').click(function () {
        var form = $('#frmcustomerOrderConfigure ').get(0);
        var data = new FormData(form);
        if (isInternalOrder) {
            data.append('isInternalOrder', true);
        }
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
    $('#btnPreviousOrders').click(function () {
        loadPreviousCustomerOrders();
    });
    $('#btnASelectAll').click(function () {
        selectAll();
    });
    $('#btnAddPreviousItems').click(function () {
        addpreviousOrderItemsToTheOrder();
    });
    $('#btnChangeRequest').click(function () {
        if (isCustomerSelected()) {
            resetAddItemModel();
            loadItems();
            loadNotifyParties();
            $('#modelAddItem').modal('toggle');
        }
    });
    $('#btnCreateChangeRequest').click(function () {
        CreateChangeRequest();
    });

    $('#tableSearch').keyup(function () {
        tableItems.search($('#tableSearch').val()).draw();
    })

    $('#customer').change(function () {
        loadCustomerBillingAddresses(this.value);
        loadCustomerShippingAddresses(this.value);
        CheckCustomerType(this.value);
    })
    $('#customer_billing_address').change(function () {
        loadAddress(this.value, 'billing')
    })
    $('#customer_shipping_address').change(function () {
        loadAddress(this.value, 'shipping')
    })
    $('#item').change(function () {
        getItemDetails(this.value);
        var orderId = $('#hiddenId').val();
        var notify = $('#notify').val();
        loadChangeRequestsToItem(orderId, notify, this.value);
    })
    $('#quantity').change(function () {
        calItemWeight(this.value);
        calItemUnitPrice();
    })
    $('#unitPrice').change(function () {
        calItemUnitPrice();
    })
    $('#notify').change(function () {
        var orderId = $('#hiddenId').val();
        var item = $('#item').val();
        loadChangeRequestsToItem(orderId, this.value, item);
    })


    getToday();
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
function getOrderNumber() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/getOrderNumber',
        // async: false,
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


                    if (data.is_internal_order) {
                        type = 'Internal Order';
                        isInternalOrder = true;
                    } else {
                        type = 'External Order';
                        isInternalOrder = false;
                    }
                    $("#customer").prop("disabled", true);

                    $('#orderType').html(type);

                    $('#hiddenId').val(data.id);

                    $('#order_number').val(data.order_number);
                    $('#order_date').val(data.order_date);
                    $('#target_date').val(data.target_date);
                    $('#customer_po_no').val(data.customer_po_no);
                    $('#customer_ref_no').val(data.customer_ref_no);
                    $('#customer').val(data.customer);
                    $('#total_avg_gross_weight').val(Number(data.total_avg_gross_weight));
                    $('#total_avg_net_weight').val(Number(data.total_avg_net_weight));
                    $('#total_price').val(Number(data.total_price));

                    loadCustomerBillingAddresses(data.customer);
                    loadCustomerShippingAddresses(data.customer);



                    $('#customer_shipping_address').val(data.customer_shipping_address);
                    if (data.customer_shipping_address != null) {
                        loadAddress(data.customer_shipping_address, 'shipping');
                    }


                    $('#customer_billing_address').val(data.customer_billing_address);
                    if (data.customer_billing_address != null) {
                        loadAddress(data.customer_billing_address, 'billing');
                    }
                    // if (data.enabled) {
                    //     $("#enabled").prop("checked", true);
                    // }
                    // else {
                    //     $("#enabled").prop("checked", false);
                    // }
                    //load Items
                    $.each(response.result.CustomerOrderDetail, function (index, value) {
                        var item = {
                            'ProdId': value.item_code,
                            'ProductName': value.item_name,
                            'AvgWeight': Number(value.avg_net_weight),
                            'quantity': Number(value.qty),
                            'totalNetWeight': Number(value.total_avg_net_weight),
                            'unitPrice': Number(value.unit_price),
                            'totalPrice': Number(value.total_price),
                            'notifyID': value.notify_party,
                            'notifyName': value.AddressTitle,
                            'avgGrossWeight': Number(value.avg_gross_weight),
                            'totalGrossWeight': Number(value.total_avg_gross_weight),
                        }
                        addItemsToTheTable(item, false);
                    });
                    loadOuterSummary(response.result.CustomerOrderOuterSummary);
                    loadInnerSummary(response.result.CustomerOrderInnerSummary);

                    manageState(data.order_status, data.prod_status);



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
        // async: false,
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
function loadNotifyParties() {
    var cusID = $('#customer').val();
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadNotifyParties/' + cusID,
        async: false,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.AddressTitle + ' </option>';
                });
                $('#notify').html(html);
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}
function loadItems() {
    var cusID = $('#customer').val();

    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadItems/' + cusID,
        async: false,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.item_name + ' </option>';
                });
                $('#item').html(html);
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function isCustomerSelected() {
    var cusID = $('#customer').val();
    if (cusID == '') {

        $('#customer')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#customer')[0].style.border = '';
        }, 4000);
        toastr.warning("Please Select Customer");
        return false;
    }
    else {
        return true;
    }
}
function getItemDetails(itemId) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/getItemDetails/' + itemId,
        async: false,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                $('#ItemCode').val(response.result.Item_Code);
                $('#AvgWeight').val(response.result.avg_weight_per_unit);
                $('#totalNetWeight').val(response.result.avg_weight_per_unit);
                $('#AvgGrossWeight').val(response.result.avg_gross_weight_per_unit);
                $('#totalGrossWeight').val(response.result.avg_gross_weight_per_unit);
                $('#quantity').val(1);
                $('#unitPrice').val(1);
                $('#totalPrice').val(1);
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function calItemWeight(qty) {
    var netWeight = $('#AvgWeight').val();
    var grossWeight = $('#AvgGrossWeight').val();

    var totalNetWeight = Number(qty) * Number(netWeight);
    var totalGrossWeight = Number(qty) * Number(grossWeight);

    $('#totalNetWeight').val(totalNetWeight);
    $('#totalGrossWeight').val(totalGrossWeight);


}
function calItemUnitPrice() {
    var quantity = $('#quantity').val();
    var unitPrice = $('#unitPrice').val();
    var totalPrice = Number(quantity) * Number(unitPrice);
    $('#totalPrice').val(totalPrice);
}
function validateForm() {
    var bool = true;
    if (getSelect2Data('notify', 'id') == '') {
        errorElement($('#notify'));
        toastr.warning('Select A Notify');
        bool = false;
    }
    if ($('#item').val() == '') {
        errorElement($('#item'));
        toastr.warning('Select An Item');
        bool = false;
    }
    if ($('#quantity').val() == '') {
        errorElement($('#quantity'));
        toastr.warning('Enter Quantity');
        bool = false;
    }
    if ($('#unitPrice').val() == '') {
        errorElement($('#unitPrice'));
        toastr.warning('Enter Unit Price');
        bool = false;
    }
    return bool;
}
function getItemInfo() {
    var AvgWeight = $('#AvgWeight').val().trim();
    var quantity = $('#quantity').val().trim();
    var totalNetWeight = $('#totalNetWeight').val().trim();
    var unitPrice = $('#unitPrice').val().trim();
    var totalPrice = $('#totalPrice').val().trim();
    var avgGrossWeight = $('#AvgGrossWeight').val().trim();
    var totalGrossWeight = $('#totalGrossWeight').val().trim();
    var ProdId = getSelect2Data('item', 'id').trim();
    var ProductName = getSelect2Data('item', 'text').trim();
    var notifyID = getSelect2Data('notify', 'id').trim();
    var notifyName = getSelect2Data('notify', 'text').trim();
    var oderId = $('#hiddenId').val().trim();
    var comment = $('#comment').val();


    var data = {
        'ProdId': ProdId,
        'ProductName': ProductName,
        'AvgWeight': AvgWeight,
        'quantity': quantity,
        'totalNetWeight': totalNetWeight,
        'unitPrice': unitPrice,
        'totalPrice': totalPrice,
        'notifyID': notifyID,
        'notifyName': notifyName,
        'avgGrossWeight': avgGrossWeight,
        'totalGrossWeight': totalGrossWeight,
        'oderId': oderId,
        'comment': comment,

    }
    return data;
}
function addItemsToTheTable(data, cal) {

    itemArr.push({
        'arrayIndex': arrayIndex,
        "thProdId": data.ProdId,
        "thproductName": data.ProductName,
        "thAvgWeight": Number(data.AvgWeight),
        "thQty": Number(data.quantity),
        "thTotNetWeight": Number(data.totalNetWeight),
        "thUnitPrice": Number(data.unitPrice),
        "thTotalPrice": Number(data.totalPrice),
        "action": '<button class="btn btn-primary mr-1" onclick="edit(' + arrayIndex + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="btn btn-danger mr-1" onclick="_delete(' + arrayIndex + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>',
        "notifyID": data.notifyID,
        "notifyName": data.notifyName,
        "avgGrossWeight": Number(data.avgGrossWeight),
        "totalGrossWeight": Number(data.totalGrossWeight),
    });

    arrayIndex++;

    var table = $('#tableItems').DataTable();
    table.clear();
    table.rows.add(itemArr).draw();
    if (cal) {
        calTotalWeightsAndPrice();
    }

}
function getSelect2Data(el, type) {

    var val = '';
    var text = '';
    var id = '';

    switch (el) {
        case 'notify':
            val = $('#notify').select2('data')
            break;
        case 'item':
            val = $('#item').select2('data')
            break;
        default:
            break;
    }
    $.each(val, function (index, value) {
        if (value.selected) {
            text = value.text;
            id = value.id;
        }
    });
    switch (type) {
        case 'id':
            return id
            break;
        case 'text':
            return text
            break;
        default:
            break;
    }

}
function isAdded(itemId, notifyId) {
    var bool = false;

    var table = $('#tableItems').DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if (data.thProdId == itemId && data.notifyID == notifyId) {
            toastr.warning('Item already added to this notify');
            bool = true;
        }
    });
    return bool;
}
function calTotalWeightsAndPrice() {
    var totNetWeight = 0;
    var totGrossWeight = 0;
    var totoPrice = 0;


    $.each(itemArr, function (index, value) {
        totNetWeight = totNetWeight + Number(value.thTotNetWeight);
        totGrossWeight = totGrossWeight + Number(value.totalGrossWeight);
        totoPrice = totoPrice + Number(value.thTotalPrice);
    });
    $('#total_avg_net_weight').val(totNetWeight);
    $('#total_avg_gross_weight').val(totGrossWeight);
    $('#total_price').val(totoPrice);
    createOutterSummary();
}
function createOutterSummary() {
    var outerSumArry = [];

    var table = $('#tableItems').DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        var itemID = data.thProdId;
        var itemName = data.thproductName;
        var qty = data.thQty;
        var weight = data.thTotNetWeight;
        var price = data.thTotalPrice;

        if (!outerSumArry.length == 0) {
            for (let i = 0; i < outerSumArry.length; i++) {
                if (Number(outerSumArry[i]['ProdId']) == Number(itemID)) {
                    qty = Number(qty) + Number(outerSumArry[i]['TotQty']);
                    weight = Number(weight) + Number(outerSumArry[i]['TotNetWeight']);
                    price = Number(price) + Number(outerSumArry[i]['TotalPrice']);

                    outerSumArry.splice(i, 1); //This removes 1 item from the array starting at indexValueOfArray
                    //because this item is alredy added above line remove the previously added item
                }
            }
        }
        outerSumArry.push({
            'ProdId': itemID,
            'productName': itemName,
            'TotQty': qty,
            'TotNetWeight': weight,
            'TotalPrice': price,
        });
    });
    var table = $('#tableOuterSummary').DataTable();
    table.clear();
    table.rows.add(outerSumArry).draw();

    getInnerSummary(outerSumArry);
}
function getInnerSummary(outerSumArry) {
    $.ajax({
        type: 'POST',
        url: '/selling/customerOrderConfigure/getInnerSummary',
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { 'outerSumArry': outerSumArry },
        success: function (response) {
            console.log(response)

            var table = $('#tableInnerSummary').DataTable();
            table.clear();
            table.rows.add(response.result).draw();

        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function appendNotifyAndItemsToFormData(data) {

    var table = $('#tableItems').DataTable();

    var arr = [];

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        arr.push({
            'ProdId': data.thProdId,
            'productName': data.thproductName,
            'AvgWeight': data.thAvgWeight,
            'Qty': data.thQty,
            'TotNetWeight': data.thTotNetWeight,
            'UnitPrice': data.thUnitPrice,
            'TotalPrice': data.thTotalPrice,
            'notifyName': data.notifyName,
            'notifyID': data.notifyID,
            'avgGrossWeight': data.avgGrossWeight,
            'totalGrossWeight': data.totalGrossWeight,
        });
    });
    console.log(arr)

    for (var i = 0; i < arr.length; i++) {
        data.append('itemArr[]', JSON.stringify(arr[i]));
    }
}
function appendOuterSummaryToFormData(data) {

    var table = $('#tableOuterSummary').DataTable();

    var arr = [];

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        arr.push({
            'ProdId': data.ProdId,
            'productName': data.productName,
            'TotQty': data.TotQty,
            'TotNetWeight': data.TotNetWeight,
            'TotalPrice': data.TotalPrice,
        });
    });
    console.log(arr)

    for (var i = 0; i < arr.length; i++) {
        data.append('outterSummaryArr[]', JSON.stringify(arr[i]));
    }
}
function appendInnerSummaryToFormData(data) {

    var table = $('#tableInnerSummary').DataTable();

    var arr = [];

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        arr.push({
            'id': data.id,
            'item_name': data.item_name,
            'qty': data.qty,
            'total_net_weight': data.total_net_weight,
        });
    });
    console.log(arr)

    for (var i = 0; i < arr.length; i++) {
        data.append('innerSummaryArr[]', JSON.stringify(arr[i]));
    }
}
function loadOuterSummary(data) {
    var outerSumArry = [];

    $.each(data, function (index, value) {
        outerSumArry.push({
            'ProdId': value.item,
            'productName': value.item_name,
            'TotQty': Number(value.total_qty),
            'TotNetWeight': Number(value.total_avg_net_weight),
            'TotalPrice': Number(value.total_price),
        });
    });
    var table = $('#tableOuterSummary').DataTable();
    table.clear();
    table.rows.add(outerSumArry).draw();
}
function loadInnerSummary(data) {
    var innerSumArry = [];

    $.each(data, function (index, value) {
        innerSumArry.push({
            'id': value.item,
            'item_name': value.item_name,
            'qty': Number(value.total_qty),
            'total_net_weight': Number(value.total_avg_net_weight),
        });
    });
    var table = $('#tableInnerSummary').DataTable();
    table.clear();
    table.rows.add(innerSumArry).draw();
}
function _delete(id) {
    for (let i = 0; i < itemArr.length; i++) {
        if (Number(itemArr[i]['arrayIndex']) == Number(id)) {
            itemArr.splice(i, 1);
        }

    }
    var table = $('#tableItems').DataTable();
    table.clear();
    table.rows.add(itemArr).draw();
    calTotalWeightsAndPrice();
};
function edit(id) {
    for (let i = 0; i < itemArr.length; i++) {
        if (Number(itemArr[i]['arrayIndex']) == Number(id)) {
            loadNotifyParties();
            loadItems();
            console.log(itemArr[i]['thUnitPrice']);
            $('#notify').val(Number(itemArr[i]['notifyID']));
            $('#item').val(Number(itemArr[i]['thProdId']));
            $('#quantity').val(itemArr[i]['thQty']);
            $('#unitPrice').val(itemArr[i]['thUnitPrice']);
            $('#totalPrice').val(itemArr[i]['thTotalPrice']);
            $('#AvgWeight').val(itemArr[i]['thAvgWeight']);
            $('#totalNetWeight').val(itemArr[i]['thTotNetWeight']);
            $('#AvgGrossWeight').val(itemArr[i]['avgGrossWeight']);
            $('#totalGrossWeight').val(itemArr[i]['totalGrossWeight']);


            $('#btnAddToTable').text('Update');
            tempId = i;
            $('#modelAddItem').modal('toggle');
            break;

        }
    }
};
function isExcist() {
    var bool = false;
    var itemId = getSelect2Data('item', 'id');
    var notifyId = getSelect2Data('notify', 'id');
    $.each(itemArr, function (index, value) {
        if (value.thProdId == itemId && value.notifyID == notifyId && value.arrayIndex != tempId) {
            toastr.warning('Item already added to this notify');
            bool = true;
        }
    });
    return bool;

}
function updateTable(data) {
    itemArr[tempId]['thProdId'] = data.ProdId;
    itemArr[tempId]['thproductName'] = data.ProductName;
    itemArr[tempId]['thAvgWeight'] = Number(data.AvgWeight);
    itemArr[tempId]['thQty'] = Number(data.quantity);
    itemArr[tempId]['thTotNetWeight'] = Number(data.totalNetWeight);
    itemArr[tempId]['thUnitPrice'] = Number(data.unitPrice);
    itemArr[tempId]['thTotalPrice'] = Number(data.totalPrice);
    itemArr[tempId]['notifyID'] = data.notifyID;
    itemArr[tempId]['notifyName'] = data.notifyName;
    itemArr[tempId]['avgGrossWeight'] = Number(data.avgGrossWeight);
    itemArr[tempId]['totalGrossWeight'] = Number(data.totalGrossWeight);

    var table = $('#tableItems').DataTable();
    table.clear();
    table.rows.add(itemArr).draw();
    console.log(itemArr)

    tempId = null;
    calTotalWeightsAndPrice();

    $('#modelAddItem').modal('toggle');
    resetAddItemModel();
}
function resetAddItemModel() {
    $('#notify').val('');
    $('#item').val('');
    $('#AvgWeight').val('');
    $('#quantity').val('');
    $('#totalNetWeight').val('');
    $('#unitPrice').val('');
    $('#totalPrice').val('');
    $('#AvgGrossWeight').val('');
    $('#totalGrossWeight').val('');

    $('#btnAddToTable').text('Add');

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
                    // $('#btnApprove').fadeOut('slow');
                    // $('#btnSave').fadeOut('slow');
                    // $('#btnSubmit').fadeOut('slow');
                    // $('#btnDeny').fadeOut('slow');
                    location.href = parent_url;

                }
                else if (state == 3) {
                    location.href = parent_url;
                    // $('#btnApprove').fadeOut('slow');
                    // $('#btnSave').fadeOut('slow');
                    // $('#btnSubmit').fadeOut('slow');
                    // $('#btnDeny').fadeOut('slow');
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
function manageState(OrderStatus, productionStatus) {
    var bdgOrderStatus = '';
    var bdgProductionStatus = '';

    switch (Number(OrderStatus)) {
        case 0:
            $('#btnSave').show();
            $('#btnSubmit').show();
            bdgOrderStatus = `<span class="badge bg-warning-bright text-warning mb-3"><h6 class="m-1">Draft</h6></span>`;
            break;
        case 1:
            $('#btnSave').show();
            $('#btnApprove').show();
            $('#btnDeny').show();
            bdgOrderStatus = `<span class="badge bg-primary-bright text-primary mb-3"><h6 class="m-1">Submited</h6></span>`;

            break;
        case 2:
            $('#btnaddItem').hide();
            $('#btnSave').hide();
            $('#btnChangeRequest').show();
            $('#ChangeRequestContainer').show();
            $('#btnCreateChangeRequest').show();
            $('#customerRequestsAccordination').show();
            $('#btnAddToTable').hide();

            bdgOrderStatus = `<span class="badge bg-success-bright text-success mb-3"><h6 class="m-1">Approved</h6></span>`;

            break;
        case 3:
            $('#btnSave').hide();
            bdgOrderStatus = `<span class="badge bg-secondary-bright text-secondary mb-3"><h6 class="m-1">Denied</h6></span>`;

            break;
        case 4:
            $('#btnSave').hide();
            bdgOrderStatus = `<span class="badge bg-danger-bright text-danger mb-3"><h6 class="m-1">Closed</h6></span>`;

            break;

        default:
            $('#btnApprove').hide();
            $('#btnDeny').hide();
            $('#btnSubmit').hide();
            $('#btnSave').show();
            var bdgOrderStatus = '';
            break;
    }
    switch (Number(productionStatus)) {
        case 0:

            bdgProductionStatus = `<span class="badge bg-warning-bright text-warning mb-3"><h6 class="m-1">Pending</h6></span>`;
            break;
        case 1:

            bdgProductionStatus = `<span class="badge bg-primary-bright text-primary mb-3"><h6 class="m-1">Ongoing</h6></span>`;

            break;
        case 2:
            bdgProductionStatus = `<span class="badge bg-secondary-bright text-secondary mb-3"><h6 class="m-1">Hold</h6></span>`;

            break;
        case 3:
            bdgProductionStatus = `<span class="badge bg-success-bright text-success mb-3"><h6 class="m-1">Compleated</h6></span>`;

            break;
        case 4:
            bdgProductionStatus = `<span class="badge bg-danger-bright text-danger mb-3"><h6 class="m-1">Closed</h6></span>`;

            break;

        default:
            break;
    }
    $('#bdgOrderStatus').html(bdgOrderStatus)
    $('#bdgProductionStatus').html(bdgProductionStatus)


}
function CheckCustomerType(CusId) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/CheckCustomerType/' + CusId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var type = '';
                if (response.result) {
                    type = 'Internal Order';
                    isInternalOrder = true;
                } else {
                    type = 'External Order';
                    isInternalOrder = false;
                }
                $('#orderType').html(type);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

//#################################################################//
//###############load From Previous Orders########################//
//###############################################################//

function loadPreviousCustomerOrders() {
    var cusID = $('#customer').val();
    if (cusID == '') {

        errorElement($('#customer'));
        toastr.warning("Please Select Customer");

    } else {
        $.ajax({
            type: 'GET',
            url: '/selling/customerOrderConfigure/loadPreviousCustomerOrders/' + cusID,
            async: false,
            success: function (response) {
                console.log(response.result)
                if (response.success) {

                    var data = [];
                    for (i = 0; i < response.result.length; i++) {
                        var state = '';
                        var id = response.result[i]['id'];
                        var order_number = response.result[i]['order_number'];
                        var order_status = response.result[i]['order_status'];
                        var CusName = response.result[i]['CusName'];


                        switch (Number(order_status)) {
                            case 0:
                                state = '<span class="badge bg-warning-bright text-warning">Draft</span>'
                                break;
                            case 1:
                                state = '<span class="badge bg-primary-bright text-primary">Submited</span>'

                                break;
                            case 2:
                                state = '<span class="badge bg-success-bright text-success">Approved</span>'

                                break;
                            case 3:
                                state = '<span class="badge bg-secondary-bright text-secondary">Denied</span>'

                                break;
                            case 4:
                                state = '<span class="badge bg-danger-bright text-danger">Closed</span>'
                                break;

                            default:
                                break;
                        }

                        data.push({
                            "thId": id,
                            "thcustomerOrder": order_number,
                            "thcustomerName": CusName,
                            "thStateLable": state,
                        });
                    }

                    var table = $('#tablePreviousCustomerOrders').DataTable();
                    table.clear();
                    table.rows.add(data).draw();

                    $('#previousOrderModel').modal('toggle');

                }
            }, error: function (data) {
                console.log('something went wrong');
            }
        });
    }

};
function loadPreviousOrderDetails(orderId) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerOrderConfigure/loadPreviousOrderDetails/' + orderId,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                //load notifys
                $.each(response.result, function (index, value) {
                    var item = {
                        'ProdId': value.item_code,
                        'ProductName': value.item_name,
                        'AvgWeight': Number(value.avg_net_weight),
                        'quantity': Number(value.qty),
                        'totalNetWeight': Number(value.total_avg_net_weight),
                        'unitPrice': Number(value.unit_price),
                        'totalPrice': Number(value.total_price),
                        'notifyID': value.notify_party,
                        'notifyName': value.AddressTitle,
                        'avgGrossWeight': Number(value.avg_gross_weight),
                        'totalGrossWeight': Number(value.total_avg_gross_weight),
                    }
                    addItemsToThePreviousOrderItemTable(item);
                });
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function addItemsToThePreviousOrderItemTable(data) {

    PreviousItemArr.push({
        // 'arrayIndex': arrayIndex,
        "thProdId": data.ProdId,
        "thproductName": data.ProductName,
        "thAvgWeight": Number(data.AvgWeight),
        "thQty": Number(data.quantity),
        "thTotNetWeight": Number(data.totalNetWeight),
        "thUnitPrice": Number(data.unitPrice),
        "thTotalPrice": Number(data.totalPrice),
        "action": `<input type="checkbox" id="checkbox_` + checkBoxId + `" >`,
        "notifyID": data.notifyID,
        "notifyName": data.notifyName,
        "avgGrossWeight": Number(data.avgGrossWeight),
        "totalGrossWeight": Number(data.totalGrossWeight),
    });
    checkBoxId++
    // arrayIndex++;

    var table = $('#tablePreviousOrderItems').DataTable();
    table.clear();
    table.rows.add(PreviousItemArr).draw();
}
function selectAll() {
    if ($('#btnASelectAll').text().trim() == 'Select All') {
        for (i = 0; i < checkBoxId; i++) {
            $("#checkbox_" + i).prop("checked", true);
        }
        $('#btnASelectAll').html('Un Select All')
    } else {
        for (i = 0; i < checkBoxId; i++) {
            $("#checkbox_" + i).prop("checked", false);
        }
        $('#btnASelectAll').html('Select All')
    }
}
function addpreviousOrderItemsToTheOrder() {
    var table = $('#tablePreviousOrderItems').DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if ($("#checkbox_" + rowIdx).prop("checked") == true) {
            var temp = {
                'ProdId': data.thProdId,
                'ProductName': data.thproductName,
                'AvgWeight': data.thAvgWeight,
                'quantity': data.thQty,
                'totalNetWeight': data.thTotNetWeight,
                'unitPrice': data.thUnitPrice,
                'totalPrice': data.thTotalPrice,
                'notifyID': data.notifyID,
                'notifyName': data.notifyName,
                'avgGrossWeight': data.avgGrossWeight,
                'totalGrossWeight': data.totalGrossWeight,
            }
            if (!isAdded(data.thProdId, data.notifyID)) {
                addItemsToTheTable(temp, true);
            }
        }

    });
    // PreviousItemArr=[];
    // var table = $('#tablePreviousOrderItems').DataTable();
    // table.clear();
    // table.rows.add(PreviousItemArr).draw();
    $('#previousOrderModel').modal('toggle');
}


//#################################################################//
//##########################Change Request########################//
//###############################################################//

function CreateChangeRequest() {
    var data = getItemInfo();
    $.ajax({
        type: "POST",
        url: "/selling/customerOrderConfigure/CreateChangeRequest",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success(response.message);
                loadChangeRequestsToItem(response.result.order_id, response.result.notify_party, response.result.item_id)
            } else {
                toastr.warning(response.message);
            }
        },
        error: function (error) {
            console.log(error);
            toastr.error('Something went wrong');
        },
    });
}
function loadChangeRequestsToItem(orderId, notifyID, itemID) {
    console.log(orderId, notifyID, itemID)
    if (orderId != '' && notifyID != '' && itemID != '') {
        $.ajax({
            type: "POST",
            url: "/selling/customerOrderConfigure/loadChangeRequestsToItem",
            data: {
                'orderId': orderId,
                'notifyID': notifyID,
                'itemID': itemID,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    var data = [];

                    $.each(response.result, function (i, val) {
                        // const date = new Date(val.created_at);
                        var date = new Date(val.created_at);
                        var Created_date = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
                        var Created_time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();

                        var created_at = Created_date + " " + Created_time;
                        var old_qty = val.old_qty;
                        var new_qty = val.new_qty;
                        var old_price = val.old_price;
                        var new_price = val.new_price;

                        var status = '';

                        switch (Number(val.status)) {
                            case 0:
                                status = '<span class="badge bg-warning-bright text-warning">Pending</span>'
                                break;
                            case 1:
                                status = '<span class="badge bg-success-bright text-success">Approved</span>'

                                break;
                            case 2:
                                status = '<span class="badge bg-danger-bright text-danger">Rejected</span>'

                                break;

                            default:
                                break;
                        }

                        data.push({
                            "thdate": created_at,
                            "thOldQty": old_qty,
                            "thNewQty": new_qty,
                            "thOldPrice": old_price,
                            "thNewPrice": new_price,
                            "thStatus": status,
                        });
                    });
                    var table = $('#tableChangeRequests').DataTable();
                    table.clear();
                    table.rows.add(data).draw();
                }
            },
            error: function (error) {
                console.log(error);
                toastr.error('Something went wrong');
            },
        });
    }
}
function getToday() {
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
    $('#order_date').val(output);
    $('#target_date').val(output);
}

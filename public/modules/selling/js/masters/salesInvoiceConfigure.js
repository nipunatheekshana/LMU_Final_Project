console.log('salesInvoiceConfigure.js loading');
var parent_url = '/selling/salesinvoice_list'
    , ExpPlId
    , boxArray = []
    , boxArrayCopy = []
    , product_priceArray = [];
$(document).ready(function () {

    $('#btnSave').show();
    // $('#modalSelectPL').modal('show');

    // Invoice Items Table
    var tblInvoiceItems = $('#tblInvoiceItems').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        displayLength: 25,
        'columnDefs': [
            {
                "targets": [0, 1, 2, 3, 8],
                "className": "text-center",
            },
            {
                "targets": [4, 5, 6, 7],
                "className": "text-right",
            }
        ],
        order: [[2, 'asc']],

        "columns": [
            { "data": "thNo", 'width': "5%" },
            { "data": "thProdCode", 'width': "15%" },
            { "data": "thproductName", 'width': "25%" },
            { "data": "thBoxesQty", 'width': "10%" },
            { "data": "thNetWg", 'width': "10%" },
            { "data": "thGrossWg", 'width': "10%" },
            { "data": "thRate", 'width': "10%" },
            { "data": "thTotalPrice", 'width': "10%" },
            { "data": "thAction", 'width': "15%" }
        ],
    });

    var tblModalPendingBoxesSummary = $('#tblModalPendingBoxesSummary').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        displayLength: 25,
        'columnDefs': [
            {
                "targets": '_all',
                "visible": true,
                "className": "text-center",
            }
        ],

        "columns": [
            { "data": "thProductCode", 'width': "30%" },
            { "data": "thProductName", 'width': "50%" },
            { "data": "thPendingQty", 'width': "20%" }
        ],
    });

    // Packing Lists Table on Packing List Selection Modal
    var tblModalPackingLists = $('#tblModalPackingLists').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        // displayLength: 25,
        select: {
            style: "single"
        },
        'columnDefs': [
            {
                "targets": '_all',
                "className": "text-center",
                "createdCell": function (td) {
                    $(td).css('padding', '0px')
                }
            },
            {
                "targets": [7],
                "visible": false,
            }
        ],

        "columns": [
            { "data": "thPLNo", 'width': "10%" },
            { "data": "thPLDate", 'width': "10%" },
            { "data": "thCustomer", 'width': "20%" },
            { "data": "thNotify", 'width': "20%" },
            { "data": "thOrderNo", 'width': "10%" },
            { "data": "thPONo", 'width': "10%" },
            { "data": "thAWBNo", 'width': "10%" },
            { "data": "id" }
        ],
    });

    // Packing Lists Details Table on Packing List Selection Modal
    var tblModalPackingListDetails = $('#tblModalPackingListDetails').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        displayLength: 25,
        'columnDefs': [
            {
                "targets": '_all',
                "visible": true,
                "className": "text-center",
            }
        ],

        "columns": [
            { "data": "thProduct", 'width': "50%" },
            { "data": "thQty", 'width': "10%" },
            { "data": "thNetWeight", 'width': "20%" },
            { "data": "thGrossWeight", 'width': "20%" }
        ],
    });

    // Pending Balance Details Table on Pending Balance Modal
    var tblModalPendingBoxes = $('#tblModalPendingBoxes').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        displayLength: 25,
        'columnDefs': [
            {
                "targets": '_all',
                "visible": true,
                "className": "text-center",
            }
        ],

        "columns": [
            { "data": "thBoxNo", 'width': "20%" },
            { "data": "thNetWeight", 'width': "30%" },
            { "data": "thGrossWeight", 'width': "30%" },
            { "data": "thActions", 'width': "20%" }
        ],
    });

    var tblSelectedBoxDetails = $('#tblSelectedBoxDetails').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        displayLength: 25,
        'columnDefs': [
            {
                "targets": '_all',
                "visible": true,
                "className": "text-center",
            }
        ],
        order: [[0, 'asc']],
        "columns": [
            { "data": "thBoxNo", 'width': "20%" },
            { "data": "thNetWeight", 'width': "30%" },
            { "data": "thGrossWeight", 'width': "30%" },
            { "data": "thActions", 'width': "20%" }
        ],
    });
    var tblDeSelectedBoxDetails = $('#tblDeSelectedBoxDetails').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        displayLength: 25,
        'columnDefs': [
            {
                "targets": '_all',
                "visible": true,
                "className": "text-center",
            }
        ],
        order: [[0, 'asc']],

        "columns": [
            { "data": "thBoxNo", 'width': "20%" },
            { "data": "thNetWeight", 'width': "30%" },
            { "data": "thGrossWeight", 'width': "30%" },
            { "data": "thActions", 'width': "20%" }
        ],
    });
    tblModalPackingLists.on("select", function (e, dt, type, indexes) {
        if (type === "row") {
            var data = tblModalPackingLists.row(indexes[0]).data();
            ExpPlId = data.id;
            loadExplDetails(data.id)
        }
    });

    $('#customer').select2({
        placeholder: 'Select'
    });
    $('#currency').select2({
        placeholder: 'Select'
    });
    $('#shipping_term').select2({
        placeholder: 'Select'
    });
    $('#notify1').select2({
        placeholder: 'Select Notify'
    });
    $('#notify2').select2({
        placeholder: 'Select Notify'
    });

    $('#btnReport1').click(function () {
        var reportId = 1;
        getReport(reportId);
    });
    $('#btnReport2').click(function () {
        var reportId = 2;
        getReport(reportId);
    });
    $('#btnReport3').click(function () {
        var reportId = '';
        getReport(reportId);
    });
    $('#btnReport4').click(function () {
        var reportId = '';
        getReport(reportId);
    });
    $('#btnSelectPL').click(function () {
        loadPls();
    });
    $('#btnAddNewRow').click(function () {
        $('#modalAddNewRow').modal('toggle');
    });
    $('#btnAddFromPLSelected').click(function () {
        $('#modalAddFromPLSelected').modal('toggle');
    });
    $('#btnEdit').click(function () {
        $('#modalEditRow').modal('toggle');
    });
    $('#btnAddToPl').click(function () {
        if (Expl_is_selected()) {

        }
        if (Expl_is_selected()) {
            AddPl();
        }
    });
    $('#modalEditRow_btnUpdate').click(function () {
        updateRate();
    });
    $('#btnReset').click(function () {
        boxArray = []
        $.each(boxArrayCopy, function (i, val) {
            boxArray.push(val)
        });
        console.log(boxArray)
        createBoxSummary();
    });
    $('#btnSave').on('click', function () {
        var form = $('#frmsalesInvoiceHeader').get(0);
        var data = new FormData(form);
        appendInvData(data)
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

    $('#modalEditRow_Rate').change(function () {
        calTotRawEditModel(this.value);
    });
    $('#freight_type').change(function () {
        calFreight();
    });
    $('#freightVal').change(function () {
        calFreight();
    });
    $('#discountVal').change(function () {
        calDiscount();
    });
    $('#discountType').change(function () {
        calDiscount();
    });
    $('#currency').change(function () {
        loadBaseCurrency(this.value)
    });
    $('#bank_account').change(function () {
        loadBankAccountDetails(this.value)
    });


    loadCurrency();
    loadPaymentTerms();
    loadShippingTerms();
    loadBankAccount();
    loadBank();
    loadInvoice()
});
function loadInvoice() {
    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
        if (param.length == 2) {
            console.log('view');
            $('#btnSave').hide();
        } else {
            console.log('edit ');
            $('#btnSave').text('Update');
        }
    }
    if (id) {
        $.ajax({
            type: "GET",
            url: "/selling/salesInvoiceConfigure/loadInvoice/" + id,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            async: false,
            success: function (response) {
                console.log(response);

                if (response.success) {
                    console.log(response.result);
                    var boxes = response.result.boxes;
                    var invoice = response.result.invoice;

                    ExpPlId = Number(invoice.pl_id);
                    $('#hiddenId').val(invoice.id);
                    $('#invoice_number').val(invoice.inv_no);
                    $('#invoice_date').val(invoice.inv_date);
                    $('#due_date').val('');
                    $('#order_number').val(invoice.order_number);
                    $('#po_number').val(invoice.cus_po_number);
                    $('#plumberN').val(invoice.pl_number);
                    $('#ws_id').val(invoice.ws_id);
                    $('#awb_no').val(invoice.awb_no);
                    $('#flight_no').val(invoice.flight_numbers);
                    $('#flight_date').val(invoice.flight_date);
                    $('#shipment_no').val(invoice.shipment_number);
                    $('#Destinatination_name').val(invoice.destination);
                    $('#Customer').val(invoice.consignee_name);
                    $('#consignee_add1').val(invoice.consignee_add_line1);
                    $('#consignee_add2').val(invoice.consignee_add_line2);
                    $('#consignee_city_towm').val(invoice.consignee_add_line3);
                    $('#consignee_postal_code').val(invoice.consignee_add_line4);
                    $('#consignee_country').val(invoice.consignee_add_line5);
                    $('#notify').val(invoice.notify_name);
                    $('#notify_add1').val(invoice.notify_address_line1);
                    $('#notify_add2').val(invoice.notify_address_line2);
                    $('#notify_city_towm').val(invoice.notify_address_line3);
                    $('#notify_postal_code').val(invoice.notify_address_line4);
                    $('#notify_country').val(invoice.notify_address_line5);
                    $('#grn_nos_list').val(invoice.list_of_gen_nos);
                    $('#batch_nos_list').val(invoice.list_of_batch_nos);
                    $('#shipping_term').val(invoice.inv_term);
                    $('#currency').val(invoice.currency_id);
                    $('#defaultCurrRate').val('');
                    $('#baseCurrRate').val(invoice.exchange_rate);
                    $('#bank_account').val(invoice.bank_account_id);
                    $('#bank_name').val(invoice.bank_name);
                    $('#branch').val(invoice.bank_branch_name);
                    $('#account_name').val(invoice.bank_account_name);
                    $('#account_number').val(invoice.bank_account_number);
                    $('#swift_code').val(invoice.swift_code);
                    $('#bank').val(invoice.corresponding_bank);
                    $('#freight_type').val(invoice.freight_rate_type);
                    $('#freightVal').val(invoice.freight_rate);
                    $('#freightTot').val(invoice.freight_value);
                    $('#discountType').val(invoice.discount_type);
                    $('#discountVal').val(invoice.discount_rate);
                    $('#discountTot').val(invoice.discount_amount);
                    $('#payment_term').val(invoice.payment_term);
                    $('#grandtotal').val(invoice.inv_gross_value);
                    $('#inv_comment').val(invoice.inv_comment);

                    CreateBoxArray(boxes);
                    createBoxSummary();
                }

            },
            error: function (error) {
                console.log(error);
            },
        });
    }
}
function loadCurrency() {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/loadCurrency',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.currency_name + ' </option>';
                });
                $('#currency').append(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadShippingTerms() {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/loadShippingTerms',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.title + ' </option>';
                });
                $('#shipping_term').append(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadPls() {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/loadPls',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = [];
                $.each(response.result, function (i, val) {
                    data.push({
                        "thPLNo": val.pl_number,
                        "thPLDate": val.pl_date,
                        "thCustomer": val.Customer,
                        "thNotify": val.notify,
                        "thOrderNo": val.order_number,
                        "thPONo": val.customer_po_no,
                        "thAWBNo": val.awb_no,
                        "id": val.id,
                    });

                    var table = $('#tblModalPackingLists').DataTable();
                    table.clear();
                    table.rows.add(data).draw();
                    $('#modalSelectPL').modal('toggle');

                });

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadExplDetails(id) {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/loadExplDetails/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var details = response.result.PackingListHeader;
                var boxes = response.result.boxes;

                $('#modalSelectPL_plno').val(details.pl_number)
                $('#modalSelectPL_pldate').val(details.pl_date)
                $('#modalSelectPL_orderNum').val(details.order_number)
                $('#modalSelectPL_orderDate').val(details.order_date)
                $('#modalSelectPL_Customer').val(details.Customer)
                $('#modalSelectPL_Notify').val(details.notify)

                var data = [];
                $.each(boxes, function (i, val) {
                    data.push({
                        "thProduct": val.item_name,
                        "thQty": val.qty,
                        "thNetWeight": val.box_net_weight,
                        "thGrossWeight": val.box_gross_weight,
                    });

                    var table = $('#tblModalPackingListDetails').DataTable();
                    table.clear();
                    table.rows.add(data).draw();
                });

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function Expl_is_selected() {
    var bool = false;
    if (ExpPlId == undefined) {
        toastr.warning("Please select a  Packing List!");
        bool = false;
    } else {
        bool = true;
    }
    return bool;
}
function AddPl() {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/AddPl/' + ExpPlId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var details = response.result.PackingListHeader
                    , boxes = response.result.boxes
                    , defaultCurr = response.result.defaultCurr;
                if (defaultCurr != null) {
                    $('#invoice_date').val(getToday());
                    $('#due_date').val(getToday());
                    $('#order_number').val(details.order_number);
                    $('#po_number').val(details.customer_po_no);
                    $('#plumberN').val(details.pl_number);
                    $('#ws_id').val(details.ws_id);
                    $('#awb_no').val(details.awb_no);
                    $('#flight_no').val(details.flight_no);
                    $('#flight_date').val(details.flight_date);
                    $('#shipment_no').val(details.shipment_no);
                    $('#Destinatination_name').val(details.Destinatination_name);
                    $('#Customer').val(details.Customer);
                    $('#notify').val(details.notify);
                    $('#consignee_add1').val(details.consignee_add1);
                    $('#consignee_add2').val(details.consignee_add2);
                    $('#consignee_city_towm').val(details.consignee_city_towm);
                    $('#consignee_postal_code').val(details.consignee_postal_code);
                    $('#consignee_country').val(details.consignee_country);
                    $('#notify_add1').val(details.notify_add1);
                    $('#notify_add2').val(details.notify_add2);
                    $('#notify_city_towm').val(details.notify_city_towm);
                    $('#notify_country').val(details.notify_country);
                    $('#notify_postal_code').val(details.notify_postal_code);
                    $('#grn_nos_list').val(details.grn_nos_list);
                    $('#batch_nos_list').val(details.batch_nos_list);
                    $('#currLable').html(defaultCurr.currency_code);
                    $('#defaultCurrRate').val(defaultCurr.exchange_rate);
                    CreateBoxArray(boxes);
                    createBoxSummary();

                    $('#modalSelectPL').modal('toggle');
                } else {
                    toastr.error("Please set exchange rate for the default currancy first !!")
                }
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });

}
function CreateBoxArray(data) {
    boxArray = []
    $.each(data, function (i, val) {
        boxArray.push({
            'prod_id': val.prod_id,
            'id': val.id,
            'pl_id': val.pl_id,
            'item_name': val.item_name,
            'Item_Code': val.Item_Code,
            'box_no': val.box_no,
            'box_gross_weight': val.box_gross_weight,
            'box_net_weight': val.box_net_weight,
            'unitPrice': Number(val.unit_rate_invoice_currency),
        });
        //keep a coppy of original box array for reset purpase
        boxArrayCopy.push({
            'prod_id': val.prod_id,
            'id': val.id,
            'pl_id': val.pl_id,
            'item_name': val.item_name,
            'Item_Code': val.Item_Code,
            'box_no': val.box_no,
            'box_gross_weight': val.box_gross_weight,
            'box_net_weight': val.box_net_weight,
            'unitPrice': Number(val.unit_rate_invoice_currency),
        });
    });
    console.log(boxArray)

}
function createBoxSummary() {
    var arrSummary = [];
    var rowNum = 1;

    $.each(boxArray, function (i, val) {
        var productCode = val.Item_Code;
        var productName = val.item_name;
        var qty = 1;
        var box_net_weight = val.box_net_weight;
        var box_gross_weight = val.box_gross_weight;
        var unitPrice = val.unitPrice;
        var edit = '<button type="button" class="btn btn-primary btn-sm mr-1" onclick="editBoxes(' + val.prod_id + ',' + val.unitPrice + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'
        // var del = '<button class="btn btn-danger btn-sm mr-1" ><i class="fa fa-trash" aria-hidden="true"></i></button>'

        if (!arrSummary.length == 0) {
            for (let i = 0; i < arrSummary.length; i++) {
                if (arrSummary[i]["prodId"] == val.prod_id && Number(arrSummary[i]["thRate"]) == Number(val.unitPrice)) {
                    qty = Number(arrSummary[i]["thBoxesQty"]) + 1;
                    box_net_weight = Number(arrSummary[i]["thNetWg"]) + Number(box_net_weight)
                    box_gross_weight = Number(arrSummary[i]["thGrossWg"]) + Number(box_gross_weight)

                    arrSummary.splice(i, 1); //This removes 1 item from the array starting at indexValueOfArray
                    //because this item is alredy added above line remove the previously added item
                }
            }
        }

        arrSummary.push({
            thNo: rowNum,
            thProdCode: productCode,
            thproductName: productName,
            thBoxesQty: qty,
            thNetWg: box_net_weight.toFixed(3),
            thGrossWg: box_gross_weight.toFixed(3),
            thRate: unitPrice,
            thTotalPrice: (Number(unitPrice) * Number(box_net_weight) * Number(qty)).toFixed(2),
            thAction: edit,
            prodId: val.prod_id
        });
        rowNum++
    });
    var table = $('#tblInvoiceItems').DataTable();
    table.clear();
    table.rows.add(arrSummary).draw();

    calTotBoxAndNotPricedBoxes()
    createFinalSummary();
}
function getToday() {
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
    return output;
}
function editBoxes(prod_id, unitPrice) {
    clearEditRawModel()

    var arr = [];
    var itemName = '';
    var rate = 0;
    $.each(boxArray, function (i, val) {
        if (Number(val.prod_id) == Number(prod_id) && Number(val.unitPrice) == Number(unitPrice)) {
            // var edit = '<button class="btn btn-primary btn-sm mr-1" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'

            var btnRemove = '<button type="button"  class="btn btn-danger btn-sm" onclick="removeBox(' + val.box_no + ')"><i class="fa fa-minus "></i></button>'
            arr.push({
                'thBoxNo': val.box_no,
                'thNetWeight': val.box_net_weight,
                'thGrossWeight': val.box_gross_weight,
                'thActions': btnRemove,
            })
            itemName = val.item_name;
            rate = val.unitPrice;
        }
    });
    var table = $('#tblSelectedBoxDetails').DataTable();
    table.clear();
    table.rows.add(arr).draw();

    $('#modalEditRow_itemName').val(itemName);
    $('#modalEditRow_Rate').val(rate);
    calTotRawEditModel(rate)
    calQtyAndWeightRawEditModel();

    $('#modalEditRow').modal('toggle');

}
function calQtyAndWeightRawEditModel() {
    var selWeight = 0;
    var selQty = 0;
    var table = $('#tblSelectedBoxDetails').DataTable();

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        selWeight = Number(selWeight) + Number(data.thNetWeight)
        selQty++
    });

    $('#modalEditRow_selQty').val(selQty);
    $('#modalEditRow_selWeight').val(selWeight);
}
function calTotRawEditModel(rate) {
    var weight = $('#modalEditRow_selWeight').val();
    var qty = $('#modalEditRow_selQty').val();

    var tot = Number(weight) * Number(rate) * Number(qty);
    $('#modalEditRow_tot').val(tot.toFixed(2));
}
function updateRate() {
    var rate = $('#modalEditRow_Rate').val();
    var table = $('#tblSelectedBoxDetails').DataTable();

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        for (let i = 0; i < boxArray.length; i++) {
            if (Number(data.thBoxNo) == Number(boxArray[i]['box_no'])) {
                boxArray[i]['unitPrice'] = rate
            }
        }
    });
    createBoxSummary();
    $('#modalEditRow').modal('toggle');

}
function removeBox(boxNo) {
    var table1 = $('#tblSelectedBoxDetails').DataTable();
    var table = $('#tblDeSelectedBoxDetails').DataTable();

    var arrSelected = [];
    var arrDeSelected = [];
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        var btnadd = '<button type="button"  class="btn btn-success btn-sm"  onclick="addBox(' + data.thBoxNo + ')"><i class="fa fa-plus" aria-hidden="true"></i></button>'


        arrDeSelected.push({
            'thBoxNo': data.thBoxNo,
            'thNetWeight': data.thNetWeight,
            'thGrossWeight': data.thGrossWeight,
            'thActions': btnadd,
        })

    });
    table1.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if (Number(data.thBoxNo) == Number(boxNo)) {
            var btnadd = '<button type="button"  class="btn btn-success btn-sm"  onclick="addBox(' + data.thBoxNo + ')"><i class="fa fa-plus" aria-hidden="true"></i></button>'

            arrDeSelected.push({
                'thBoxNo': data.thBoxNo,
                'thNetWeight': data.thNetWeight,
                'thGrossWeight': data.thGrossWeight,
                'thActions': btnadd,
            })
        } else {
            var btnRemove = '<button type="button"  class="btn btn-danger btn-sm" onclick="removeBox(' + data.thBoxNo + ')"><i class="fa fa-minus "></i></button>'

            arrSelected.push({
                'thBoxNo': data.thBoxNo,
                'thNetWeight': data.thNetWeight,
                'thGrossWeight': data.thGrossWeight,
                'thActions': btnRemove,
            })
        }

    });
    table1.clear();
    table1.rows.add(arrSelected).draw();

    table.clear();
    table.rows.add(arrDeSelected).draw();
}
function addBox(boxNo) {
    var table = $('#tblSelectedBoxDetails').DataTable();
    var table1 = $('#tblDeSelectedBoxDetails').DataTable();

    var arrSelected = [];
    var arrDeSelected = [];
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        var btnRemove = '<button type="button"  class="btn btn-danger btn-sm" onclick="removeBox(' + data.thBoxNo + ')"><i class="fa fa-minus "></i></button>'
        arrDeSelected.push({
            'thBoxNo': data.thBoxNo,
            'thNetWeight': data.thNetWeight,
            'thGrossWeight': data.thGrossWeight,
            'thActions': btnRemove,
        })

    });
    table1.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if (Number(data.thBoxNo) == Number(boxNo)) {
            var btnRemove = '<button type="button"  class="btn btn-danger btn-sm" onclick="removeBox(' + data.thBoxNo + ')"><i class="fa fa-minus "></i></button>'
            arrDeSelected.push({
                'thBoxNo': data.thBoxNo,
                'thNetWeight': data.thNetWeight,
                'thGrossWeight': data.thGrossWeight,
                'thActions': btnRemove,
            })
        } else {
            var btnadd = '<button type="button"  class="btn btn-success btn-sm"  onclick="addBox(' + data.thBoxNo + ')"><i class="fa fa-plus" aria-hidden="true"></i></button>'

            arrSelected.push({
                'thBoxNo': data.thBoxNo,
                'thNetWeight': data.thNetWeight,
                'thGrossWeight': data.thGrossWeight,
                'thActions': btnadd,
            })
        }

    });
    table1.clear();
    table1.rows.add(arrSelected).draw();

    table.clear();
    table.rows.add(arrDeSelected).draw();
}
function calTotBoxAndNotPricedBoxes() {
    var totalBoxes = 0;
    var notPricedBoxes = 0;

    $.each(boxArray, function (i, val) {
        if (Number(val.unitPrice) == 0) {
            notPricedBoxes++
        }
        totalBoxes++
    });
    $('#lbl_totalBoxes').html(totalBoxes)
    $('#lbl_notPricedBoxes').html(notPricedBoxes)

}
function createFinalSummary() {
    var grossWeight = 0
    var netWeight = 0
    var price = 0

    var table = $('#tblInvoiceItems').DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        grossWeight = Number(grossWeight) + Number(data.thGrossWg);
        netWeight = Number(netWeight) + Number(data.thNetWg);
        price = Number(price) + Number(data.thTotalPrice);
    });
    $('#totGrossWeight').val(grossWeight.toFixed(3));
    $('#totNetWeight').val(netWeight.toFixed(3));
    $('#totPriice').val(price.toFixed(2));
    calFreight();
}
function calFreight() {
    var FreightType = $('#freight_type').val()
        , freightVal = $('#freightVal').val()
        , grossWeight = $('#totGrossWeight').val()
        , netWeight = $('#totNetWeight').val()
        , totPriice = $('#totPriice').val()
        , freight = 0;

    switch (Number(FreightType)) {
        case 1:
            freight = Number(grossWeight) * Number(freightVal)
            break;
        case 2:
            freight = Number(netWeight) * Number(freightVal)
            break;
        case 3:
            freight = (Number(totPriice) / 100) * Number(freightVal)
            break;
        case 4:
            freight = Number(freightVal);
            break;
    }

    $('#freightTot').val(freight.toFixed(2));
    calDiscount();
}
function calDiscount() {
    var discountType = $('#discountType').val();
    var discountVal = $('#discountVal').val();
    var tot = Number($('#freightTot').val()) + Number($('#totPriice').val());

    var discount = 0;
    switch (Number(discountType)) {
        case 1:
            discount = (Number(tot) / 100) * Number(discountVal)
            break;
        case 2:
            discount = Number(discountVal);
            break;
    }
    $('#discountTot').val(discount.toFixed(2));
    calGrandTot();
}
function calGrandTot() {
    var totPriice = $('#totPriice').val();
    var freight = $('#freightTot').val();
    var discount = $('#discountTot').val();
    var grandTot = (Number(totPriice) + Number(freight)) - Number(discount)

    $('#grandtotal').val(grandTot.toFixed(2));

}
function loadPaymentTerms() {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/loadPaymentTerms',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" >-select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.title + ' | ' + value.description + ' </option>';
                });
                $('#payment_term').append(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function clearEditRawModel() {
    $('#modalEditRow_itemName').val('')
    $('#modalEditRow_selQty').val('')
    $('#modalEditRow_selWeight').val('')
    $('#modalEditRow_Rate').val('')
    $('#modalEditRow_tot').val('')

    var table1 = $('#tblSelectedBoxDetails').DataTable();
    table1.clear();
    table1.draw();

    var table = $('#tblDeSelectedBoxDetails').DataTable();
    table.clear();
    table.draw();
}
function loadBaseCurrency(currencyId) {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/loadBaseCurrency/' + currencyId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#baseCurrRate').val(response.result.exchange_rate);
                $('#basscurrLable').html(response.result.currency_code);
            }
            else {
                $('#baseCurrRate').val('');
                toastr.error('Exchange Rate Not Found')
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });

}
function loadBankAccount() {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/loadBankAccount',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" >-select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.account_title + ' </option>';
                });
                $('#bank_account').append(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadBankAccountDetails(AccountId) {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/loadBankAccountDetails/' + AccountId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result;
                $('#bank_name').val(data.bank_name);
                $('#branch').val(data.branch);
                $('#account_name').val(data.account_name);
                $('#account_number').val(data.account_number);
                $('#swift_code').val(data.swift_code);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadBank() {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoiceConfigure/loadBank',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" >-select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.bank_name + ' </option>';
                });
                $('#bank').append(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function appendInvData(data) {
    data.append('pl_id', ExpPlId);
    $.each(boxArray, function (i, val) {
        data.append('boxes[]', JSON.stringify(val));
    });

}
function save(data) {
    $.ajax({
        type: "POST",
        url: "/selling/salesInvoiceConfigure/save",
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
                location.href = parent_url;
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
        url: "/selling/salesInvoiceConfigure/update",
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
                location.href = parent_url;
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

///////////////////////////////////////////////////////////
/////////////////////// REPORTING /////////////////////////
///////////////////////////////////////////////////////////

function getReport(reportType, EplId) {
    $.ajax({
        type: 'GET',
        url: '/mnu/packingDetailsConfigure/getReport/' + reportType + '/' + EplId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                window.open(response.result.url, '_blank');
            } else {
                toastr.warning(response.message)
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}


//########################################################
//###################### Reporting #######################
//########################################################
function getReport(reportId) {
    var invNo = 1;
    console.log('Report No : ', reportId)
    console.log('Invoice No : ', invNo)
    if (!reportId == '') {
        $.ajax({
            type: 'GET',
            url: '/selling/salesInvoiceConfigure/getReport/' + reportId + '/' + invNo,
            async: false,
            success: function (response) {
                if (response.success) {
                    window.open(response.result.url, '_blank');
                } else {
                    toastr.warning(response.message)
                }
            }, error: function (data) {
                console.log(data);
                console.log('something went wrong');
            }
        });
    } else {
        toastr.warning('Sorry! Report Not Available!')
    }

}

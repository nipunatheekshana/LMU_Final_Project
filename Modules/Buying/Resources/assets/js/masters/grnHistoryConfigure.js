console.log('grnHistoryConfigure .js loadimng');

var GRNno = 0;

$(document).ready(function () {

    //prevent model from closing clicking outside the model

    // pie chart bigins
    var colors = {
        primary: $('.colors .bg-primary').css('background-color'),
        primaryLight: $('.colors .bg-primary-bright').css('background-color'),
        secondary: $('.colors .bg-secondary').css('background-color'),
        secondaryLight: $('.colors .bg-secondary-bright').css('background-color'),
        info: $('.colors .bg-info').css('background-color'),
        infoLight: $('.colors .bg-info-bright').css('background-color'),
        success: $('.colors .bg-success').css('background-color'),
        successLight: $('.colors .bg-success-bright').css('background-color'),
        danger: $('.colors .bg-danger').css('background-color'),
        dangerLight: $('.colors .bg-danger-bright').css('background-color'),
        warning: $('.colors .bg-warning').css('background-color'),
        warningLight: $('.colors .bg-warning-bright').css('background-color'),
    };
    var char1 = $('#chartjs_three');
    var data = {
        labels: ['null'],
        datasets: [
            {
                lable: 'team',
                data: [1,],
                backgroundColor: [
                    colors.primary,
                    colors.secondary,
                    colors.success,
                    colors.warning,
                    colors.info
                ]
            }
        ]
    }
    var chart1 = new Chart(char1, {
        type: 'pie',
        data: data,
        options: {

        }
    })
    // pie chart ends


    var tableFishDetails = $('#tableFishDetails').DataTable({
        scrollY: 800,
        scrollX: true,
        paging: false,
        info: false,
        scrollCollapse: true,

        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '0px')
                }
            },
            // {
            //     "targets": [],
            //     "visible": false,
            // },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                "className": "text-center",

            }
        ],
        "createdRow": function (row, data, dataIndex) {
            if (data['thStatus'] == '<span class="badge badge-warning">Hold</span>') {
                $(row).addClass('bg-warning-bright');
            }
            if (data['thStatus'] == '<span class="badge badge-danger">Rejected</span>') {
                $(row).addClass('bg-danger-bright');
            }
        },
        "order": [],
        "columns": [
            { "data": "action" },
            { "data": "thFishNo" },
            { "data": "thFishBarcode" },
            { "data": "thFishType" },
            { "data": "thPresentationType" },
            { "data": "thPayGrade" },
            { "data": "thQualityQrade" },
            { "data": "thSize" },
            { "data": "thWeight" },
            { "data": "thStatus" },
            { "data": "thProductionMode" },
            { "data": "thProductionWeight" },
            { "data": "thRecovery" },
            { "data": "thExportWeight" },
            { "data": "thDamage" },
            { "data": "thTemperature" },
            { "data": "thFishSelector" },
            { "data": "thWorkstation" },
            { "data": "MobileUser" },
        ],
    });
    var tableSummaryFishType = $('#tableSummaryFishType').DataTable({
        scrollY: 300,
        scrollX: true,
        paging: false,
        info: false,
        searching: false,
        scrollCollapse: true,
        select: {
            style: 'single'
        },

        'columnDefs': [
            {
                "targets": [11],
                "visible": false,
            },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thFishType" },
            { "data": "thQty" },
            { "data": "thWeight" },
            { "data": "thProcessedQty" },
            { "data": "thProcessedWeight" },
            { "data": "thUnprocessedQty" },
            { "data": "thUnprocessedWeight" },
            { "data": "thTransferQty" },
            { "data": "thTransferWeight" },
            { "data": "thRejecrQty" },
            { "data": "thRejecrWeight" },
            { "data": "fishCode" },

        ],
    });
    var tableFishSize = $('#tableFishSize').DataTable({
        paging: false,
        info: false,
        searching: false,
        'columnDefs': [
            // {
            //     "targets": [],
            //     "visible": false,
            // },
            {
                "targets": [0, 1, 2],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thSize" },
            { "data": "thSizeCode" },
            { "data": "action" },

        ],
    });
    var tableProductionDetails = $('#tableProductionDetails').DataTable({
        paging: false,
        info: false,
        searching: false,
        'columnDefs': [
            // {
            //     "targets": [],
            //     "visible": false,
            // },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thNo" },
            { "data": "thPcsId" },
            { "data": "thItemNmae" },
            { "data": "thCustomer" },
            { "data": "thWeight" },
            { "data": "thOperator" },
            { "data": "thTimeSupervisor" },
            { "data": "thTimmer" },
            { "data": "thProductiondateandtime" },
        ],
    });
    var tableGRNPricing = $('#tableGRNPricing').DataTable({

        paging: false,
        info: false,
        select: {
            style: 'single'
        },
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '2px')
                }
            },
            {
                "targets": [1, 2, 3, 4, 5, 6, 7],
                "className": "text-center",

            },
            {
                "targets": [8, 9],
                "visible": false,
            },

        ],
        "order": [],
        "columns": [
            { "data": "thFishType" },
            { "data": "thPresentation" },
            { "data": "thSuppliergrade" },
            { "data": "thSizeCode" },
            { "data": "thQty" },
            { "data": "thTotalWeight" },
            { "data": "thUnitPrice" },
            { "data": "thTotalPrice" },
            { "data": "fish_type_id" },
            { "data": "item_size_id" },

        ],
    });
    var tableWaSTAGE = $('#tableWatage').DataTable({
        responsive: true,
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '2px')
                }
            },
            {
                "targets": [0, 1, 2, 3, 4],
                "className": "text-center",

            }],
        "order": [],
        "columns": [
            { "data": "thItemCode", 'width': "20%" },
            { "data": "thItemName", 'width': "40%" },
            { "data": "thWarehouse", 'width': "40%" },
            { "data": "thTotalWeight", 'width': "40%" },
            { "data": "thTotalValue", 'width': "40%" },

        ],
    });
    $('#tableSearch').keyup(function () {
        tableFishDetails.search($('#tableSearch').val()).draw();
    })
    tableSummaryFishType.on('select', function (e, dt, type, indexes) {
        if (type === 'row') {
            loadFishGradeData(chart1, indexes[0])
            // console.log()
        }

    });
    tableGRNPricing.on('select', function (e, dt, type, indexes) {
        if (type === 'row') {
            loadIndividualPricing(indexes[0])
            // console.log()
        }

    });

    $('#type').change(function () {
        loadFishDetailsTable();
    });
    $('#presentation').change(function () {
        loadFishDetailsTable();
    });
    $('#size').change(function () {
        loadFishDetailsTable();
    });
    $('#pay_grade').change(function () {
        loadFishDetailsTable();
    });
    $('#boat').change(function () {
        loadBoatDetails(this.value);
    });
    $('#quality_grade').change(function () {
        loadFishDetailsTable();
    });
    $('#modelFishSizeTable_FishSpecies').change(function () {
        LoadSizeTable();
        getNewMinValue();

    });
    $('#modelFishSizeTable_maxValue').change(function () {
        if (this.value != '') {
            validateMInMAx(this.value);
        }
    });
    $('#modelGroupPricing_payCurrancy').change(function () {
        getExchangeRateToDate(this.value);
    });

    $('#btnAdminChanges').click(function () {
        loadSuppliers();
        loadBoats();
        loadAdminDetails();
    });
    $('#btnUpdateAdminChanges').click(function () {
        var form = $('#FrmModelAdminChanges').get(0);
        var data = new FormData(form);
        data.append('GRNno', GRNno);//append GrnNo
        UpdateBoatDetails(data)
    });
    $('#btn_FishDetailModel_Update').click(function () {
        var form = $('#frmFishDetailUpdate').get(0);
        var data = new FormData(form);
        for (var pair of data.entries()) {
            console.log(pair[0] + ' => ' + pair[1]);
        }
        UpdateFishDetails(data)
    });
    $('#btnSizeTable').click(function () {
        loadResiverdFishSpecies()
    });
    $('#modelFishSizeTable_BtnAdd').click(function () {
        var form = $('#modelFishSizeTable_Form').get(0);
        var data = new FormData(form);

        saveSize(data);
    });
    $('#btnUpdateGrnTableSize').click(function () {
        loadResiverdFishSpecies()
    });
    $('#btnStatusSetting').click(function () {
        $('#modelStatusSetting').modal('toggle');
    });
    $('#modelStatusSetting_Receive_btnHold').click(function () {
        var form = $('#modelStatusSetting_form').get(0);
        var data = new FormData(form);
        data.append('type', 'receiveHold');
        SetStatus(data)
    });
    $('#modelStatusSetting_Receive_btnClose').click(function () {
        var form = $('#modelStatusSetting_form').get(0);
        var data = new FormData(form);
        data.append('type', 'receiveClose');
        SetStatus(data)
    });
    $('#modelStatusSetting_Finance_btnClose').click(function () {
        var form = $('#modelStatusSetting_form').get(0);
        var data = new FormData(form);
        data.append('type', 'financeClose');
        SetStatus(data)
    });
    $('#modelStatusSetting_Voucher_btnClose').click(function () {
        var form = $('#modelStatusSetting_form').get(0);
        var data = new FormData(form);
        data.append('type', 'voucherceClose');
        SetStatus(data)
    });
    $('#btnGrnPriceing').click(function () {
        loadGrnPricingTable()
    });
    $('#btn_modelGrnPriceing_groupPricing').click(function () {
        $('#modelGroupPricing').modal('toggle');
    });
    $('#modelGroupPricing_btn_update').click(function () {
        GroupPricing();
    });
    $('#modelIndividualPricing_btnUpdate').click(function () {
        IndividualPricing();
    });
    $('#modelGrnPriceing_btnSave').click(function () {
        // var data = new FormData();
        if (validatePricingTable()) {
            data = createGRNPricingSaveData();
            for (var pair of data.entries()) {
                console.log(pair[0] + ' => ' + pair[1]);
            }
            saveGRNPricing(data);
        }

    });
    $('#btnReport').click(function () {
        getReport();
    });
    $('#btnWastage').click(function () {
        loadWastageModleData('auto');
    });
    $('#btAddWastage').click(function () {
        loadAddWastageModleData();
    });
    $('#modelAddWastage_btnAdd').click(function () {
        saveWastage();
    });
    // loadTypes();

    // chartjs_three(['null'],[1]);

    initG1(100, 50);
    initG2(100, 70);
    loadGrnDetails();
    loadFishDetailsTable();
    loadFishDetailSummary();
    loadFishGradeData(chart1, 0)//load the first fish grade data to the chart
    loadPresentation();
    loadSize();
    loadPayGrade();
    loadQualityGrade();
    loadTypesInTable();
    loadCurrancy();
});


function initG1(maxVal, value) {
    // JustGage start
    var valueFontColor = "black";

    if ($('body').hasClass('dark')) {
        valueFontColor = "white";
    }

    var colors = {
        primary: $('.colors .bg-primary').css('background-color'),
        danger: $('.colors .bg-danger').css('background-color'),
    };


    var g1 = new JustGage({
        id: "g1",
        value: value,
        min: 0,
        max: maxVal,
        label: "Loin Yield",
        // title: "Compleated Quantity",
        // symbol: '%',
        pointer: true,
        pointerOptions: {
            toplength: -15,
            bottomlength: 10,
            bottomwidth: 12,
            color: colors.primary,
            stroke: colors.primary,
            stroke_width: 3,
            stroke_linecap: 'round'
        },
        gaugeWidthScale: 0.3,
        counter: true,
        relativeGaugeSize: true,
        valueFontColor: valueFontColor
    });
    // Delete the extra added element when the page is resized.
    $('#g1 > svg + svg').remove();

    // setInterval(function () {
    //     g1.refresh(getRandomInt(0, 400));
    // }, 3000);

}
function initG2(maxVal, value) {
    // JustGage start
    var valueFontColor = "black";

    if ($('body').hasClass('dark')) {
        valueFontColor = "white";
    }

    var colors = {
        primary: $('.colors .bg-primary').css('background-color'),
        danger: $('.colors .bg-danger').css('background-color'),
    };


    var g2 = new JustGage({
        id: "g2",
        value: value,
        min: 0,
        max: maxVal,
        label: "Overall Yeild",
        // title: "Compleated Weight",
        // symbol: '%',
        pointer: true,
        pointerOptions: {
            toplength: -15,
            bottomlength: 10,
            bottomwidth: 12,
            color: colors.primary,
            stroke: colors.primary,
            stroke_width: 3,
            stroke_linecap: 'round'
        },
        gaugeWidthScale: 0.3,
        counter: true,
        relativeGaugeSize: true,
        valueFontColor: valueFontColor
    });
    // Delete the extra added element when the page is resized.
    $('#g2 > svg + svg').remove();

    // setInterval(function () {
    //     g2.refresh(getRandomInt(0, 400));
    // }, 300);
}
function loadGrnDetails() {

    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
    }
    if (id) {
        $.ajax({
            type: "GET",
            url: "/buying/grnHistoryConfigure/loadGrnDetails/" + id,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            async: false,
            beforeSend: function () {

            },
            success: function (response) {
                console.log(response);

                if (response.success) {
                    var data = response.result
                    GRNno = id;
                    $('#header_grnNo').html(data.grnno);
                    $('#header_date').html(data.grndate);
                    $('#header_batchNo').html(data.batch_no);
                    $('#header_supplier_no').html(data.supID);
                    $('#header_Supplier').html(data.supplier_name);
                    $('#header_BoatReg').html(data.BoatRegNo);
                    $('#header_BoatName').html(data.BoatName);
                    $('#header_FishQty').html(Number(data.totalQty));
                    $('#header_fishWeight').html(data.totFishWeight);
                    $('#header_proc_qty').html(Number(data.processedPcs));
                    $('#header_Proc_Weight').html();
                    $('#header_unProcQty').html(Number(data.unprocessedPCs));
                    $('#header_unprocWeight').html();
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
function getFilterValues() {
    var type = $('#type').val();
    var presentation = $('#presentation').val();
    var size = $('#size').val();
    var pay_grade = $('#pay_grade').val();
    var quality_grade = $('#quality_grade').val();
    return {
        'type': type,
        'presentation': presentation,
        'size': size,
        'pay_grade': pay_grade,
        'quality_grade': quality_grade,
        'GRNNo': GRNno
    }
}
function loadFishDetailsTable() {
    var data = getFilterValues();
    $.ajax({
        type: 'POST',
        url: '/buying/grnHistoryConfigure/loadFishDetailsTable',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        async: false,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                $.each(response.result, function (i, val) {
                    // var production = '<button type="button" class="btn btn-success btn-sm mr-2" onclick="LoadProductionDetail(' + Number(val.lot_serial_no) + ')">Production</button>'
                    // var edit = `<button type="button" class="btn btn-danger btn-sm" onclick="LoadFishDetails(` + Number(val.lot_grnno) + `,` + Number(val.lot_serial_no) + `)">Edit</button>`
                    var edit = `<i class="ti-pencil-alt text-danger">`
                    var production = `<i class="ti-more text-success mr-3">`
                    var action = `<div class="dropdown m-0">
                                        <a href="#" data-toggle="dropdown" class="btn btn-floating"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="ti-more-alt"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a onclick="LoadProductionDetail(` + Number(val.lot_serial_no) + `)" class="dropdown-item">Production Details</a>
                                            <a onclick="LoadFishDetails(` + Number(val.lot_grnno) + `,` + Number(val.lot_serial_no) + `)" class="dropdown-item">Edit Item</a>
                                        </div>
                                    </div>`
                    // Voucher Status Badge Setting
                    var item_Status = '';
                    if (val.item_Status == 0) {
                        item_Status = `<span class="badge badge-info">Received</span>`
                    } else if (val.item_Status == 1) {
                        item_Status = `<span class="badge badge-success">Processed</span>`
                    } else if (val.item_Status == 2) {
                        item_Status = `<span class="badge badge-warning">Hold</span>`
                    } else if (val.item_Status == 3) {
                        item_Status = `<span class="badge badge-danger">Rejected</span>`
                    } else if (val.item_Status == 4) {
                        item_Status = `<span class="badge badge-secondary">Transferred</span>`
                    }



                    data.push({
                        "action": action,
                        "thFishNo": val.lot_serial_no,
                        "thFishBarcode": val.lot_barcode,
                        "thFishType": val.FishCode,
                        "thPresentationType": val.presentation,
                        "thPayGrade": val.supplier_grade,
                        "thQualityQrade": val.quality_grade,
                        "thSize": val.item_size,
                        "thWeight": val.FishWeight,
                        "thStatus": item_Status,
                        "thProductionMode": '',
                        "thProductionWeight": '',
                        "thRecovery": '',
                        "thExportWeight": '',
                        "thDamage": val.dmg_weight,
                        "thTemperature": val.fish_temperature,
                        "thFishSelector": val.fish_selector,
                        "thWorkstation": val.WorkstationName,
                        "MobileUser": val.mobile_user,
                    });
                });
                var table = $('#tableFishDetails').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
};
function loadTypesInTable() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadTypesInTable/' + GRNno,
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishCode + ' </option>';
                });
                $('#type').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadPresentation() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadPresentation',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.PrsntName + '" > ' + value.PrsntName + ' </option>';
                });
                $('#presentation').append(html);
                $('#FishDetailModel_presentation_type').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadSize() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadSize/' + GRNno,
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.SizeDescription + ' </option>';
                });
                $('#size').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadPayGrade() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadFishGrade',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.PayFishGrade + '" > ' + value.PayFishGrade + ' </option>';
                });
                $('#pay_grade').append(html);
                $('#FishDetailModel_pay_grade').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadQualityGrade() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadFishGrade',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.QFishGrade + '" > ' + value.QFishGrade + ' </option>';
                });
                $('#quality_grade').append(html);
                $('#FishDetailModel_quality_grade').append(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadFishDetailSummary() {
    var data = getFilterValues();
    $.ajax({
        type: 'POST',
        url: '/buying/grnHistoryConfigure/loadFishDetailSummary',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        async: false,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                $.each(response.result, function (i, val) {
                    data.push({
                        "thFishType": val.fishType,
                        "thQty": val.qty,
                        "thWeight": val.Weight,
                        "thProcessedQty": val.ProcessedQty,
                        "thProcessedWeight": val.ProcessedWeight,
                        "thUnprocessedQty": val.UnProcessedQty,
                        "thUnprocessedWeight": val.UnProcessedWeight,
                        "thTransferQty": val.TransferQty,
                        "thTransferWeight": val.TransferWeight,
                        "thRejecrQty": val.RejectQty,
                        "thRejecrWeight": val.RejectWeight,
                        "fishCode": val.fish_type_id,
                    });
                });
                var table = $('#tableSummaryFishType').DataTable();
                table.clear();
                table.rows.add(data).draw();


            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function loadFishGradeData(chart, rowIndex) {
    var table = $('#tableSummaryFishType').DataTable();
    var fishCode = table.cell(rowIndex, 11).data();
    console.log(fishCode);
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadFishGradeData/' + GRNno + '/' + fishCode,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = [];
                var labels = [];
                $.each(response.result, function (i, val) {
                    data.push(
                        val.weight
                    );
                    labels.push(
                        val.grade
                    );
                });
                chart.data.labels = labels;
                chart.data.datasets[0].data = data;
                chart.update();
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadSuppliers() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadSuppliers',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';

                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.supplier_name + ' </option>';
                });
                $('#supplier').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadBoats() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadBoats',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';

                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.BoatName + ' </option>';
                });
                $('#boat').html(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadAdminDetails() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadAdminDetails/' + GRNno,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#supplier').val(response.result.supplier_id);
                $('#boat').val(response.result.boat_id);
                loadBoatDetails(response.result.boat_id)
                $('#modelAdminChanges').modal('toggle');

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadBoatDetails(boatId) {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadBoatDetails/' + boatId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result;
                $('#skipper_name').val(data.SkipperName);
                $('#licence_no').val(data.LicenseNo);
                $('#licence_expire_date').val(data.LicenseExpDate);
                // $('#skipper_name').val(data.SkipperName);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });

}
function UpdateBoatDetails(data) {

    $.ajax({
        type: 'POST',
        url: '/buying/grnHistoryConfigure/UpdateBoatDetails',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#FrmModelAdminChanges ').trigger("reset");
                $('#modelAdminChanges').modal('toggle');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function LoadFishDetails(grnno, fishNo) {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/LoadFishDetails/' + grnno + '/' + fishNo,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result;
                loadFishSizeTOFIsh(GRNno, data.fish_type_id)
                loadFishSpecies();
                $('#FishDetailModel_grnNoLable').html(data.lot_grnno);
                $('#FishDetailModel_fishtype').val(data.fish_type_id);
                $('#FishDetailModel_sizeCode').val(data.item_size_id);
                $('#FishDetailModel_Weight').val(data.net_weight);
                $('#FishDetailModel_temperature').val(data.fish_temperature);
                $('#FishDetailModel_presentation_type').val(data.presentation);
                $('#FishDetailModel_pay_grade').val(data.supplier_grade);
                $('#FishDetailModel_quality_grade').val(data.quality_grade);
                $('#FishDetailModel_grnNo').val(grnno);
                $('#FishDetailModel_fishNo').val(fishNo);

                $('#modelFishDetailsUpdate').modal('toggle');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function UpdateFishDetails(data) {

    $.ajax({
        type: 'POST',
        url: '/buying/grnHistoryConfigure/UpdateFishDetails',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        processData: false,
        contentType: false,
        // cache: false,
        // timeout: 800000,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#frmFishDetailUpdate ').trigger("reset");
                loadFishDetailsTable();
                loadFishDetailSummary();
                loadTypesInTable();
                $('#modelFishDetailsUpdate').modal('toggle');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function LoadProductionDetail(fishNo) {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/LoadProductionDetail/' + fishNo + '/' + GRNno,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var result = response.result.GRNDetail;
                $('#modelProductionDetail_FishNo').html(result.lot_serial_no);
                $('#modelProductionDetail_GRNNo').html(result.lot_grnno);
                $('#modelProductionDetail_FishType').html(result.FishName);
                $('#modelProductionDetail_BatchNo').html('-');
                $('#modelProductionDetail_GRNdate').html(result.grndate);
                $('#modelProductionDetail_Supplier').html(result.supplier_name);
                $('#modelProductionDetail_FishWeight').html(result.net_weight);
                $('#modelProductionDetail_ProductWeight').html(result.PRWg);
                $('#modelProductionDetail_Recovery').html(result.lot_serial_no);



                var data = [];
                $.each(response.result.ProductionDetailView, function (i, val) {
                    data.push({
                        "thNo": val.PcsNo,
                        "thPcsId": val.PcsID,
                        "thItemNmae": val.item_name,
                        "thCustomer": val.CusName,
                        "thWeight": val.PcsWeight,
                        "thOperator": val.MobUser,
                        "thTimeSupervisor": val.TrimSupCode,
                        "thTimmer": val.TrimmerCode,
                        "thProductiondateandtime": val.PRDateTime,
                    });
                });
                var table = $('#tableProductionDetails').DataTable();
                table.clear();
                table.rows.add(data).draw();

                $('#modelProductionDetail').modal('toggle');

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadFishSizeTOFIsh(GRNno, FishCode) {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadFishSizeTOFIsh/' + GRNno + '/' + FishCode,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';

                $.each(response.result, function (index, value) {
                    html += '<option value="' + value.id + '" > ' + value.SizeDescription + ' </option>';
                });
                $('#FishDetailModel_sizeCode').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadFishSpecies() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadFishSpecies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';

                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishCode + ' </option>';
                });
                $('#FishDetailModel_fishtype').html(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadResiverdFishSpecies() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadResiverdFishSpecies/' + GRNno,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';

                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishCode + ' </option>';
                });
                $('#modelFishSizeTable_FishSpecies').html(html);
                $('#modelFishSizeTable').modal('toggle');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function LoadSizeTable() {
    var fishId = $('#modelFishSizeTable_FishSpecies').val()
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/LoadSizeTable/' + GRNno + '/' + fishId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {

                var data = [];

                $.each(response.result, function (i, val) {
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + val.id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';

                    data.push({
                        "thSize": val.SizeDescription,
                        "thSizeCode": val.SizeCode,
                        "action": dele,

                    });
                });
                var table = $('#tableFishSize').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/buying/grnHistoryConfigure/deleteSize/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                LoadSizeTable();
                getNewMinValue();
            } else {
                toastr.warning(response.message)
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
function getNewMinValue() {
    var fishId = $('#modelFishSizeTable_FishSpecies').val()
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/getNewMinValue/' + GRNno + '/' + fishId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#modelFishSizeTable_minValue').val(response.result);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function validateMInMAx(max) {

    var min = $('#modelFishSizeTable_minValue').val();

    console.log(max)
    if (Number(max) < Number(min)) {
        toastr.warning('Max value is lover than min');
        $('#modelFishSizeTable_maxValue').val('');

        var el = $('#modelFishSizeTable_maxValue');
        el[0].style.border = '1px solid red';
        setTimeout(function () {
            el[0].style.border = '';
        }, 4000);
    }
}
function saveSize(data) {
    $.ajax({
        type: "POST",
        url: "/buying/grnHistoryConfigure/saveSize/" + GRNno,
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
                getNewMinValue();
                LoadSizeTable()

                $('#modelFishSizeTable_maxValue').val('');
                $('#modelFishSizeTable_Discription').val('');
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
function SetStatus(data) {
    $.ajax({
        type: 'POST',
        url: '/buying/grnHistoryConfigure/SetStatus/' + GRNno,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#modelStatusSetting_form ').trigger("reset");
                loadStatus();
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadStatus() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadStatus/' + GRNno,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                //status function Here
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

//########################################################
//###################### GRN Pricing #####################
//########################################################

function loadGrnPricingTable() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadGrnPricingTable/' + GRNno,
        async: false,
        success: function (response) {
            console.log(response)

            if (response.success) {
                //status function Here


                $('#modelGrnPriceing_grn_date').html(response.result.GRN.grndate)
                $('#modelGrnPriceing_grn_no').html(response.result.GRN.grnno)
                $('#modelGrnPriceing_supplier').html(response.result.GRN.supplier_name)
                $('#modelGrnPriceing_pricingDateAndTime').val(response.result.date)
                $('#modelGrnPriceing_PricingUser').val(response.result.user)
                $('#modelGroupPricing_payCurrancy').val(response.result.localCurrancy.id)
                console.log(response.result.localCurrancy)

                var data = [];
                $.each(response.result.GRNDetail, function (i, val) {

                    data.push({
                        "thFishType": val.FishName,
                        "thPresentation": val.presentation,
                        "thSuppliergrade": val.supplier_grade,
                        "thSizeCode": val.SizeDescription,
                        "thQty": val.qty,
                        "thTotalWeight": val.Weight,
                        "thUnitPrice": '',
                        "thTotalPrice": '',
                        "fish_type_id": val.fish_type_id,
                        "item_size_id": val.item_size_id

                    });
                });
                var table = $('#tableGRNPricing').DataTable();
                table.clear();
                table.rows.add(data).draw();

                calTotFishWeight()

                $('#modelGrnPriceing').modal('toggle');

                var any = '<option value="*" > -Any- </option>'

                var fishType = "";
                fishType += any;
                $.each(response.result.fishTypes, function (index, value) {

                    fishType += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                $('#modelGroupPricing_fishType').html(fishType);

                var Presentations = "";
                Presentations += any;
                $.each(response.result.Presentations, function (index, value) {

                    Presentations += '<option value="' + value.presentation + '" > ' + value.presentation + ' </option>';
                });
                $('#modelGroupPricing_presentation').html(Presentations);

                var SupplierGrade = "";
                SupplierGrade += any;
                $.each(response.result.SupplierGrade, function (index, value) {

                    SupplierGrade += '<option value="' + value.supplier_grade + '" > ' + value.supplier_grade + ' </option>';
                });
                $('#modelGroupPricing_grade').html(SupplierGrade);

                var Size = "";
                Size += any;
                $.each(response.result.Size, function (index, value) {

                    Size += '<option value="' + value.id + '" > ' + value.SizeDescription + ' </option>';
                });
                $('#modelGroupPricing_size').html(Size);



            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function calTotFishWeight() {
    var table = $('#tableGRNPricing').DataTable();
    var totWeight = 0
    table.rows().every(function () {
        var data = this.data();
        totWeight = totWeight + Number(data.thTotalWeight)
    });
    $('#modelGrnPriceing_TotalFishWeight').val(totWeight)

}
function GroupPricing() {
    var price = $('#modelGroupPricing_price').val();
    var fishType = $('#modelGroupPricing_fishType').val();
    var presentation = $('#modelGroupPricing_presentation').val();
    var grade = $('#modelGroupPricing_grade').val();
    var size = $('#modelGroupPricing_size').val();

    if (!price == '') {

        var table = $('#tableGRNPricing').DataTable();
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            var update = true;

            if (validatePricingConditions(data.fish_type_id, fishType) == false) {
                update = false;
            }
            if (validatePricingConditions(data.thPresentation, presentation == false)) {
                update = false;
            }
            if (validatePricingConditions(data.thSuppliergrade, grade) == false) {
                update = false;
            }
            if (validatePricingConditions(data.item_size_id, size) == false) {
                update = false;
            }

            if (update) {
                var totWeight = data.thTotalWeight;
                var totPrice = Number(totWeight) * Number(price);

                this.cell(rowIdx, 6).data(price);
                this.cell(rowIdx, 7).data(totPrice);
            }
        });
        calGroValue();
        $('#modelGroupPricing_price').val('');
        $('#modelGroupPricing_fishType').val('*');
        $('#modelGroupPricing_presentation').val('*');
        $('#modelGroupPricing_grade').val('*');
        $('#modelGroupPricing_size').val('*');
        $('#modelGroupPricing').modal('toggle');


    } else {
        toastr.warning('Price Field Canot Be Empty')
    }

}
function validatePricingConditions(value, condition) {
    var bool = false;
    if (condition == '*' || condition == value) {
        bool = true;
    }
    return bool;
}
function calGroValue() {
    var additionalCost = $('#modelGrnPriceing_additionalCost').val()
    var table = $('#tableGRNPricing').DataTable();
    var TotalPrice = 0
    table.rows().every(function () {
        var data = this.data();
        TotalPrice = TotalPrice + Number(data.thTotalPrice)
    });
    var netVal = Number(additionalCost) + TotalPrice
    $('#modelGrnPriceing_grossval').val(TotalPrice)
    $('#modelGrnPriceing_netVal').val(netVal)


}
function loadIndividualPricing(rowId) {
    var table = $('#tableGRNPricing').DataTable();
    var data = table.row(rowId).data();// row data
    $('#modelIndividualPricing_fishType').val(data.thFishType)
    $('#modelIndividualPricing_presentation').val(data.thPresentation)
    $('#modelIndividualPricing_grade').val(data.thSuppliergrade)
    $('#modelIndividualPricing_size').val(data.thSizeCode)
    $('#modelIndividualPricing_NoOfFish').val(data.thQty)
    $('#modelIndividualPricing_TotalWeight').val(data.thTotalWeight)

    $('#modelIndividualPricing_hiddenRowId').val(rowId)
    $('#modelIndividualPricing').modal('toggle');
}
function IndividualPricing() {
    var price = $('#modelIndividualPricing_Price').val()
    var rowIndex = Number($('#modelIndividualPricing_hiddenRowId').val());
    if (!price == '') {
        var table = $('#tableGRNPricing').DataTable();
        var data = table.row(rowIndex).data();// row data

        var totWeight = data.thTotalWeight;
        var totPrice = Number(totWeight) * Number(price);

        table.cell(rowIndex, 6).data(price);
        table.cell(rowIndex, 7).data(totPrice);

        calGroValue()

        $('#modelIndividualPricing').modal('toggle');

        $('#modelIndividualPricing_fishType').val('')
        $('#modelIndividualPricing_presentation').val('')
        $('#modelIndividualPricing_grade').val('')
        $('#modelIndividualPricing_size').val('')
        $('#modelIndividualPricing_NoOfFish').val('')
        $('#modelIndividualPricing_TotalWeight').val('')
        $('#modelIndividualPricing_hiddenRowId').val('')
        $('#modelIndividualPricing_Price').val('')
    } else {
        toastr.warning('Price Field Canot Be Empty')
    }
}
function loadCurrancy() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadCurrancy',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';

                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.currency_name + ' </option>';
                });
                $('#modelGroupPricing_payCurrancy').html(html);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function getExchangeRateToDate(currancyId) {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/getExchangeRateToDate/' + currancyId + '/' + GRNno,
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#modelGrnPriceing_ExchangeRate').html(response.result.exchange_rate);
                $('#modelGrnPriceing_HiddenExchangeRate').val(response.result.exchange_rate);
                // console.log(Number($('#modelGrnPriceing_HiddenExchangeRate').val()))

            }
            else {
                $('#modelGrnPriceing_ExchangeRate').html(0);
                $('#modelGrnPriceing_HiddenExchangeRate').html('');
                toastr.error('Exchange Rate Not Found')
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function createGRNPricingSaveData() {
    var form = new FormData();
    var table = $('#tableGRNPricing').DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        var arr = {
            'fish_type_id': data.fish_type_id,
            'suplier_grade': data.thSuppliergrade,
            'item_size': data.item_size_id,
            'rm_presentation': data.thPresentation,
            'rm_qty': data.thQty,
            'rm_pay_rate': data.thUnitPrice,
            'rm_pay_value': data.thTotalPrice,
            'rm_tot_weight': data.thTotalWeight,
        };
        console.log(arr)
        form.append('arr[]', JSON.stringify(arr));
    });
    var payCurrancy = $('#modelGroupPricing_payCurrancy').val();
    var Pay_exchangeRate = $('#modelGrnPriceing_HiddenExchangeRate').val();


    form.append('lot_grnno', GRNno);
    form.append('rm_pay_currency', payCurrancy);
    form.append('Pay_exchangeRate', Pay_exchangeRate);

    return form
}
function saveGRNPricing(data) {
    $.ajax({
        type: "POST",
        url: "/buying/grnHistoryConfigure/saveGRNPricing",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success('Prices Updated')
                $('#modelGrnPriceing').modal('toggle');

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

                    toastr.warning(error[0]);
                    console.clear()
                });
            }
            else {
                toastr.error('Something went wrong');
            }
        }

    });
}
function validatePricingTable() {
    var bool = true;
    var table = $('#tableGRNPricing').DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if (data.thUnitPrice == "" || data.thTotalPrice == "") {
            bool = false;
            toastr.warning('Update unit price for ' + data.thFishType)
        }
    });
    if (Number($('#modelGrnPriceing_HiddenExchangeRate').val()) == '') {
        bool = false;
        toastr.error('Exchange rate is not updated to date')
        console.log(Number($('#modelGrnPriceing_HiddenExchangeRate').val()))
    }
    return bool;
}

//########################################################
//###################### Reporting #######################
//########################################################
function getReport() {
    var reportId = $('#reportSelector').val();
    if (!reportId == '') {
        $.ajax({
            type: 'GET',
            url: '/buying/grnHistoryConfigure/getReport/' + reportId + '/' + GRNno,
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
        toastr.warning('Please select a report type!')
    }

}
function loadWastageModleData(type) {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadWastageModleData/' + GRNno,
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result.map(item => ({
                    thItemCode: item.item_code,
                    thItemName: item.item_name,
                    thWarehouse: item.t_warehouse,
                    thTotalWeight: item.total_weight + item.total_weight,
                    thTotalValue: item.total_value,
                }));

                $('#tableWatage').DataTable().clear().rows.add(data).draw();
                if(type=='auto'){
                    $('#modelWastage').modal('show');
                }
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadAddWastageModleData() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistoryConfigure/loadAddWastageModleData',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var dropdownData = {
                    Item: { elementID: '#Item', key: 'item_name', id: 'Item_Code' },
                    Warehouse: { elementID: '#Warehouse', key: 'warehouse_name', id: 'warehouse_name' },
                };
                $.each(dropdownData, function (dataKey, dataValue) {
                    var options = '';
                    options += '<option value="">-Select-</option>';

                    $.each(response.result[dataKey], function (index, value) {
                        options += '<option value="' + value[dataValue.id] + '">' + value[dataValue.key] + '</option>';
                    });
                    $(dataValue.elementID).html(options);
                });
                $('#modelAddWastage').modal('show');

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function saveWastage() {
    var item = $('#Item').val()
        , warehouse = $('#Warehouse').val()
        , qty = $('#qty').val();

    if (!item || !warehouse || !qty) {
        toastr.warning('Please fill in all required fields.')
        return;
    }

    $.ajax({
        type: 'POST',
        url: '/buying/grnHistoryConfigure/saveWastage',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'Item': item,
            'Warehouse': warehouse,
            'qty': qty,
            'GRNno': GRNno,
        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                loadWastageModleData('manual')
                $('#modelAddWastage').modal('hide');
            }
        },
        error: function (data) {
            console.log(data);
            console.log('Something went wrong.');
        }
    });
}


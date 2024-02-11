console.log('planingDetailConfigure.js Loading');
var parent_url = '/mnu/processPlan_list'
var startDate = 0;
var endDate = 0;
var WorkstationRowId = 0;
var wsID = '';
var parentWS = [];
$(document).ready(function () {

    $('#btnSplit').prop('disabled', true);
    $('#btnReProcess').prop('disabled', true);
    $('#btnWaste').prop('disabled', true);
    $('#btnHold').prop('disabled', true);
    $('#btnClose').prop('disabled', true);

    // $('#daterangepicker').daterangepicker();
    //date range pikker callback Function
    $(function () {
        $('#daterangepicker').daterangepicker({
            opens: 'left'
        }, function (start, end, label) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
            loadPlans();
        });
    });

    var tableprocessPlan = $('#tableprocessPlan').DataTable({
        scrollY: 320,
        scrollX: true,
        paging: false,
        info: false,
        select: {
            style: 'single'
        },

        'columnDefs': [
            {
                "targets": [8, 9, 10, 11, 12, 13],
                "visible": false,
            },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "status", 'width': "6.6%" },
            { "data": "thPlanID", 'width': "2%" },
            { "data": "thPlanDate", 'width': "6.6%" },
            { "data": "thItem", 'width': "6.6%" },
            { "data": "thPlannedQty", 'width': "6.6%" },
            { "data": "thPlannedWeight", 'width': "6.6%" },
            { "data": "thCompletedQty", 'width': "6.6%" },
            { "data": "thCompletedWeight", 'width': "6.6%" },
            { "data": "workStation" },
            { "data": "id" },
            { "data": "itemCode" },
            { "data": "mnuDate" },
            { "data": "ExpDate" },
            { "data": "prodStatus" },






        ],
    });
    var tableLastCompleatedPlans = $('#tableLastCompleatedPlans').DataTable({
        scrollY: 300,
        scrollX: true,

        'columnDefs': [
            // {
            //     "targets": [],
            //     "visible": false,
            // },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thPlanID", 'width': "6.6%" },
            { "data": "thPlanDate", 'width': "2%" },
            { "data": "thItem", 'width': "6.6%" },
            { "data": "thPlannedQty", 'width': "6.6%" },
            { "data": "thPlannedWeight", 'width': "6.6%" },
            { "data": "thCompletedQty", 'width': "6.6%" },
            { "data": "thCompletedWeight", 'width': "6.6%" },
        ],
    });
    var tableWorkstations = $('#tableWorkstations').DataTable({

        paging: false,
        info: false,
        searching: false,

        'columnDefs': [
            {
                "targets": [3],
                "visible": false,
            },
            {
                "targets": [0, 1, 2],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thWorkstation", },
            { "data": "thAssignedQuantity" },
            { "data": "thAssignedWeight" },
            { "data": "workstationId" },



        ],
    });
    var tableByProducts = $('#tableByProducts').DataTable({

        paging: false,
        info: false,
        searching: false,

        'columnDefs': [

            {
                "targets": [0, 1, 2, 3],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thItem", },
            { "data": "thQuantity" },
            { "data": "thWeight" },
            { "data": "AddtoStock" },
            { "data": "Action" },


        ],
    });
    var tablePackingMaterial = $('#tablePackingMaterial').DataTable({

        paging: false,
        info: false,
        searching: false,

        'columnDefs': [

            {
                "targets": [0, 1, 2, 3],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thItem", },
            { "data": "thQuantity" },
            { "data": "AddtoStock" },
            { "data": "Action" },


        ],
    });

    tableprocessPlan.on('select', function (e, dt, type, indexes) {
        if (type === 'row') {
            loadPlanData(indexes[0]);
        }

    });

    $('#btnSplit').click(function () {
        loadSplitModel()
    });
    $('#btnReProcess').click(function () {
        $('#ModelByProductAndWastage').modal('toggle');
    });
    $('#btnHold').click(function () {
        if ($('#btnHold').text().trim() == 'Hold') {
            stateChangeConformation('hold');
        }
        else {
            stateChangeConformation('unhold');
        }
    });
    $('#btnClose').click(function () {
        if ($('#btnClose').text().trim() == 'Close') {
            stateChangeConformation('close');
        }
        else {
            stateChangeConformation('reopen');
        }
    });
    $('#btnChanges').click(function () {
        $('#ModelChangeRequests').modal('toggle');
    });
    $('#btnAddWorkstation').click(function () {
        addWorkstation();
    });
    $('#btnreaetTable').click(function () {
        resetWorkstationTable();
    });
    $('#splitModel_update').click(function () {
        var data = new FormData();

        data.append('wsId', wsID);
        data.append('remainingQty', parentWS.remainingQty);
        data.append('remainingWeight', parentWS.remainingWeight);


        var splitarr = appendSplitArr();
        if (splitarr === undefined || splitarr.length == 0) {
            toastr.warning('Split the order before updating');
        } else {
            for (var i = 0; i < splitarr.length; i++) {
                data.append('arr[]', JSON.stringify(splitarr[i]));
            }

            split(data);
        }

        for (var pair of data.entries()) {
            console.log(pair[0] + ' => ' + pair[1]);
        }


    });

    $('#process').change(function () {
        loadProcessWorkstations(this.value, 'filter');
        loadPlans();
    });
    $('#work_station').change(function () {
        loadPlans();
    });
    $('#status').change(function () {
        loadPlans();
    });
    $('#splitModel_qty').change(function () {
        calSplightmodelAssignedWeight();
    });

    //window resize justgage
    $(window).resize(function () {
        initG1(100, 0);
        initG2(100, 0);

    });
    loadLastCompleatedPlans();
    initG1(100, 0);
    initG2(100, 0);//call justgage init
    loadProcess();
    loadproductionPlan();
    loadPlans();


});

function split(data) {
    $.ajax({
        type: "POST",
        url: "/mnu/planingDetailConfigure/split",
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
                $('#ModelSplitPlan').modal('toggle');
                resetWorkstationTable();
                loadPlans();
                resetDetailsPannel();
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
        url: "/mnu/planingDetailConfigure/update",
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
                $('#frmplaningDetailConfigure ').trigger("reset");
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
function loadproductionPlan() {

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
            url: "/mnu/planingDetailConfigure/loadproductionPlan/" + id,
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

                    $('#SupGroupCode').val(data.SupGroupCode);
                    $('#SupGroupName').val(data.SupGroupName);
                    $('#ParentSupGroupID').val(data.ParentSupGroupID);
                    $('#list_index').val(data.list_index);

                    if (data.isGroup) {
                        $("#isGroup").prop("checked", true);
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
        // label: "Planed VS Remaining",
        title: "Compleated Quantity",
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
        // label: "Planed VS Remaining",
        title: "Compleated Weight",
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
function loadProcess() {
    $.ajax({
        type: 'GET',
        url: '/mnu/planingDetailConfigure/loadProcess',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';

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
function loadProcessWorkstations(ProcessId, element) {
    $.ajax({
        type: 'GET',
        url: '/mnu/planingDetailConfigure/loadProcessWorkstations/' + ProcessId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.WorkstationName + ' </option>';
                });
                switch (element) {
                    case 'split':
                        $('#splitModel_Workstation').html(html);

                        break;
                    case 'filter':
                        $('#work_station').html(html);

                        break;

                    default:
                        break;
                }

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadPlans() {
    var data = getFilterValues();
    $.ajax({
        type: 'POST',
        url: '/mnu/planingDetailConfigure/loadPlans',
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        success: function (response) {
            console.log(response)
            if (response.success) {
                console.log(response.result)
                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var plID = response.result[i]['plID'];
                    var plDate = response.result[i]['plDate'];
                    var itemName = response.result[i]['itemName'];
                    var plannedQty = response.result[i]['plannedQty'];
                    var plannedWeight = response.result[i]['plannedWeight'];
                    var completedQty = response.result[i]['completedQty'];
                    var completedWeight = response.result[i]['completedWeight'];
                    var prodStatus = response.result[i]['prodStatus'];
                    var WorkstationName = response.result[i]['WorkstationName'];
                    var itemCode = response.result[i]['itemCode'];
                    var mnfDate = response.result[i]['mnfDate'];
                    var expDate = response.result[i]['expDate'];



                    var status = '';

                    if (prodStatus == 0) {
                        status = `<i class="fa fa-circle text-success opacity-25 " ></i>`
                    } else if (prodStatus == 1) {
                        status = `<i class="fa fa-circle text-danger opacity-25 " ></i>`

                    } else if (prodStatus == 2) {
                        status = `<i class="fa fa-circle text-warning opacity-25 " ></i>`

                    }


                    data.push({
                        "status": status,
                        "thPlanID": plID,
                        "thPlanDate": plDate,
                        "thItem": itemName,
                        "thPlannedQty": plannedQty,
                        "thPlannedWeight": plannedWeight,
                        "thCompletedQty": completedQty,
                        "thCompletedWeight": completedWeight,
                        "workStation": WorkstationName,
                        "id": id,
                        "itemCode": itemCode,
                        "mnuDate": mnfDate,
                        "ExpDate": expDate,
                        "prodStatus": prodStatus,
                    });
                }

                var table = $('#tableprocessPlan').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function getFilterValues() {
    var status = $('#status').val();
    var process = $('#process').val();
    var workStation = $('#work_station').val();

    return {
        'status': status,
        'process': process,
        'workStation': workStation,
        'startDate': startDate,
        'endDate': endDate
    }
}
function loadPlanData(rowIndex) {
    resetDetailsPannel();
    clearSpinner();

    var table = $('#tableprocessPlan').DataTable();

    var planId = table.cell(rowIndex, 1).data();
    var ProductCode = table.cell(rowIndex, 10).data();
    var ProductName = table.cell(rowIndex, 3).data();
    var workStation = table.cell(rowIndex, 8).data();
    var planedDate = table.cell(rowIndex, 2).data();
    var mnuDate = table.cell(rowIndex, 11).data();
    var ExpDate = table.cell(rowIndex, 12).data();
    var prodStatus = table.cell(rowIndex, 13).data();
    var planedQty = table.cell(rowIndex, 4).data();
    var planedWeight = table.cell(rowIndex, 5).data();
    var compleatedQty = table.cell(rowIndex, 6).data();
    var compleatedWeight = table.cell(rowIndex, 7).data();


    $('#details_planId').html(planId);
    $('#details_productCode').html(ProductCode);
    $('#details_productName').html(ProductName);
    $('#details_assignedWorkstation').html(workStation);
    $('#details_planedDate').html(planedDate);
    $('#details_mnuDate').html(mnuDate);
    $('#details_expireDate').html(ExpDate);


    if (prodStatus == 0) {
        setSpinner('open');
    } else if (prodStatus == 1) {
        setSpinner('close');
        $('#btnClose').html('Reopen');

    } else if (prodStatus == 2) {
        setSpinner('hold');
        $('#btnHold').html('Unhold');

    }
    initG1(planedQty, compleatedQty);
    initG2(planedWeight, compleatedWeight);
    enableButtons()
}
function enableButtons() {
    $('#btnSplit').prop('disabled', false);
    $('#btnReProcess').prop('disabled', false);
    $('#btnWaste').prop('disabled', false);
    $('#btnHold').prop('disabled', false);
    $('#btnClose').prop('disabled', false);
}
function resetDetailsPannel() {
    initG1(100, 0);
    initG2(100, 0);
    clearSpinner()
    $('#btnSplit').prop('disabled', true);
    $('#btnReProcess').prop('disabled', true);
    $('#btnWaste').prop('disabled', true);
    $('#btnHold').prop('disabled', true);
    $('#btnClose').prop('disabled', true);

    $('#details_planId').html('-');
    $('#details_productCode').html('-');
    $('#details_productName').html('-');
    $('#details_assignedWorkstation').html('-');
    $('#details_planedDate').html('-');
    $('#details_mnuDate').html('-');
    $('#details_expireDate').html('-');

    $('#btnSplit').html('Split');
    $('#btnReProcess').html('Reprocess');
    $('#btnWaste').html('Waste');
    $('#btnHold').html('Hold');
    $('#btnClose').html('Close');
}
function clearSpinner() {
    if ($('#spinner_grow').hasClass('text-success')) {
        $('#spinner_grow').removeClass('text-success')
    }
    if ($('#spinner_grow').hasClass('text-danger')) {
        $('#spinner_grow').removeClass('text-danger')
    }
    if ($('#spinner_grow').hasClass('text-warning')) {
        $('#spinner_grow').removeClass('text-warning')
    }
    $('#statusText').html('-');

}
function setSpinner(status) {

    switch (status) {
        case 'open':
            $('#spinner_grow').addClass('text-success');
            $('#statusText').html('Open');
            break;
        case 'close':
            $('#spinner_grow').addClass('text-danger');
            $('#statusText').html('Close');
            break;
        case 'hold':
            $('#spinner_grow').addClass('text-warning');
            $('#statusText').html('Hold');
            break;
        default:
            clearSpinner();
    }
}
function getPlanIdAndPlanStatus() {
    var table = $('#tableprocessPlan').DataTable();
    var PlanID = table.row({ selected: true }).data().thPlanID;
    var rowIndex = table.row({ selected: true }).index();
    var planStatus = table.cell(rowIndex, 13).data();
    var wsId = table.cell(rowIndex, 9).data();

    return {
        'PlanID': PlanID,
        'planStatus': planStatus,
        'wsId': wsId
    }
}
function stateChangeConformation(state) {
    var text1 = '';
    var text2 = '';

    switch (state) {
        case 'hold':
            text1 = 'On-Hold'
            text2 = 'Hold'
            break;
        case 'unhold':
            text1 = 'Un-hold'
            text2 = 'Un-hold'
            break;
        case 'close':
            text1 = 'Closed'
            text2 = 'Close'
            break;
        case 'reopen':
            text1 = 'Re-opened'
            text2 = 'Re-open'
            break;

        default:
            text1 = '';
            text2 = '';
            break;
    }

    swal({
        title: 'Are You Sure To ' + toTitleCase(state) + ' Plan ?',
        text: 'You are about to ' + text2 + ' the production of Selected plan',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willdo) => {
            if (willdo) {
                if (changeState(state)) {
                    swal({
                        title: 'Plan ' + text2 + ' Sucess!',
                        text: 'Selected Plan is ' + text1 + '!',
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
function changeState(state) {
    var status = false;
    var data = getPlanIdAndPlanStatus();

    switch (state) {
        case 'hold':
            if (data.planStatus == 0) {
                status = true;
            }
            break;
        case 'unhold':
            if (data.planStatus == 2) {
                status = true;
            }
            break;
        case 'close':

            switch (data.planStatus) {
                case 0:
                    status = true;
                    break;
                case 2:
                    status = true;
                    break;

                default:
                    status = false;

                    break;
            }

            break;
        case 'reopen':
            if (data.planStatus == 1) {
                status = true;
            }
            break;

        default:
            status = false;
            break;
    }

    if (status) {
        $.ajax({
            type: 'GET',
            url: '/mnu/planingDetailConfigure/changeState/' + data.PlanID + '/' + state,
            async: false,
            success: function (response) {
                console.log(response)
                if (response.success) {
                    // clearSpinner();
                    // setSpinner('hold')
                    loadPlans();
                    resetDetailsPannel()
                    return true;
                }
            }, error: function (data) {
                console.log(data);
                console.log('something went wrong');
                return false;
            }
        });

    }

}
function toTitleCase(str) {
    return str.replace(/(?:^|\s)\w/g, function (match) {
        return match.toUpperCase();
    });
}
function loadSplitModel() {
    var data = getPlanIdAndPlanStatus();

    if (data.planStatus != 2) {
        toastr.warning('Please hold the plan Befor Spliting');
    } else {

        $.ajax({
            type: 'GET',
            url: '/mnu/planingDetailConfigure/loadSplitModel/' + data.wsId,
            async: false,
            success: function (response) {
                console.log(response)
                if (response.success) {
                    var data = response.result;

                    wsID = data.id; //assign ws details to the global array

                    $('#splitModel_productCode').html(data.itemCode);
                    $('#splitModel_productName').html(data.itemName);
                    $('#splitModel_PlanedQty').html(data.remainingQty);
                    $('#splitModel_planedWeight').html(data.remainingWeight);
                    $('#splitModel_remainingQty').html(data.remainingQty);
                    $('#splitModel_remainingWeight').html(data.remainingWeight);
                    $('#splitModel_Process').val(data.process);
                    $('#splitModel_weightPerUnit').val(data.avg_weight_per_unit);

                    parentWS = {
                        'remainingQty': data.remainingQty,
                        'remainingWeight': data.remainingWeight,
                        'originalQty': data.remainingQty,
                        'originalWeight': data.remainingWeight
                    };

                    loadProcessWorkstations(data.process, 'split');
                    $('#splitModel_qty').val(data.remainingQty);
                    $('#splitModel_weight').val(data.remainingWeight);
                    var table = $('#tableWorkstations').DataTable();
                    table.clear().draw();

                    $('#ModelSplitPlan').modal('toggle');
                }
            }, error: function (data) {
                console.log(data);
                console.log('something went wrong');
            }
        });
    }
}
function addWorkstation() {
    var remainingQty = parentWS.remainingQty;
    var workstation = $("#splitModel_Workstation option:selected").text();
    var workstationId = $("#splitModel_Workstation").val();
    var AssignedQuantity = $('#splitModel_qty').val();
    var AssignedWeight = $('#splitModel_weight').val();

    if (Number(AssignedQuantity) > Number(remainingQty)) {
        toastr.warning('Remaining Qty Exceeded');

        $('#splitModel_qty')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#splitModel_qty')[0].style.border = '';
        }, 4000);

    } else if (workstationId == '') {
        toastr.warning('Please Select A Workstation');

        $('#splitModel_Workstation')[0].style.border = '1px solid red';
        setTimeout(function () {
            $('#splitModel_Workstation')[0].style.border = '';
        }, 4000);
    }
    else {

        var data = [];

        data.push({
            "thWorkstation": workstation,
            "thAssignedQuantity": AssignedQuantity,
            "thAssignedWeight": AssignedWeight,
            "workstationId": workstationId,
        });
        var table = $('#tableWorkstations').DataTable();
        table.rows.add(data).draw();



        parentWS.remainingQty = Number(parentWS.remainingQty) - Number(AssignedQuantity);
        parentWS.remainingWeight = Number(parentWS.remainingWeight) - Number(AssignedWeight);

        $('#splitModel_remainingQty').html(parentWS.remainingQty)
        $('#splitModel_remainingWeight').html(parentWS.remainingWeight)

        $('#splitModel_qty').val(parentWS.remainingQty)
        $('#splitModel_weight').val(parentWS.remainingWeight)
    }



}
function resetWorkstationTable() {
    var table = $('#tableWorkstations').DataTable();
    table.clear().draw();
    WorkstationRowId = 0;
    wsID = '';
    parentWS.remainingQty = parentWS.originalQty;
    parentWS.remainingWeight = parentWS.originalWeight;

    $('#splitModel_remainingQty').html(parentWS.originalQty);
    $('#splitModel_remainingWeight').html(parentWS.originalWeight);
    $('#splitModel_qty').val(parentWS.remainingQty)
    $('#splitModel_weight').val(parentWS.remainingWeight)

}
function calSplightmodelAssignedWeight() {
    var qty = $('#splitModel_qty').val();
    var weight = $('#splitModel_weightPerUnit').val();
    var assignWeight = Number(qty) * Number(weight);
    $('#splitModel_weight').val(assignWeight);
}
function appendSplitArr() {
    var table = $('#tableWorkstations').DataTable();

    var arr = [];

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        arr.push({
            'Workstation': data.thWorkstation,
            'AssignedQuantity': data.thAssignedQuantity,
            'AssignedWeight': data.thAssignedWeight,
            'workstationId': data.workstationId,
        });
    });
    console.log(arr)

    return arr
}
function loadLastCompleatedPlans() {
    $.ajax({
        type: 'GET',
        url: '/mnu/planingDetailConfigure/loadLastCompleatedPlans',
        async: false,

        success: function (response) {
            console.log(response)
            if (response.success) {
                console.log(response.result)
                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var plID = response.result[i]['plID'];
                    var plDate = response.result[i]['plDate'];
                    var itemName = response.result[i]['itemName'];
                    var plannedQty = response.result[i]['plannedQty'];
                    var plannedWeight = response.result[i]['plannedWeight'];
                    var completedQty = response.result[i]['completedQty'];
                    var completedWeight = response.result[i]['completedWeight'];

                    data.push({
                        "thPlanID": plID,
                        "thPlanDate": plDate,
                        "thItem": itemName,
                        "thPlannedQty": plannedQty,
                        "thPlannedWeight": plannedWeight,
                        "thCompletedQty": completedQty,
                        "thCompletedWeight": completedWeight,
                    });
                }

                var table = $('#tableLastCompleatedPlans').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

console.log('productionPlanConfigure .js loadimng');
var parent_url = '/mnu/productionPlan_list'
var checkBoxId = 0;
var startDate = 0;
var endDate = 0;
var tableIndex = 0;
var workSheetReqId = '';
var ProcessId = '';

var newPlanQty = 0;
var PlanedQty = 0;
var RemainingQty = 0;
var compleatedQty = 0;

$(document).ready(function () {

    $('#ModelChangeRequestApproval').modal('toggle');
    $('#ChangeRequestSpiner').hide()

    var tblProductionPlan = $('#tableproductionPlan').DataTable({
        scrollY: 400,
        scrollX: true,
        // scrollY: true,
        scrollCollapse: true,
        paging: false,

        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '2px')
                }
            },

            {
                "targets": [16, 17, 18, 19, 20, 21, 22, 23],
                "visible": false,
            }, {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "action", 'width': "6.6%" },
            { "data": "thId", 'width': "2%" },
            { "data": "thRequiredDate", 'width': "6.6%" },
            { "data": "thItem", 'width': "6.6%" },
            { "data": "thRemainingQty", 'width': "6.6%" },
            { "data": "thRemainingWeight", 'width': "6.6%" },
            { "data": "thPlaningQty", 'width': "6.6%" },
            { "data": "thPlaningWeight", 'width': "6.6%" },
            { "data": "thPlaningDate", 'width': "6.6%" },
            { "data": "thCustomer", 'width': "6.6%" },
            { "data": "thNotifyParty", 'width': "6.6%" },
            { "data": "thRefNumber", 'width': "6.6%" },
            { "data": "thProcess", 'width': "6.6%" },
            { "data": "thWorkstation", 'width': "6.6%" },
            { "data": "thProductionDate", 'width': "6.6%" },
            { "data": "thExpiryDate", 'width': "6.6%" },
            { "data": "processId" },
            { "data": "WorkstationId" },
            { "data": "itemUnitWeight" },
            { "data": "ItemId" },
            { "data": "itemCode" },
            { "data": "refType" },
            { "data": "cusId" },
            { "data": "notifyId" },



        ],
    });
    var tableTodayPlan = $('#tableTodayPlan').DataTable({
        scrollY: 600,
        scrollX: true,
        scrollY: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        searching: false,
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '2px')
                }
            }, {
                "targets": [0, 1, 2, 3, 4, 5],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "5%" },
            { "data": "thItem", 'width': "15%" },
            { "data": "thPlannedQty", 'width': "20%" },
            { "data": "thPlannedweight", 'width': "20%" },
            { "data": "thCompletedQty", 'width': "20%" },
            { "data": "thCompletedWeight", 'width': "20%" },
        ],
    });
    var tableItemRequirement = $('#tableItemRequirement').DataTable({
        scrollY: 600,
        scrollX: true,
        scrollY: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        searching: false,
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '2px')
                }
            }, {
                "targets": [0, 1, 2],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thitem", 'width': "70%" },
            { "data": "thRequiredQty", 'width': "10%" },
            { "data": "thStockQty", 'width': "10%" },
            // { "data": "thAlreadyPlanedQty", 'width': "10%" },

        ],
    });
    var tablePackingMaterialReq = $('#tablePackingMaterialReq').DataTable({
        scrollY: 600,
        scrollX: true,
        scrollY: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        searching: false,
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '2px')
                }
            }, {
                "targets": [0, 1, 2],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thitem", 'width': "70%" },
            { "data": "thRequiredQty", 'width': "10%" },
            { "data": "thStockQty", 'width': "10%" },
            // { "data": "thAlreadyPlanedQty", 'width': "10%" },

        ],
    });
    var tablePackingMaterialReq = $('#tableChangeRequestApproval').DataTable({

        paging: false,
        info: false,
        searching: false,
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '2px')
                }
            }, {
                "targets": [0, 1, 2],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thItem" },
            { "data": "thTotalPlanedQty" },
            { "data": "thCompleatedQty" },
            { "data": "thCompleatedWeight" },


        ],
    });
    var tableChangeRequest = $('#tableChangeRequest').DataTable({
        scrollY: 600,
        scrollX: true,
        scrollY: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        searching: false,
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '4px')
                }
            },
            {
                "targets": [0, 1, 2, 3, 4, 5],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thCustomer", 'width': "5%" },
            { "data": "thOrderNo", 'width': "15%" },
            { "data": "thItem", 'width': "20%" },
            { "data": "thPreviousQty", 'width': "20%" },
            { "data": "thNewQty", 'width': "20%" },
            { "data": "thActions", 'width': "20%" },
        ],
    });
    var tableChangeRequest = $('#tableChangeRequestWorkSheets').DataTable({
        paging: false,
        info: false,
        searching: false,
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '4px')
                }
            },
            {
                "targets": [6, 7, 8, 9, 10, 11],
                "visible": false,
            }, {
                "targets": [0, 1, 2, 3, 4, 5],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thWorkstation", 'width': "5%" },
            { "data": "thStatus", 'width': "15%" },
            { "data": "thPlanQty", 'width': "20%" },
            { "data": "thCompleatedQty", 'width': "20%" },
            { "data": "thBalance", 'width': "20%" },
            { "data": "action", 'width': "20%" },
            { "data": "isOriginal" },
            { "data": "wsid" },
            { "data": "Workstation_id" },
            { "data": "process_id" },
            { "data": "mnfDate" },
            { "data": "expDate" },




        ],
    });
    // $('#daterangepicker').daterangepicker();

    $(function () {
        $('#daterangepicker').daterangepicker({
            opens: 'left'
        }, function (start, end, label) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
            loadRequirements();
        });
    });


    $('#tableproductionPlan tbody').on('click', 'td', function () {
        var data = tblProductionPlan.row(this).data();// row data
        var Rowindex = tblProductionPlan.row(this).index();// row index
        var cellIndex = tblProductionPlan.cell(this).index().columnVisible;//cell index

        if ($("#checkbox_" + Rowindex).prop("checked") == false) {
            toastr.warning('Select the requirement to Set Values');
        } else {
            if (cellIndex != 0) {
                LoadIndividualModel(Rowindex, data);
            }
        }
    });
    $('#btnSave').click(function () {
        // var form = $(' ').get(0);
        var data = new FormData();
        var productionPlanArr = createProductionPlanArry();

        if (productionPlanArr.length == 0) {
            toastr.warning('Plese Select Some Items Before Proceed');

        } else {
            for (var i = 0; i < productionPlanArr.length; i++) {
                data.append('productionPlans[]', JSON.stringify(productionPlanArr[i]));
            }

            if ($('#btnSave').text().trim() == 'Save') {
                save(data);
            }
            else {
                update(data);
            }
        }
    });
    $('#btnASelectAll').click(function () {
        selectAll();
    });
    $('#btnSetValues').click(function () {
        $('#ModelBulkPlaning').modal('toggle');
    });
    $('#btnCreatePlan').click(function () {
        $('#ModelIndividualPlanning').modal('toggle');
    });
    $('#btnCreateBulkPlan').click(function () {
        bulkPlanConformation();
    });
    $('#btnNewRequirement').click(function () {
        location.href = '/mnu/NewRequirements_configure'
    });
    $('#btnUpdateValuesBulf').click(function () {
        updateBulkValues();
    });
    $('#btnUpdateIndividual').click(function () {
        updateIndividualValues();
    });
    $('#btnLoadItemRequirements').click(function () {
        loadItemRequirements();
    });
    $('#btnLoadPackingRequirements').click(function () {
        loadItemRequirements();
    });
    $('#btnUpdateChangeReqWS').click(function () {
        if (is_validWorksheets()) {
            var form = $('#changeReqWSHidden').get(0);
            var data = new FormData(form);
            var ChangerqWsArr = createChangerqWsArr();

            for (var i = 0; i < ChangerqWsArr.length; i++) {
                data.append('workSheets[]', JSON.stringify(ChangerqWsArr[i]));
            }
            data.append('newPlanQty',newPlanQty );
            data.append('PlanedQty',PlanedQty );
            data.append('RemainingQty',RemainingQty );

            updateWsChangeReq(data);
        } else {

            toastr.warning('Quantity Miss match');

        }


    });
    $('#btnNewPlan').click(function () {
        loadnewWsmodel();
    });
    $('#btnResetpln').click(function () {
        tableIndex = 0;
        workSheetReqId = '';
        ProcessId = '';
        loadWorkSheetSToTheChangeRequest();
        calRemaininToPlanAndPlansAdjustQty();

    });
    $('#btnAddNewWsRow').click(function () {
        addNewWs();
    });
    $('#ModelEdiWSValueEdit_UpdateIndividual').click(function () {
        editWorkSheet();
    });


    $('#process').change(function () {
        loadRequirements();
        loadProcessWorkstations(this.value, 1);
        loadTodayPlans();
    });
    $('#work_station').change(function () {
        loadRequirements();
    });
    $('#process2').change(function () {
        loadProcessWorkstations(this.value, 2);
        loadTodayPlans();
    });
    $('#individualTxtBx_PlaningQuantity').change(function () {
        calPlaningWeight()
    });
    $('#plansFilter_date').change(function () {
        loadTodayPlans();
    });
    $('#work_station2').change(function () {
        loadTodayPlans();
    });



    //window resize justgage
    $(window).resize(function () {
        initG1();
    });

    initG1(0);//call justgage init
    loadProcess();
    loadproductionPlan();
    loadChangeRequest();
    loadCounts();

});
function loadCounts() {
    $.ajax({
        type: 'GET',
        url: '/mnu/productionPlanConfigure/loadCounts',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                $('#Todayrequirements').html(response.result.Todayrequirements);
                $('#requirements').html(response.result.requirements);
                $('#ChangeReq').html(response.result.ChangeReq);
                if (response.result.hasChangeReqs) {
                    $('#ChangeRequestSpiner').show()

                }

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function save(data) {
    $.ajax({
        type: "POST",
        url: "/mnu/productionPlanConfigure/save",
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
                $('#frmproductionPlanConfigure ').trigger("reset");
                // location.href = parent_url;

                $('#btnSave').html('Done')

                loadRequirements($('#process').val()); //write to a function if neede
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
        url: "/mnu/productionPlanConfigure/update",
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
                $('#frmproductionPlanConfigure ').trigger("reset");
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
            url: "/mnu/productionPlanConfigure/loadproductionPlan/" + id,
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
// function loadParentGroups() {
//     $.ajax({
//         type: 'GET',
//         url: '/mnu/productionPlanConfigure/loadParentGroups',
//         async: false,
//         success: function (response) {
//             console.log(response)
//             if (response.success) {
//                 var html = "";
//                 $.each(response.result, function (index, value) {

//                     html += '<option value="' + value.id + '" > ' + value.SupGroupName + ' </option>';
//                 });
//                 $('#ParentSupGroupID').append(html);


//             }
//         }, error: function (data) {
//             console.log(data);
//             console.log('something went wrong');
//         }
//     });
// }
function bulkPlanConformation() {
    swal({
        title: "Are you sure?",
        text: "You are about to create a plan to selected Requirements.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                swal({
                    title: "Deleted!",
                    text: "Selected Data has been deleted",
                    icon: "success",
                });
            } else {
                swal({
                    title: "Not Deleted!",
                    text: "Your Data is Safe",
                    icon: "error",
                });
            }
        });
}
function initG1(value) {
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
        id: 'g1',
        value: value,
        min: 0,
        max: 100,
        title: "Total planed",
        symbol: '%',
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
        valueFontColor: valueFontColor,
        levelColors: [colors.danger],
        donut: true,
    });

    // Delete the extra added element when the page is resized.
    $('#g1 > svg + svg').remove();
    // setInterval(function () {
    //     g1.refresh(getRandomInt(0, 100));
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
        label: "Planed VS Remaining",
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

}
function loadRequirements() {
    var data = getFilterValues();
    console.log(data.workStation)
    $.ajax({
        type: 'POST',
        url: '/mnu/productionPlanConfigure/loadRequirements',
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        success: function (response) {
            console.log(response)
            if (response.success) {
                console.log(response.result)
                checkBoxId = 0;
                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var itemName = response.result[i]['itemName'];
                    var rqDate = response.result[i]['rqDate'];
                    var remainingQty = response.result[i]['remainingQty'];
                    var remainingWeight = response.result[i]['remainingWeight'];
                    // var plannedQty = response.result[i]['plannedQty'];
                    // var effectiveQty = response.result[i]['effectiveQty'];
                    var customer = response.result[i]['customer'];
                    var AddressTitle = response.result[i]['AddressTitle'];
                    var refNo = response.result[i]['refNo'];
                    var CusName = response.result[i]['CusName'];
                    var ProcessName = response.result[i]['ProcessName'];
                    var WorkstationName = response.result[i]['WorkstationName'];
                    var process = response.result[i]['process'];
                    var work_station = response.result[i]['work_station'];
                    var avg_weight_per_unit = response.result[i]['avg_weight_per_unit'];
                    var item = response.result[i]['item'];
                    var itemCode = response.result[i]['itemCode'];
                    var refType = response.result[i]['refType'];
                    var customer = response.result[i]['customer'];
                    var notify = response.result[i]['notify'];



                    data.push({
                        "action": `<input type="checkbox" id="checkbox_` + checkBoxId + `" >`,
                        "thId": id,
                        "thRequiredDate": rqDate,
                        "thItem": itemName,
                        "thRemainingQty": remainingQty,
                        "thRemainingWeight": remainingWeight,
                        "thPlaningQty": remainingQty,
                        "thPlaningWeight": remainingWeight,
                        "thPlaningDate": '',
                        "thCustomer": CusName,
                        "thNotifyParty": AddressTitle,
                        "thRefNumber": refNo,
                        "thProcess": ProcessName,
                        "thWorkstation": WorkstationName,
                        "thProductionDate": '',
                        "thExpiryDate": '',
                        "processId": process,
                        "WorkstationId": work_station,
                        "itemUnitWeight": avg_weight_per_unit,
                        'ItemId': item,
                        'itemCode': itemCode,
                        'refType': refType,
                        'cusId': customer,
                        'notifyId': notify,


                    });
                    checkBoxId = checkBoxId + 1;
                }

                var table = $('#tableproductionPlan').DataTable();
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
    var process = $('#process').val();
    var workStation = $('#work_station').val();

    return {
        'process': process,
        'workStation': workStation,
        'startDate': startDate,
        'endDate': endDate
    }
}
function loadTodayPlans() {
    var date = $('#plansFilter_date').val();
    var process = $('#process2').val();
    var work_station = $('#work_station2').val();


    $.ajax({
        type: 'POST',
        url: '/mnu/productionPlanConfigure/loadTodayPlans',
        data: { 'date': date, 'process': process, 'work_station': work_station },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        success: function (response) {
            console.log(response)

            if (response.success) {
                console.log(response.result)
                var result = response.result.Requirements;
                var data = [];
                for (i = 0; i < result.length; i++) {
                    var id = result[i]['id'];
                    var itemName = result[i]['itemName'];
                    var plannedQty = result[i]['plannedQty'];
                    var plannedWeight = result[i]['plannedWeight'];
                    var completedWeight = result[i]['completedWeight'];
                    var completedQty = result[i]['completedQty'];

                    data.push({
                        "thId": id,
                        "thItem": itemName,
                        "thPlannedQty": plannedQty,
                        "thPlannedweight": plannedWeight,
                        "thCompletedQty": completedQty,
                        "thCompletedWeight": completedWeight,
                    });
                }

                var table = $('#tableTodayPlan').DataTable();
                table.clear();
                table.rows.add(data).draw();

                calPlanedPercentage(response.result.totalPlaned, response.result.totalCompleated)

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
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
function loadProcess() {
    $.ajax({
        type: 'GET',
        url: '/mnu/productionPlanConfigure/loadProcess',
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
                $('#process2').append(html);



            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadProcessWorkstations(ProcessId, elementNumber) {
    $.ajax({
        type: 'GET',
        url: '/mnu/productionPlanConfigure/loadProcessWorkstations/' + ProcessId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.WorkstationName + ' </option>';
                });
                if (elementNumber == 1) {
                    $('#work_station').html(html);

                } else if (elementNumber == 2) {
                    $('#work_station2').html(html);

                } else if (elementNumber == 3) {
                    $('#work_station3').html(html);

                } else if (elementNumber == 4) {
                    $('#work_station4').html(html);

                }


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function updateBulkValues() {
    var planingDate = $('#Bulk_Planing_Date').val();
    var lableManufactureDate = $('#Bulk_Lable_Manufacture_Date').val();
    var LableExpiryDate = $('#Bulk_Lable_Expiry_Date').val();

    var el = '';
    if (planingDate == '') {
        el = $('#Bulk_Planing_Date');

        el[0].style.border = '1px solid red';
        setTimeout(function () {
            el[0].style.border = '';
        }, 4000);
        toastr.warning('Select Planing Date');

    } else if (lableManufactureDate == '') {
        el = $('#Bulk_Lable_Manufacture_Date');

        el[0].style.border = '1px solid red';
        setTimeout(function () {
            el[0].style.border = '';
        }, 4000);
        toastr.warning('Select Manufacture Date');

    } else if (LableExpiryDate == '') {
        el = $('#Bulk_Lable_Expiry_Date');

        el[0].style.border = '1px solid red';
        setTimeout(function () {
            el[0].style.border = '';
        }, 4000);
        toastr.warning('Select Expire Date');
    } else {
        var table = $('#tableproductionPlan').DataTable();


        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            if ($("#checkbox_" + rowIdx).prop("checked") == true) {
                this.cell(rowIdx, 8).data(planingDate);
                this.cell(rowIdx, 14).data(lableManufactureDate);
                this.cell(rowIdx, 15).data(LableExpiryDate);
            }
            // if ($("#checkbox_" + rowIdx).checked == true) {
            //     console.log(rowIdx)
            // }
        });

        $('#ModelBulkPlaning').modal('toggle');
        $('#Bulk_Planing_Date').val('');
        $('#Bulk_Lable_Manufacture_Date').val('');
        $('#Bulk_Lable_Expiry_Date').val('');

    }

}
function LoadIndividualModel(rowIndex, data) {
    initG2(data.thRemainingQty, data.thPlaningQty);
    console.log(data)
    $('#individual_RequirementID').html(data.thId);
    $('#individual_RequiredDate').html(data.thRequiredDate);
    $('#individual_Item').html(data.thItem);
    $('#individual_RefNo').html(data.thRefNumber);
    $('#individual_Customer').html(data.thCustomer);
    $('#individual_Notify').html(data.thNotifyParty);

    loadProcessWorkstations(data.processId, 3)
    $('#individualTxtBx_UnitWeight').val(data.itemUnitWeight);
    $('#individualTxtBx_RemainingQty').val(data.thRemainingQty);
    $('#individualTxtBx_RowIndex').val(rowIndex);

    $('#work_station3').val(data.WorkstationId);
    $('#individualTxtBx_PlaningQuantity').val(data.thPlaningQty);
    $('#individualTxtBx_PlaningWeight').val(data.thPlaningWeight);
    $('#individualTxtBx_PlanDate').val(data.thPlaningDate);
    $('#individualTxtBx_ManufacturingDate').val(data.thProductionDate);
    $('#individualTxtBx_ExpireDate').val(data.thExpiryDate);


    $('#ModelIndividualPlanning').modal('toggle');

}
function calPlaningWeight() {
    var planingQty = $('#individualTxtBx_PlaningQuantity').val();
    var uitWeight = $('#individualTxtBx_UnitWeight').val();
    var RemainingQty = $('#individualTxtBx_RemainingQty').val();

    if (Number(RemainingQty) < Number(planingQty)) {
        el = $('#individualTxtBx_PlaningQuantity');

        el[0].style.border = '1px solid red';
        setTimeout(function () {
            el[0].style.border = '';
        }, 4000);
        toastr.warning('Canot Exceed Remainig Quantity');
        $('#individualTxtBx_PlaningQuantity').val('')

    } else {
        var tot = Number(planingQty) * Number(uitWeight);
        $('#individualTxtBx_PlaningWeight').val(tot);
        initG2(Number(RemainingQty), Number(planingQty));
    }
}
function updateIndividualValues() {
    var rowIndex = Number($('#individualTxtBx_RowIndex').val());
    var planingQty = $('#individualTxtBx_PlaningQuantity').val();
    var planingWeight = $('#individualTxtBx_PlaningWeight').val();
    var planDate = $('#individualTxtBx_PlanDate').val();
    var manufacturingDate = $('#individualTxtBx_ManufacturingDate').val();
    var ExpireDate = $('#individualTxtBx_ExpireDate').val();
    var WorkstationId = $('#work_station3').val();
    var WorkstationName = $("#work_station3 option:selected").text();;




    var table = $('#tableproductionPlan').DataTable();

    if (planingQty != '') {
        table.cell(rowIndex, 6).data(planingQty);
    }
    if (planingWeight != '') {
        table.cell(rowIndex, 7).data(planingWeight);
    }
    if (planDate != '') {
        table.cell(rowIndex, 8).data(planDate);
    }
    if (manufacturingDate != '') {
        table.cell(rowIndex, 14).data(manufacturingDate);
    }
    if (ExpireDate != '') {
        table.cell(rowIndex, 15).data(ExpireDate);
    }
    if (WorkstationId != '') {
        table.cell(rowIndex, 17).data(WorkstationId); c
    }
    if (WorkstationId != '') {
        table.cell(rowIndex, 13).data(WorkstationName);
    }

    $('#ModelIndividualPlanning').modal('toggle');

}
function createProductionPlanArry() {

    var table = $('#tableproductionPlan').DataTable();

    var arr = [];

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if ($("#checkbox_" + rowIdx).prop("checked") == true) {
            arr.push({
                'RequirementId': data.thId,
                'RequiredDate': data.thRequiredDate,
                'Item': data.thItem,
                'RemainingQty': data.thRemainingQty,
                'RemainingWeight': data.thRemainingWeight,
                'PlaningQty': data.thPlaningQty,
                'PlaningWeight': data.thPlaningWeight,
                'PlaningDate': data.thPlaningDate,
                'Customer': data.cusId,
                'NotifyParty': data.notifyId,
                'RefNumber': data.thRefNumber,
                'Process': data.thProcess,
                'Workstation': data.thWorkstation,
                'ProductionDate': data.thProductionDate,
                'ExpiryDate': data.thExpiryDate,
                'processId': data.processId,
                'WorkstationId': data.WorkstationId,
                'itemUnitWeight': data.itemUnitWeight,
                'ItemId': this.cell(rowIdx, 19).data(),
                'itemCode': this.cell(rowIdx, 20).data(),
                'refType': this.cell(rowIdx, 21).data(),
            });
        }

    });
    console.log(arr)
    return arr
}
function calPlanedPercentage(planed, compleated) {
    var val = (Number(compleated) / Number(planed)) * 100
    if (Number.isInteger(val)) {
        initG1(val);
        console.log(val);
    } else {
        initG1(0);
    }
}
function getRequirementArr() {
    var table = $('#tableproductionPlan').DataTable();

    var arr = [];

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if ($("#checkbox_" + rowIdx).prop("checked") == true) {
            arr.push({
                'ItemId': this.cell(rowIdx, 19).data(),
                'PlaningQty': data.thPlaningQty,
            });
        }

    });
    return arr

}
function loadItemRequirements() {

    var array = getRequirementArr();

    $.ajax({
        type: 'POST',
        url: '/mnu/productionPlanConfigure/loadItemRequirements',
        data: { 'arr': array },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                console.log(response.result)
                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    // var id = response.result[i]['id'];
                    var reqQty = response.result[i]['reqQty'];
                    var item = response.result[i]['item'];
                    data.push({
                        "thitem": item,
                        "thRequiredQty": reqQty,
                        "thStockQty": '',
                    });
                }

                var table = $('#tableItemRequirement').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
    loadPackingMaterialRequirements()
}
function loadPackingMaterialRequirements() {
    var array = getRequirementArr();

    $.ajax({
        type: 'POST',
        url: '/mnu/productionPlanConfigure/loadPackingMaterialRequirements',
        data: { 'arr': array },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                console.log(response.result)
                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    // var id = response.result[i]['id'];
                    var reqQty = response.result[i]['reqQty'];
                    var item = response.result[i]['item'];
                    data.push({
                        "thitem": item,
                        "thRequiredQty": reqQty,
                        "thStockQty": '',
                    });
                }

                var table = $('#tablePackingMaterialReq').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadChangeRequest() {
    $.ajax({
        type: 'GET',
        url: '/mnu/productionPlanConfigure/loadChangeRequest',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = [];

                $.each(response.result, function (index, val) {
                    var view = '<button type="button" class="btn btn-primary btn-floating" onclick="viewChangeRequests(' + val.id + ')"><i class="ti-angle-right"></i></button>';

                    data.push({
                        "thCustomer": val.CusName,
                        "thOrderNo": val.refNo,
                        "thItem": val.item_name,
                        "thPreviousQty": val.old_qty,
                        "thNewQty": val.new_qty,
                        "thActions": view,
                    });
                });
                var table = $('#tableChangeRequest').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function viewChangeRequests(wsReqId) {
    workSheetReqId = wsReqId
    $.ajax({
        type: 'GET',
        url: '/mnu/productionPlanConfigure/viewChangeRequests/' + wsReqId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var result = response.result.WorksheetChangeRequest;

                $('#RequirementId').html(result.id);
                $('#RequiredDate').html(result.rqDate);
                $('#Item').html(result.item_name);
                $('#RefNo').html(result.refNo);
                $('#Customer').html(result.CusName);
                $('#Notify').html(result.AddressTitle);
                newPlanQty = Number(result.new_qty);
                $('#newPlan').html(newPlanQty);

                loadWorkSheetSToTheChangeRequest(wsReqId);
                calRemaininToPlanAndPlansAdjustQty();


                $('#hidden_RequirementId').val(result.id);
                $('#hidden_Item').val(result.item_id);
                $('#hidden_ItemCode').val(result.Item_Code);
                $('#hidden_ItemName').val(result.item_name);
                $('#hidden_RefNo').val(result.refNo);
                $('#hidden_Customer').val(result.customer_id);
                $('#hidden_Notify').val(result.notify_party);
                $('#WsChangeReqId').val(result.WsChangeReqId);

                console.log()
                ProcessId = response.result.ProcessId
                $('#ModelChangeRequests').modal('toggle');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });

}
function calRemaininToPlanAndPlansAdjustQty() {
    getPlanedQty();
    $('#Plans_Adjusted').html(PlanedQty);

    RemainingQty = Number(newPlanQty) - Number(PlanedQty)
    $('#Remain_to_plan').html(RemainingQty);

}
function getPlanedQty() {
    var table = $('#tableChangeRequestWorkSheets').DataTable();

    PlanedQty = 0;
    table.rows().every(function () {
        var data = this.data();
        PlanedQty = PlanedQty + Number(data.thPlanQty)
    });
}
function getRemainingQty() {

}
function loadWorkSheetSToTheChangeRequest() {
    $.ajax({
        type: 'GET',
        url: '/mnu/productionPlanConfigure/loadWorkSheetSToTheChangeRequest/' + workSheetReqId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = [];

                $.each(response.result, function (index, val) {
                    var view = '<button type="button" class="btn btn-info btn-sm" onclick="editWorkSheetMOdel(' + tableIndex + ')"><i class="fa fa-edit"></i></button>';
                    data.push({
                        "thWorkstation": val.WorkstationName,
                        "thStatus": val.planStatus,
                        "thPlanQty": val.plannedQty,
                        "thCompleatedQty": val.completedQty,
                        "thBalance": val.remainingQty,
                        "action": view,
                        "isOriginal": true,
                        'wsid': val.id,
                        'Workstation_id': val.Workstation_id,
                        'process_id': val.process_id,
                        'mnfDate': val.mnfDate,
                        'expDate': val.expDate
                    });
                    tableIndex++
                });
                var table = $('#tableChangeRequestWorkSheets').DataTable();
                table.clear();
                table.rows.add(data).draw();

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function updateWsChangeReq(data) {
    $.ajax({
        type: "POST",
        url: "/mnu/productionPlanConfigure/updateWsChangeReq",
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
                $('#changeReqWSHidden ').trigger("reset");
                $('#ModelChangeRequests').modal('toggle');
                tableIndex = 0;
                workSheetReqId = '';
                ProcessId = '';
                newPlanQty = 0;
                PlanedQty = 0;
                RemainingQty = 0;
                compleatedQty = 0;
                loadChangeRequest()

            }
        },
        error: function (error) {
            console.log(error);
            toastr.error('Something went wrong');
        },
    });
}
function createChangerqWsArr() {

    var table = $('#tableChangeRequestWorkSheets').DataTable();
    var arr = [];
    table.rows().every(function () {
        var data = this.data();
        arr.push({
            'Workstation': data.Workstation_id,
            'Status': data.thStatus,
            'PlanQty': data.thPlanQty,
            'CompleatedQty': data.thCompleatedQty,
            'Balance': data.thBalance,
            'isOriginal': data.isOriginal,
            'id': data.wsid,
            'mnfDate': data.mnfDate,
            'expDate': data.expDate,
            'process': data.process_id,
        });

    });
    console.log(arr)
    return arr
}

function loadnewWsmodel() {
    loadProcessWorkstations(ProcessId, 4)
    $('#ModelAddNewWS').modal('toggle');
}
function addNewWs() {
    var workstation = $('#work_station4');
    var workstationname = $("#work_station4 option:selected").text();;
    var qty = $('#ModelAddNewWS_Quantity');
    var expdate = $('#ModelAddNewWS_Expire_Date');
    var mnfdate = $('#ModelAddNewWS_Manufacture_Date');
    if (workstation.val() == '') {
        errorElement(workstation)
        toastr.warning('Select WorkStation');
    }
    else if (qty.val() == '') {
        errorElement(qty)
        toastr.warning('Enter Quantity');
    }
    else if (mnfdate.val() == '') {
        errorElement(mnfdate)
        toastr.warning('Enter Mnf Date');
    }
    else if (expdate.val() == '') {
        errorElement(expdate)
        toastr.warning('Enter Exp Date');
    }
    else {
        var view = '<button type="button" class="btn btn-info btn-sm" onclick="editWorkSheet(' + tableIndex + ')"><i class="fa fa-edit"></i></button>';

        var data = [];
        data.push({
            "thWorkstation": workstationname,
            "thStatus": 0,
            "thPlanQty": qty.val(),
            "thCompleatedQty": 0,
            "thBalance": qty.val(),
            "action": view,
            "isOriginal": false,
            'wsid': '',
            'Workstation_id': workstation.val(),
            'process_id': ProcessId,
            'mnfDate': mnfdate.val(),
            'expDate': expdate.val()
        });
        tableIndex++

        var table = $('#tableChangeRequestWorkSheets').DataTable();
        table.rows.add(data).draw();

        workstation.val('');
        qty.val('');
        expdate.val('');
        mnfdate.val('');
        $('#ModelAddNewWS').modal('toggle');
        calRemaininToPlanAndPlansAdjustQty();
    }

}
function editWorkSheetMOdel(rowID) {
    $('#ModelEdiWSValueEdit_rowID').val(rowID);
    $('#ModelEdiWSValueEdit').modal('toggle');

}
function editWorkSheet() {
    var rowID = $('#ModelEdiWSValueEdit_rowID').val();
    var qty = $('#ModelEdiWSValueEdit_Quantity');
    if (qty.val() == '') {
        errorElement(qty)
        toastr.warning('Enter Quantity');
    } else {
        if (is_notLowerThanCompleatedQty(rowID, qty.val())) {
            var table = $('#tableChangeRequestWorkSheets').DataTable();
            table.cell(Number(rowID), 2).data(qty.val());

            $('#ModelEdiWSValueEdit').modal('toggle');
            qty.val('');
            calRemaininToPlanAndPlansAdjustQty();
        }

    }
}
function is_notLowerThanCompleatedQty(rowID, val) {
    var table = $('#tableChangeRequestWorkSheets').DataTable();
    var completedQty = table.rows(rowID).data()[0]['thCompleatedQty'];
    var bool = true;
    if (Number(val) < Number(completedQty)) {
        bool = false;
        toastr.warning('Entered Quantity is lower than Compleated Qty');
    }
    return bool;

}
function is_validWorksheets() {
    calRemaininToPlanAndPlansAdjustQty();
    var bool = false;
    var table = $('#tableChangeRequestWorkSheets').DataTable();
    compleatedQty = 0;
    table.rows().every(function () {
        var data = this.data();
        compleatedQty = compleatedQty + Number(data.thCompleatedQty)
    });
    console.log(compleatedQty, PlanedQty, newPlanQty)
    if (PlanedQty >= compleatedQty && PlanedQty <= Number(newPlanQty)) {
        bool = true
    }
    return bool;
}



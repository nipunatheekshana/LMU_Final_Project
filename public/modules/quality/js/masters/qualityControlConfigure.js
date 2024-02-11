console.log('qualityControlConfigure.js loading');
var parent_url = '/quality/qualityControl_list';
var startDate = 0;
var endDate = 0;
var GrnId;
var grnDtlId;
$(document).ready(function () {

    //date range pikker callback Function
    $(function () {
        $('#daterangepicker').daterangepicker({
            opens: 'left',
            // endDate: moment().subtract(5, 'day'),
        }, function (start, end, label) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
            loadGrns('filters');
        });
    });

    $('#customSwitchInline1').on('change', function () {
        if ($(this).is(':checked')) {
            swal("Switch is ON", "Sweet Alert message when switch is turned ON", "success");
        } else {
            swal("Switch is OFF", "Sweet Alert message when switch is turned OFF", "warning");
        }
    });

    // Fish Details Table
    var tblFishDetails = $('#tblFishDetails').DataTable(
        {
            scrollY: 300,
            scrollX: false,
            scrollCollapse: true,
            paging: false,
            searching: true,
            info: false,
            select: 'multi',
            'columnDefs': [
                {
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    "visible": true,
                    "className": "text-center",
                },
                {
                    "targets": [9],
                    "visible": false,

                }
            ],

            "columns": [
                { "data": "thNo", 'width': "5%" },
                { "data": "thFishType", 'width': "10%" },
                { "data": "thQGrade", 'width': "5%" },
                { "data": "thSize", 'width': "15%" },
                { "data": "thWeight", 'width': "10%" },
                { "data": "thStatus", 'width': "15%" },
                { "data": "thTestValue", 'width': "10%" },
                { "data": "thQualityStatus", 'width': "15%" },
                { "data": "thAction", 'width': "15%" },
                { "data": "id", }

            ],
        }
    );

    // Pcs Details Table
    var tblPcsDetails = $('#tblPcsDetails').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        displayLength: 25,
        'columnDefs': [
            {
                "targets": [0, 1, 2, 3, 4, 5, 6],
                "visible": true,
                "className": "text-center",
            },
            {
                "targets": [7],
                "visible": false,
            }
        ],

        "columns": [
            { "data": "thNo", 'width': "5%" },
            { "data": "thPcsCode", 'width': "20%" },
            { "data": "thWeight", 'width': "15%" },
            { "data": "thStatus", 'width': "20%" },
            { "data": "thTestValue", 'width': "10%" },
            { "data": "thQualityStatus", 'width': "20%" },
            { "data": "thAction", 'width': "10%" },
            { "data": "id" }

        ],
    });

    $('#tblPcsDetails tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
    });

    // Thresholds Table
    var tblTresholds = $('#tblTresholds').DataTable({
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
            { "data": "thFishType", 'width': "50%" },
            { "data": "thTresholdAlert", 'width': "15%" },
            { "data": "thTresholdLock", 'width': "15%" },
            { "data": "thAutoLock", 'width': "20%" }
        ]
    });

    // GRN Details Table (on Select GRN Modal)
    var tblGRNDetails = $('#tblGRNDetails').DataTable({
        pageLength: 25,
        scrollX: true,
        scrollCollapse: true,
        colReorder: true,
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '5px')
                }
            },
            {
                "targets": [0, 1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13],
                "className": "text-center",

            },
            {
                "targets": [5],
                "className": "text-right",
            },
            {
                "targets": [0, 1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13],
                "width": "3%",
            }
        ],
        "order": [],

        'pageLength': 20,
        'dom': 'rtip',

        "columns": [
            { "data": "thGrnNo" },
            { "data": "thGRNDate" },
            { "data": "thType" },
            { "data": "thSupplier" },
            { "data": "thTotalQty" },
            { "data": "thTotalWeight" },
            { "data": "thUnprocessedPCs" },
            { "data": "thProcessedPcs" },
            { "data": "thTransferPcs" },
            { "data": "thRejectPcs" },
            { "data": "thReceivingStatus" },
            { "data": "thFinanceStatus" },
            { "data": "thVoucherStatus" },
            { "data": "thGrnNo2" },
            { "data": "thAction" },

        ],
    });

    tblFishDetails.on('select', function (e, dt, type, indexes) {
        var selectedRows = tblFishDetails.rows({ selected: true }).data().toArray();
        // console.log(selectedRows);
        if (selectedRows.length == 1) {
            grnDtlId = selectedRows[0]['id'];
            loadPcsDetails()
        } else {
            grnDtlId = undefined;
            tblPcsDetails.clear();
            tblPcsDetails.draw();
        }
    });

    // Search Field for tblGRNDetails
    $('#tableSearch').keyup(function () {
        tblGRNDetails.search($(this).val()).draw();
    })

    // Select GRN Modal Button
    $('#btnSelectGRN').click(function () {
        loadGrns('');
    });

    //###################################################################
    //####################### to remove begins ##########################
    //###################################################################
    $('#btnThresholds').click(function () {
        $('#modalTresholds').modal('toggle');
    });
    $('#btnAdminChanges').click(function () {
        $('#modalAdminChanges').modal('toggle');
    });
    $('#btnRejectGroup').click(function () {
        $('#modalReject').modal('toggle');
    });
    $('#btnEdit').click(function () {
        $('#modalEditFish').modal('toggle');
    });
    $('#btnLockFish').click(function () {
        lockFish();
    });
    $('#btnUnlockFish').click(function () {
        unlockFish();
    });
    $('#btnLockPcs').click(function () {
        lockPcs();
    });
    $('#btnUnlockPcs').click(function () {
        unlockPcs();
    });




    //###################################################################
    //####################### to remove ends ############################
    //###################################################################

    $('#btnSelectAllFish').click(function () {
        selectDeselectAll('selectall', 'fish')
    });
    $('#btnDeSelectAllFish').click(function () {
        selectDeselectAll('deSelectall', 'fish')
    });
    $('#btnSelectAllPcs').click(function () {
        selectDeselectAll('selectall', 'pcs')
    });
    $('#btnDeSelectAllPcs').click(function () {
        selectDeselectAll('deSelectall', 'pcs')
    });
    $('#btnLockSelectedFish').click(function () {
        bulkLockUnlockFish('lock')
    });
    $('#btnUnlockSelectedFish').click(function () {
        bulkLockUnlockFish('unlock')
    });
    $('#btnLockSelectedPcs').click(function () {
        bulkLockUnlockPcs('lock');
    });
    $('#btnUnlockSelectedPcs').click(function () {
        bulkLockUnlockPcs('unlock');
    });
    $('#btnSetTestValue').click(function () {
        updateTestValues();
    });
    $('#rejectConfirmBtn').click(function () {
        rejectAllowFish('rej');
    });
    $('#btnAllowGroup').click(function () {
        rejectAllowFish('allow');
    });
    $('#btnRejectPce').click(function () {
        rejectAllowPcs('rej');
    });
    $('#btnAllowPce').click(function () {
        rejectAllowPcs('allow');
    });
    $('#btnAllowPce').click(function () {
        rejectAllowPcs('allow');
    });
    $('#btnUpdateAdminChanges').click(function () {
        updateAdminChanges();
    });
    $('#modalEditFish_btnUpdate').click(function () {
        UpdateFish();
    });


    $('#testType').change(function () {
        if (GrnId) {
            addGrn();
        }
        if (grnDtlId) {
            selectPreviousRow();
            loadPcsDetails()
        }
    });



    $('.select2').select2({
        placeholder: 'Select'
    });


    loadTestTypes();
    loadBoatsAndLandingSites();
});


// function lockSelectedPcs() {
//     swal({
//         title: "Are you sure to Lock Selected?",
//         text: "Are you sure to lock this selected Pieces",
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//     })
//     if (willDelete) {
//         swal("Selected Pieces Locked!", {
//             icon: "success",
//         });
//     }
//     else {
//         swal("Cancelled", {
//             icon: "error",
//         });
//     }
// };
// function unlockSelectedPcs() {
//     swal({
//         title: "Are you sure to Unlock Selected?",
//         text: "Are you sure to unlock this selected Pieces",
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//     })
//     if (willDelete) {
//         swal("Selected Pieces Unlocked!", {
//             icon: "success",
//         });
//     }
//     else {
//         swal("Cancelled", {
//             icon: "error",
//         });
//     }
// };

function loadTestTypes() {
    $.ajax({
        type: 'GET',
        url: '/quality/qualityControlConfigure/loadTestTypes',
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.testTypeName + ' </option>';
                });
                $('#testType').append(html);
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}
function getFilterValues() {
    var supplier = $('#supplier').val();
    var boat = $('#boat').val();
    var type = $('#type').val();

    return {
        'supplier': supplier,
        'boat': boat,
        'type': type,
        'startDate': startDate,
        'endDate': endDate
    }
}
function loadGrns(type) {
    $.ajax({
        type: 'GET',
        url: '/quality/qualityControlConfigure/loadGrns',
        data: getFilterValues(),
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = [];

                $.each(response.result, function (i, val) {
                    data.push({
                        "thGrnNo": '<a type="button" class="badge badge-primary text-light" onclick="setGrnId(' + val.id + ')">' + val.grnno + '</a>',
                        "thGRNDate": val.grndate,
                        "thType": grnType(val.grn_type),
                        "thSupplier": val.supplier_name,
                        "thTotalQty": val.totalQty,
                        "thTotalWeight": val.totFishWeight,
                        "thUnprocessedPCs": val.unprocessedPCs,
                        "thProcessedPcs": val.processedPcs,
                        "thTransferPcs": val.transferPcs,
                        "thRejectPcs": val.rejectPcs,
                        "thReceivingStatus": receivingStatus(val.unload_status),
                        "thFinanceStatus": financeStatus(val.finance_status),
                        "thVoucherStatus": voucherStatus(val.voucher_status),
                        "thGrnNo2": val.grnno,
                        "thAction": '<button type="button" class="btn btn-primary btn-floating" onclick="setGrnId(' + val.id + ')"><i class="ti-angle-right"></i></button>',
                    });
                });
                var table = $('#tblGRNDetails').DataTable();
                table.clear();
                table.rows.add(data).draw();
                if (type == '') {
                    $('#modalSelectGRN').modal('toggle');
                }
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}
function grnType(type) {
    var grn_type;
    if (Number(type) == 1) {
        grn_type = '<span class="badge badge-primary">Individual</span>';
    } else {
        grn_type = '<span class="badge badge-secondary">Bulk</span>';
    }
    return grn_type;
}
function receivingStatus(state, el) {
    var status;
    switch (Number(state)) {
        case 0:
            if (el == 'header') {
                status = '<span class="badge badge-warning mb-2 w-100 ">Pending</span>';
            } else {
                status = '<span class="badge badge-warning ">Pending</span>';
            }
            break;
        case 1:
            if (el == 'header') {
                status = '<span class="badge badge-success mb-2 w-100">close</span>';
            } else {
                status = '<span class="badge badge-success">close</span>';
            }
            break;
        case 2:
            if (el == 'header') {
                status = '<span class="badge badge-success mb-2 w-100">close</span>';
            } else {
                status = '<span class="badge badge-success">close</span>';
            }
            break;
    }
    return status;
}
function financeStatus(state, el) {
    var finance_status;
    if (Number(state) == 0) {
        if (el == 'header') {
            finance_status = `<span class="badge badge-warning mb-2 w-100">Pending</span>`
        } else {
            finance_status = `<span class="badge badge-warning">Pending</span>`
        }
    } else {
        if (el == 'header') {
            finance_status = `<span class="badge badge-success mb-2 w-100">Priced</span>`
        } else {
            finance_status = `<span class="badge badge-success">Priced</span>`
        }
    }
    return finance_status;
}
function voucherStatus(state, el) {
    var voucher_status;
    if (Number(state) == 0) {
        if (el == 'header') {
            voucher_status = `<span class="badge badge-warning mb-2 w-100">Not Created</span>`
        } else {
            voucher_status = `<span class="badge badge-warning">Not Created</span>`
        }
    } else {
        if (el == 'header') {
            voucher_status = `<span class="badge badge-success mb-2 w-100">Created</span>`
        } else {
            voucher_status = `<span class="badge badge-success">Created</span>`
        }
    }
    return voucher_status;
}
function setGrnId(id) {
    GrnId = id;
    addGrn();
    $('#modalSelectGRN').modal('toggle');
}
function addGrn() {
    var testType = $('#testType').val();
    $.ajax({
        type: 'GET',
        url: '/quality/qualityControlConfigure/addGrn/' + GrnId + '/' + testType,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                setGrnHeader(response.result.GrnsHeader);
                setGrnDetails(response.result.grnDetails);
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}
function setGrnHeader(data) {
    $('#header_grnNo').html(data.grnno);
    $('#header_grnDate').html(data.grndate);
    $('#header_supplier').html(data.supplier_name);
    $('#header_total').html(data.totalQty);
    $('#header_processed').html(data.processedPcs);
    $('#header_unprocessed').html(data.unprocessedPCs);
    $('#header_receivingStatus').html(receivingStatus(data.unload_status, 'header'));
    $('#header_financeStatus').html(financeStatus(data.finance_status, 'header'));
    $('#header_voucherStatus').html(voucherStatus(data.voucher_status, 'header'));

    $('#boatAdmin').val(data.boat_landing_site_id);
    $('#landingSites').val(data.boat_id);

}
function setGrnDetails(details) {
    var data = [];
    $.each(details, function (i, val) {
        data.push({
            "thNo": val.lot_serial_no,
            "thFishType": val.FishCode,
            "thQGrade": val.quality_grade,
            "thSize": val.SizeDescription,
            "thWeight": val.net_weight,
            "thStatus": fishStatus(val.item_Status),
            "thTestValue": val.ppm_level,
            "thQualityStatus": qualityVerificationStatus(val.quality_verify_status),
            "thAction": actionButons(val.quality_verify_status, val.id),
            "id": val.id,
        });
    });
    var table = $('#tblFishDetails').DataTable();
    table.clear();
    table.rows.add(data).draw();
}
function actionButons(QVstatus, GrnDtlId) {
    var editBtn = '<button class="btn btn-sm btn-primary" onclick="edit(' + GrnDtlId + ')"><i class="fa fa-pencil" aria-hidden="true"></i></button>'
        , lockBtn;

    switch (Number(QVstatus)) {
        case 0:
            lockBtn = `<button class="btn btn-danger btn-sm mr-1" onclick="locuUnlockgrnDetails(` + GrnDtlId + `,'lock')"><i class="fa fa-lock" aria-hidden="true"></i></button>`
            break;
        case 1:
            lockBtn = `<button class="btn btn-success btn-sm mr-1" onclick="locuUnlockgrnDetails(` + GrnDtlId + `,'unlock')"><i class="fa fa-unlock" aria-hidden="true"></i></button>`
            break;
        case 2:
            lockBtn = '<button class="btn btn-success btn-sm mr-1"  disabled><i class="fa fa-unlock" aria-hidden="true"></i></button>'
            break;
    }
    return lockBtn + editBtn;
}
function qualityVerificationStatus(QVstatus) {
    var status = '';
    switch (Number(QVstatus)) {
        case 1:
            status = '<span class="badge badge-danger">Locked</span>'
            break;
        case 2:
            status = '<span class="badge badge-warning">Rejected</span>'
            break;
    }
    return status
}
function fishStatus(fishStatus) {
    var status;
    switch (Number(fishStatus)) {
        case 0:
            status = '<span class="badge badge-info">Received</span>'
            break;
        case 1:
            status = '<span class="badge badge-success">Processed</span>'
            break;
        case 2:
            status = '<span class="badge badge-warning">Hold</span>'
            break;
        case 3:
            status = '<span class="badge badge-danger">Rejected</span>'
            break;
        case 4:
            status = '<span class="badge badge-secondary">Transferred</span>'
            break;
    }
    return status;
}
function loadPcsDetails() {
    var testType = $('#testType').val();
    $.ajax({
        type: 'GET',
        url: '/quality/qualityControlConfigure/loadPcsDetails/' + grnDtlId + '/' + testType,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = [];
                $.each(response.result, function (i, val) {
                    data.push({
                        "thNo": val.pcs_no,
                        "thPcsCode": val.pcs_barcode,
                        "thWeight": val.pcs_weight,
                        "thStatus": productionDetailStatus(val.pcs_status),
                        "thTestValue": val.resultValue,
                        "thQualityStatus": qualityVerificationStatus(val.lock_status),
                        "thAction": ProductionDetailsActionButtons(val.lock_status, val.id),
                        "id": val.id,

                    });
                });
                var table = $('#tblPcsDetails').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}
function productionDetailStatus(QVstatus) {
    var status = '';
    switch (Number(QVstatus)) {
        case 0:
            status = '<span class="badge badge-warning">Processed</span>'
            break;
        case 1:
            status = '<span class="badge badge-success">Packed</span>'
            break;
        case 2:
            status = '<span class="badge badge-danger">Rejected</span>'
            break;
    }
    return status
}
function ProductionDetailsActionButtons(QVstatus, pcsId) {
    var lockBtn;

    switch (Number(QVstatus)) {
        case 0:
            lockBtn = `<button class="btn btn-danger btn-sm mr-1"  onclick="lockUnlockPcs(` + pcsId + `,'lock')"><i class="fa fa-lock" aria-hidden="true"></i></button>`;
            break;
        case 1:
            lockBtn = `<button class="btn btn-success btn-sm mr-1" onclick="lockUnlockPcs(` + pcsId + `,'unlock')"><i class="fa fa-unlock" aria-hidden="true"></i></button>`
            break;
        case 2:
            lockBtn = '<button class="btn btn-success btn-sm mr-1" disabled><i class="fa fa-unlock" aria-hidden="true"></i></button>'
            break;
    }
    return lockBtn;
}
function selectPreviousRow() {
    var table = $('#tblFishDetails').DataTable();
    //select the previos selected row
    table.rows().every(function () {
        if (this.data().id == grnDtlId) {
            this.select();
        }
    });
}
function locuUnlockgrnDetails(GrnDtlId, status) {
    swal({
        title: "Are you sure to " + status + "?",
        text: "Are you sure to " + status + " this selected fish",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'GET',
                    url: '/quality/qualityControlConfigure/locuUnlockgrnDetails/' + GrnDtlId + '/' + status,
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            addGrn();
                            if (grnDtlId) {
                                selectPreviousRow();
                                loadPcsDetails();
                            }
                            swal("Done!", {
                                icon: "success",
                            });
                        }
                    }, error: function (data) {
                        console.log(data)
                        console.log('something went wrong');
                    }
                });
            }
            else {
                swal("Cancelled", {
                    icon: "error",
                });
            }
        });
}
function lockUnlockPcs(pcsId, status) {
    swal({
        title: "Are you sure to " + status + "?",
        text: "Are you sure to " + status + " this selected Piece",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {

            if (willDelete) {
                $.ajax({
                    type: 'GET',
                    url: '/quality/qualityControlConfigure/lockUnlockPcs/' + pcsId + '/' + status,
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            loadPcsDetails();
                            swal("Done!", {
                                icon: "success",
                            });
                        }
                    }, error: function (data) {
                        console.log(data)
                        console.log('something went wrong');
                    }
                });
            }
            else {
                swal("Cancelled", {
                    icon: "error",
                });
            }
        });
}
function selectDeselectAll(status, tbl) {
    var table;
    switch (tbl) {
        case 'fish':
            table = $('#tblFishDetails').DataTable();
            break;
        case 'pcs':
            table = $('#tblPcsDetails').DataTable();
            break;
    }
    switch (status) {
        case 'selectall':
            table.rows().select();
            break;
        case 'deSelectall':
            table.rows().deselect();
            break;
    }
}
function bulkLockUnlockFish(status) {
    swal({
        title: "Are you sure to " + status + " Selected?",
        text: "Are you sure to " + status + " this selected fish",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'GET',
                    url: '/quality/qualityControlConfigure/bulkLockUnlockFish/' + status,
                    data: { 'arr': idArr('fish') },
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            addGrn();

                            swal("Done!", {
                                icon: "success",
                            });
                        }
                    }, error: function (data) {
                        console.log(data)
                        console.log('something went wrong');
                    }
                });
            }
            else {
                swal("Cancelled", {
                    icon: "error",
                });
            }
        });
}
function bulkLockUnlockPcs(status) {
    swal({
        title: "Are you sure to " + status + " Selected?",
        text: "Are you sure to " + status + " this selected Pieces",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'GET',
                    url: '/quality/qualityControlConfigure/bulkLockUnlockPcs/' + status,
                    data: { 'arr': idArr('pcs') },
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            if (grnDtlId) {
                                loadPcsDetails();
                            }
                            swal("Done!", {
                                icon: "success",
                            });
                        }
                    }, error: function (data) {
                        console.log(data)
                        console.log('something went wrong');
                    }
                });
            }
            else {
                swal("Cancelled", {
                    icon: "error",
                });
            }
        });
}
function idArr(tbl) {
    var table
        , arr = [];
    switch (tbl) {
        case 'fish':
            table = $('#tblFishDetails').DataTable();
            break;
        case 'pcs':
            table = $('#tblPcsDetails').DataTable();
            break;
    }
    var selectedRows = table.rows({ selected: true }).data().toArray()
    $.each(selectedRows, function (i, val) {
        arr.push(val.id)
    });
    return arr;
}
function updateTestValues() {
    swal({
        title: "Are you sure to Set Values?",
        text: "You will set values to all selected",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {

            if (willDelete) {
                var val = $('#value').val();
                var testType = $('#testType').val();
                $.ajax({
                    type: 'GET',
                    url: '/quality/qualityControlConfigure/updateTestValues',
                    data: { 'arr': idArr('fish'), 'val': val, 'testType': testType },
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            addGrn();
                            loadPcsDetails();
                            swal("Test Values Set!", {
                                icon: "success",
                            });
                        }
                    }, error: function (data) {
                        console.log(data)
                        console.log('something went wrong');
                    }
                });

            }
            else {
                swal("Cancelled", {
                    icon: "error",
                });
            }
        });


}
function rejectAllowFish(status) {
    var reson = $('#rejectReson').val();
    $.ajax({
        type: 'GET',
        url: '/quality/qualityControlConfigure/rejectAllowFish/' + status,
        data: { 'arr': idArr('fish'), 'reson': reson },
        success: function (response) {
            console.log(response)
            if (response.success) {
                addGrn();
                loadPcsDetails();
                if (status == 'rej') {
                    $('#modalReject').modal('toggle');
                }
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}
function rejectAllowPcs(status) {
    $.ajax({
        type: 'GET',
        url: '/quality/qualityControlConfigure/rejectAllowPcs/' + status,
        data: { 'arr': idArr('pcs') },
        success: function (response) {
            console.log(response)
            if (response.success) {
                loadPcsDetails();
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}
function loadBoatsAndLandingSites() {
    $.ajax({
        type: 'GET',
        url: '/quality/qualityControlConfigure/loadBoatsAndLandingSites',
        success: function (response) {
            console.log(response)
            if (response.success) {
                var boats = ""
                    , landingSites = "";

                $.each(response.result.Boat, function (index, value) {
                    boats += '<option value="' + value.id + '" > ' + value.BoatRegNo + ' | ' + value.BoatName + ' | ' + value.LicenseExpDate + ' </option>';
                });
                $.each(response.result.Landingsite, function (index, value) {
                    landingSites += '<option value="' + value.id + '" > ' + value.LandingSiteName + ' </option>';
                });

                $('#boatAdmin').html(boats);
                $('#landingSites').html(landingSites);

            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}
function updateAdminChanges() {
    if (GrnId) {
        var boat = $('#boatAdmin').val()
            , landingSit = $('#landingSites').val();
        $.ajax({
            type: 'GET',
            url: '/quality/qualityControlConfigure/updateAdminChanges/' + GrnId,
            data: { 'boat': boat, 'landingSit': landingSit },
            success: function (response) {
                console.log(response)
                if (response.success) {
                    $('#modalAdminChanges').modal('toggle');
                }
            }, error: function (data) {
                console.log(data)
                console.log('something went wrong');
            }
        });
    } else {
        toastr.warning('Please add a grn first');
    }
}
function edit(GrnDtlId) {
    $.ajax({
        type: 'GET',
        url: '/quality/qualityControlConfigure/edit/' + GrnDtlId,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var GRNDetail = response.result.GRNDetail
                    , QualityGrades = response.result.QualityGrades
                    , history = response.result.history
                    , html;

                $.each(QualityGrades, function (index, value) {
                    html += '<option value="' + value.QFishGrade + '" > ' + value.QFishGrade + ' </option>';
                });
                $('#EditFish_grade').html(html);

                $('#EditFish_fishNo').html(GRNDetail.lot_serial_no);
                $('#EditFish_fishType').html(GRNDetail.FishCode);
                $('#EditFish_size').html(GRNDetail.SizeDescription);
                $('#EditFish_weight').html(GRNDetail.net_weight);
                $('#EditFish_grade').val(GRNDetail.quality_grade);
                $('#EditFish_grnDtlId').val(GrnDtlId);

                showHistory(history)

                $('#modalEditFish').modal('toggle');
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });

}
function showHistory(data) {
    var timeline='';
    if (data.length != 0) {
        $.each(data, function (i, val) {
            var html = `<div class="timeline-item">
                            <div>
                                <figure class="avatar avatar-sm mr-3 bring-forward">
                                    <span class="avatar-title bg-`+ val.color + `-bright text-` + val.color + ` rounded-circle">
                                        <i class="`+ val.icon + `" aria-hidden="true"></i>
                                    </span>
                                </figure>
                            </div>
                            <div>
                                <h6 class="d-flex justify-content-between mb-4">
                                    <span>
                                    `+ val.activity + `
                                    </span>
                                    <span class="text-muted font-weight-normal">`+ val.time + `</span>
                                </h6>
                            </div>
                        </div>`
            timeline += html;

        });
    }
    $('#timeline').html(timeline);
}
function UpdateFish() {
    var quality_grade = $('#EditFish_grade').val()
        , grnDtlId = $('#EditFish_grnDtlId').val();
    $.ajax({
        type: 'GET',
        url: '/quality/qualityControlConfigure/UpdateFish/' + quality_grade + '/' + grnDtlId,
        success: function (response) {
            console.log(response)
            if (response.success) {
                addGrn();
                $('#modalEditFish').modal('toggle');
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}

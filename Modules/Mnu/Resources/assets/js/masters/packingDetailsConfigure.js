console.log("packingDetailsConfigure .js loadimng");
var mainPlId
    , startDate = 0
    , endDate = 0
    , checkBxId1 = 0
    , checkBxId2 = 0
    , checkBxId3 = 0
    , checkBxId4 = 0;
// var EPLNo = 1;

$(document).ready(function () {
    var tableWorksheets = $("#tableWorksheets").DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        searching: false,
        paging: false,
        info: false,

        select: {
            style: "single"
        },

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "2px");
                }
            },

            {
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                className: "text-center"
            }
        ],
        order: [],
        columns: [
            { data: "thWSNo", width: "10%" },
            { data: "thWSDate", width: "5%" },
            { data: "thCustomer", width: "15%" },
            { data: "thOrderNo", width: "10%" },
            { data: "thPONo", width: "10%" },
            { data: "thTotQty", width: "10%" },
            { data: "thTotWgt", width: "10%" },
            { data: "thPendQty", width: "10%" },
            { data: "thPendWeight", width: "10%" }
        ]
    });

    var tblWorksheetDetails = $("#tableWorksheetDetails").DataTable({
        scrollY: 400,
        scrollX: false,
        scrollCollapse: true,
        searching: false,
        paging: false,
        info: false,
        select: {
            style: "single"
        },

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "2px");
                }
            },
            {
                targets: [5],
                visible: false
            },
            {
                targets: [0, 1, 2, 3, 4],
                className: "text-center"
            }
        ],
        order: [],
        columns: [
            { data: "thProduct", width: "35%" },
            { data: "thTotalQty", width: "10%" },
            { data: "thComplQty", width: "10%" },
            { data: "thPackingStatus", width: "20%" },
            { data: "thPendingPL", width: "10%" },
            { data: "wsId" }
        ]
    });

    var tblGeneralPackingList = $("#tableGeneralPackingList").DataTable({
        scrollY: 400,
        scrollX: false,
        scrollCollapse: true,
        searching: false,
        paging: false,
        info: false,

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "5px");
                }
            },

            {
                targets: [0, 1, 2, 3, 4, 5, 6, 7],
                className: "text-center"
            }
        ],
        order: [],
        columns: [
            { data: "thPLNo", width: "15%" },
            { data: "thFrom", width: "5%" },
            { data: "thTo", width: "5%" },
            { data: "thQty", width: "10%" },
            { data: "thWeight", width: "10%" },
            { data: "thPLST", width: "15%" },
            { data: "thExpPLNo", width: "15%" },
            { data: "thActions", width: "25%" }
        ]
    });

    var tblExportPackingList = $("#tableExportPackingList").DataTable({
        scrollY: 400,
        scrollX: false,
        scrollCollapse: true,
        searching: false,
        paging: false,
        info: false,

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "5px");
                }
            },

            {
                targets: [0, 1, 2, 3, 4, 5, 6, 7],
                className: "text-center"
            }
        ],
        order: [],
        columns: [
            { data: "thPLNo", width: "15%" },
            { data: "thPLDate", width: "10%" },
            { data: "thAWBNo", width: "10%" },
            { data: "thFlightNo", width: "10%" },
            { data: "thFlightDate", width: "10%" },
            { data: "thInvStatus", width: "10%" },
            { data: "thInvNo", width: "15%" },
            { data: "thActions", width: "25%" }
        ]
    });

    var tblModalGeneralPLWS = $("#tableModalGeneralPLWS").DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: false,
        searching: false,
        paging: false,
        info: false,
        select: {
            style: "single"
        },

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "2px");
                }
            },
            {
                targets: [6],
                visible: false
            },
            {
                targets: [0, 1, 2, 3, 4, 5],
                className: "text-center"
            }
        ],

        createdRow: function (row, data, dataIndex) {
            if (data["thGrossWgt"] == null) {
                $(row).addClass("bg-warning-bright");
            }
        },

        order: [],
        columns: [
            { data: "thSelect", width: "5%" },
            { data: "thBoxNo", width: "10%" },
            { data: "thProduct", width: "45%" },
            { data: "thPcs", width: "10%" },
            { data: "thNetWgt", width: "15%" },
            { data: "thGrossWgt", width: "15%" },
            { data: "id" }
        ]
    });

    var tblModalGeneralPLSelected = $("#tableModalGeneralPLSelected").DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: false,
        searching: false,
        paging: false,
        info: false,
        select: {
            style: "single"
        },

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "2px");
                }
            },
            {
                targets: [6],
                visible: false
            },

            {
                targets: [0, 1, 2, 3, 4, 5],
                className: "text-center"
            }
        ],
        order: [],
        columns: [
            { data: "thSelect", width: "5%" },
            { data: "thBoxNo", width: "10%" },
            { data: "thProduct", width: "45%" },
            { data: "thPcs", width: "10%" },
            { data: "thNetWgt", width: "15%" },
            { data: "thGrossWgt", width: "15%" },
            { data: "id" }
        ]
    });

    var tblModalGeneralPLSummary = $("#tableModalGeneralPLSummary").DataTable({
        scrollY: 400,
        scrollX: false,
        scrollCollapse: true,
        searching: false,
        paging: false,
        info: false,
        select: {
            style: "single"
        },

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "2px");
                }
            },

            {
                targets: [0, 1, 2, 3],
                className: "text-center"
            }
        ],

        order: [],
        columns: [
            { data: "thProduct", width: "55%" },
            { data: "thBoxQty", width: "15%" },
            { data: "thNetWgt", width: "15%" },
            { data: "thGrossWgt", width: "15%" }
        ]
    });

    var tblModalExportPLGeneralPL = $("#tableModalExportPLGeneralPL").DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: false,
        searching: false,
        paging: false,
        info: false,
        select: {
            style: "single"
        },

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "2px");
                }
            },
            {
                targets: [6],
                visible: false
            },

            {
                targets: [0, 1, 2, 3, 4, 5],
                className: "text-center"
            }
        ],
        // "order": [],
        columns: [
            { data: "thSelect", width: "5%" },
            { data: "thGenPLNo", width: "45%" },
            { data: "thFrom", width: "10%" },
            { data: "thTo", width: "10%" },
            { data: "thBoxQty", width: "15%" },
            { data: "thBoxWgt", width: "15%" },
            { data: "id" }
        ]
    });

    var tblModalExportPLSelected = $("#tableModalExportPLSelected").DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: false,
        searching: false,
        paging: false,
        info: false,
        select: {
            style: "single"
        },

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "2px");
                }
            },
            {
                targets: [6],
                visible: false
            },
            {
                targets: [0, 1, 2, 3, 4, 5],
                className: "text-center"
            }
        ],
        // "order": [],
        columns: [
            { data: "thSelect", width: "5%" },
            { data: "thGenPLNo", width: "45%" },
            { data: "thFrom", width: "10%" },
            { data: "thTo", width: "10%" },
            { data: "thBoxQty", width: "15%" },
            { data: "thBoxWgt", width: "15%" },
            { data: "id" }
        ]
    });

    var tblModalExportPLSummary = $("#tableModalExportPLSummary").DataTable({
        scrollY: 400,
        scrollX: false,
        scrollCollapse: true,
        searching: false,
        paging: false,
        info: false,
        select: {
            style: "single"
        },

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "2px");
                }
            },
            {
                targets: [7],
                visible: false
            },
            {
                targets: [0, 1, 2, 3, , 4, 5, 6],
                className: "text-center"
            }
        ],
        order: [],
        columns: [
            { data: "thBoxNo", width: "10%" },
            { data: "thProduct", width: "35%" },
            { data: "thBoxQty", width: "10%" },
            { data: "thNetWgt", width: "10%" },
            { data: "thGrossWgt", width: "10%" },
            { data: "thGenPLNo", width: "15%" },
            { data: "thPackCode", width: "20%" },
            { data: "id" }
        ]
    });

    var tblModalExportPLBoxSummary = $("#tableModalExportPLBoxSummary").DataTable({
        scrollY: 400,
        scrollX: false,
        scrollCollapse: true,
        searching: false,
        paging: false,
        info: false,
        select: {
            style: "single"
        },

        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("padding", "2px");
                }
            },

            {
                targets: [0, 1, 2],
                className: "text-center"
            }
        ],
        order: [],
        columns: [
            { data: "thProduct", width: "60%" },
            { data: "thWeight", width: "20%" },
            { data: "thBoxQty", width: "20%" }
        ]
    });
    tableWorksheets.on("select", function (e, dt, type, indexes) {
        if (type === "row") {
            loadWsData(indexes[0]);
        }
    });
    $(function () {
        $("#daterangepicker").daterangepicker(
            {
                opens: "left"
            },
            function (start, end, label) {
                startDate = start.format("YYYY-MM-DD");
                endDate = end.format("YYYY-MM-DD");
                loadWorkSheets();
            }
        );
    });

    $(".select2-customer").select2({
        placeholder: "Select"
    });
    $(".select2-wsno").select2({
        placeholder: "Select"
    });
    $("#air_line").select2({
        placeholder: "Select"
    });
    $("#destination").select2({
        placeholder: "Select"
    });


    $("#btnNewGenPL").click(function () {
        clearGplTables();
        loadNewGenPL();
    });
    $("#btnNewExpPL").click(function () {
        clearExplTables();
        loadNewExpPL();
    });
    $("#btnSelectall1").click(function () {
        selectAll(1);
    });
    $("#btnSelectall2").click(function () {
        selectAll(2);
    });
    $("#btnSelectall3").click(function () {
        selectAll(3);
    });
    $("#btnSelectall4").click(function () {
        selectAll(4);
    });
    $("#buttonToRight1").click(function () {
        transferBoxesToTable(1);
    });
    $("#buttonToLeft1").click(function () {
        transferBoxesToTable(2);
    });
    $("#buttonToRight2").click(function () {
        transferGplsToTable(3);
    });
    $("#buttonToLeft2").click(function () {
        transferGplsToTable(4);
    });
    $('#btnReport').click(function () {
        getReport();
    });
    $("#ModalGenPL_btnSave").click(function () {
        $("#buttonToLeft1").prop("disabled", false);
        $("#buttonToRight1").prop("disabled", false);
        
        var data = new FormData();
        createGplSaveData(data);

        for (var pair of data.entries()) {
            console.log(pair[0] + " => " + pair[1]);
        }
        if ($("#ModalGenPL_btnSave").text().trim() == "Save") {
            saveGpl(data);
        } else {
            UpdateGpl(data);
        }
    });
    $("#ModalExPL_btnSave").click(function () {
        var form = $('#frmExportPackingListDetails').get(0);
        var data = new FormData(form);
        createExplSaveData(data);

        for (var pair of data.entries()) {
            console.log(pair[0] + " => " + pair[1]);
        }
        if ($("#ModalExPL_btnSave").text().trim() == "Save") {
            saveExpl(data);
        } else {
            UpdateExpl(data);
        }
    });

    $("#customer").change(function () {
        loadWorkSheets();
    });
    $("#wsNumber").change(function () {
        loadWorkSheets();
    });
    $('#consignee').change(function () {
        loadAddress('consignee', this.value);
    });
    $('#notify_party').change(function () {
        loadAddress('notify', this.value);
    });
    $('#pickList_on').change(function () {
        LOadPickListBoxes(this.value);
    });
    loadWSnumbers();
    loadCustomers();
    loadWorkSheets();
    loadDestinations();
    loadAirlines();

});
function loadWSnumbers() {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadWSnumbers",
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';

                $.each(response.result, function (index, value) {
                    html +=
                        '<option value="' +
                        value.mainPlID +
                        '" > ' +
                        value.mainPlID +
                        " </option>";
                });
                $("#wsNumber").html(html);
            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function loadCustomers() {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadCustomers",
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';

                $.each(response.result, function (index, value) {
                    html +=
                        '<option value="' +
                        value.id +
                        '" > ' +
                        value.CusName +
                        " </option>";
                });
                $("#customer").html(html);
            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function SetFilters() {
    var customer = $("#customer").val();
    var wsNumber = $("#wsNumber").val();

    return {
        startDate: startDate,
        endDate: endDate,
        customer: customer,
        wsNumber: wsNumber
    };
}
function loadWorkSheets() {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadWorkSheets",
        data: SetFilters(),

        success: function (response) {
            console.log(response);
            if (response.success) {
                var data = [];
                $.each(response.result, function (i, val) {
                    data.push({
                        thWSNo: val.wsNumber,
                        thWSDate: val.wsDate,
                        thCustomer: val.customer,
                        thOrderNo: val.orderNumber,
                        thPONo: val.poNumber,
                        thTotQty: val.TotalQty,
                        thTotWgt: val.TotalWeight,
                        thPendQty: val.PendingQty,
                        thPendWeight: val.PendingWeight
                    });
                });
                var table = $("#tableWorksheets").DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function loadWsData(rowIndex) {
    var table = $("#tableWorksheets").DataTable();
    var data = table.row(rowIndex).data();

    $("#lable_wsNum").html(data.thWSNo);
    $("#lable_wsDate").html(data.thWSDate);
    $("#lable_orderNum").html(data.thOrderNo);
    $("#lable_customer").html(data.thCustomer);
    $("#lable_TotBoxes").html(data.thTotQty);
    $("#lable_totWeight").html(data.thTotWgt);
    $("#lable_pendingBoxes").html(data.thPendQty);
    $("#lable_pendingWeight").html(data.thPendWeight);

    mainPlId = data.thWSNo;
    loadWorksheetDtls();
    loadGpls();
    loadExpls();
}
function loadWorksheetDtls() {
    if (is_workSheet_selected()) {
        $.ajax({
            type: "GET",
            url: "/mnu/packingDetailsConfigure/loadWorksheetDtls/" + mainPlId,
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    var data = [];
                    var pending = '<span class="badge bg-warning text-warning-bright">Pending</span>';
                    var compleated = '<span class="badge bg-success text-success-bright">Completed</span>';
                    $.each(response.result, function (i, val) {
                        var status = "";

                        if (Number(val.plannedQty) == Number(val.completedQty)) {
                            status = compleated;
                        } else {
                            status = pending;
                        }

                        data.push({
                            thProduct: val.item_name,
                            thTotalQty: val.plannedQty,
                            thComplQty: val.completedQty,
                            thPackingStatus: status,
                            thPendingPL: Number(val.plannedQty) - Number(val.completedQty),
                            wsId: val.id
                        });
                    });
                    var table = $("#tableWorksheetDetails").DataTable();
                    table.clear();
                    table.rows.add(data).draw();
                }
            },
            error: function (data) {
                console.log(data);
                console.log("something went wrong");
            }
        });
    }
}

//////////////////////////////////////////////////////
/////////////////////////GPL/////////////////////////
////////////////////////////////////////////////////

function LOadPickListBoxes(pickListNum) {
    var arr = []
        , table = $("#tableWorksheetDetails").DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arr.push(data.wsId);
    });
    if (is_workSheet_selected()) {
        $.ajax({
            type: "GET",
            url: "/mnu/packingDetailsConfigure/LOadPickListBoxes/"+pickListNum,
            async: false,
            data: { wsIdArr: arr },
            success: function (response) {
                console.log(response);
                if (response.success) {

                    var table1 = $("#tableModalGeneralPLSelected").DataTable();
                    table1.clear();
                    table1.draw();

                    addBoxesToTheTables(2, response.result);

                    $("#buttonToLeft1").prop("disabled", true);
                    $("#buttonToRight1").prop("disabled", true);


                }
            },
            error: function (data) {
                console.log(data);
                console.log("something went wrong");
            }
        });
    }
}

function loadNewGenPL() {
    var arr = [];
    var table = $("#tableWorksheetDetails").DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arr.push(data.wsId);
    });
    if (is_workSheet_selected()) {
        $.ajax({
            type: "GET",
            url: "/mnu/packingDetailsConfigure/loadNewGenPL",
            async: false,
            data: { wsIdArr: arr },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    addBoxesToTheTables(1, response.result);
                    $("#ModalGenPL_mainPlId").html(mainPlId);
                    $("#ModalGenPL").modal("toggle");
                }
            },
            error: function (data) {
                console.log(data);
                console.log("something went wrong");
            }
        });
    }
}
function addBoxesToTheTables(tab, data) {
    var result = [];
    var index = 0;
    $.each(data, function (i, val) {
        result.push({
            thSelect: `<input type="checkbox" id="checkbox` + tab + `_` + index + `">`,
            thBoxNo: val.box_no,
            thProduct: val.item_name,
            thPcs: val.noofpcs,
            thNetWgt: val.box_net_weight,
            thGrossWgt: val.box_gross_weight,
            id: val.id
        });
        index++;
    });
    switch (tab) {
        case 1:
            var table = $("#tableModalGeneralPLWS").DataTable();
            checkBxId1 = index;
            break;
        case 2:
            var table = $("#tableModalGeneralPLSelected").DataTable();
            checkBxId2 = index;
            break;
    }
    table.clear();
    table.rows.add(result).draw();
}
function transferBoxesToTable(t) {
    var arrSelected = [];
    var arrNotSelected = [];
    var has_null_gross_weight = false;
    switch (t) {
        case 1:
            var table = $("#tableModalGeneralPLWS").DataTable();
            var table2 = $("#tableModalGeneralPLSelected").DataTable();

            break;
        case 2:
            var table = $("#tableModalGeneralPLSelected").DataTable();
            var table2 = $("#tableModalGeneralPLWS").DataTable();

            break;

        default:
            break;
    }
    table2.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arrSelected.push({
            box_no: data.thBoxNo,
            item_name: data.thProduct,
            noofpcs: data.thPcs,
            box_net_weight: data.thNetWgt,
            box_gross_weight: data.thGrossWgt,
            id: data.id
        });
    });
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if ($("#checkbox" + t + "_" + rowIdx).prop("checked") == true) {
            console.log(data.thGrossWgt);
            //check for null gross weights
            if (
                data.thGrossWgt == null &&
                $("#ignore_gross_weight").prop("checked") == false
            ) {
                has_null_gross_weight = true;
            }
            arrSelected.push({
                box_no: data.thBoxNo,
                item_name: data.thProduct,
                noofpcs: data.thPcs,
                box_net_weight: data.thNetWgt,
                box_gross_weight: data.thGrossWgt,
                id: data.id
            });
        } else {
            arrNotSelected.push({
                box_no: data.thBoxNo,
                item_name: data.thProduct,
                noofpcs: data.thPcs,
                box_net_weight: data.thNetWgt,
                box_gross_weight: data.thGrossWgt,
                id: data.id
            });
        }
    });

    console.log(arrNotSelected);
    console.log(arrSelected);

    if (has_null_gross_weight) {
        toastr.warning("Can not procees null gross weight selected");
    } else {
        switch (t) {
            case 1:
                addBoxesToTheTables(1, arrNotSelected);
                addBoxesToTheTables(2, arrSelected);
                break;
            case 2:
                addBoxesToTheTables(1, arrSelected);
                addBoxesToTheTables(2, arrNotSelected);
                break;

            default:
                break;
        }
    }

    updateGplSummary();
}
function updateGplSummary() {
    var arrSummary = [];
    var table = $("#tableModalGeneralPLSelected").DataTable();

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        var product = data.thProduct;
        var qty = data.thPcs;
        var netWeight = data.thNetWgt;
        var grossWeight = data.thGrossWgt;

        if (!arrSummary.length == 0) {
            for (let i = 0; i < arrSummary.length; i++) {
                if (arrSummary[i]["thProduct"].trim() == product.trim()) {
                    qty = Number(qty) + Number(arrSummary[i]["thBoxQty"]);
                    netWeight = Number(netWeight) + Number(arrSummary[i]["thNetWgt"]);
                    grossWeight =
                        Number(grossWeight) + Number(arrSummary[i]["thGrossWgt"]);

                    arrSummary.splice(i, 1); //This removes 1 item from the array starting at indexValueOfArray
                    //because this item is alredy added above line remove the previously added item
                }
            }
        }
        arrSummary.push({
            thProduct: product,
            thBoxQty: qty,
            thNetWgt: netWeight.toFixed(3),
            thGrossWgt: grossWeight
        });
    });
    var table = $("#tableModalGeneralPLSummary").DataTable();
    table.clear();
    table.rows.add(arrSummary).draw();
    calBoxTotal(arrSummary);
}
function calBoxTotal(summary) {
    var totQty = 0;
    var totNetWeight = 0;
    var toGrossWeight = 0;

    $.each(summary, function (i, val) {
        totQty = Number(totQty) + Number(val.thBoxQty);
        totNetWeight = Number(totNetWeight) + Number(val.thNetWgt);
        toGrossWeight = Number(toGrossWeight) + Number(val.thGrossWgt);
    });

    $("#ModalGenPL_totBoxes").html(totQty);
    $("#ModalGenPL_totNetWeight").html(totNetWeight.toFixed(3));
    $("#ModalGenPL_totGrossWeight").html(toGrossWeight.toFixed(3));

    $("#ModalGenPL_txt_totBoxes").val(totQty);
    $("#ModalGenPL_txt_totNetWeight").val(totNetWeight.toFixed(3));
    $("#ModalGenPL_txt_totGrossWeight").val(toGrossWeight.toFixed(3));
}
function selectAll(button) {
    var checkBoxId;
    switch (button) {
        case 1:
            checkBoxId = checkBxId1;
            break;
        case 2:
            checkBoxId = checkBxId2;
            break;
        case 3:
            checkBoxId = checkBxId3;
            break;
        case 4:
            checkBoxId = checkBxId4;
            break;

        default:
            break;
    }
    if ($("#btnSelectall" + button).text().trim() == "Select All") {
        for (i = 0; i < "" + checkBoxId; i++) {
            $("#checkbox" + button + "_" + i).prop("checked", true);
        }
        $("#btnSelectall" + button).html("Deselect All");
    } else {
        for (i = 0; i < "" + checkBoxId; i++) {
            $("#checkbox" + button + "_" + i).prop("checked", false);
        }
        $("#btnSelectall" + button).html("Select All");
    }
}
function createGplSaveData(data) {
    var table = $("#tableModalGeneralPLSelected").DataTable();

    var arr = [];
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arr.push(data.id);
    });

    data.append("mainPlId", mainPlId);
    data.append("totalBoxes", $("#ModalGenPL_txt_totBoxes").val());
    data.append("totNetWeight", $("#ModalGenPL_txt_totNetWeight").val());
    data.append("totGrossWeight", $("#ModalGenPL_txt_totGrossWeight").val());
    data.append("BoxId", JSON.stringify(arr));
}
function saveGpl(data) {
    if (not_empty("tableModalGeneralPLSelected")) {
        $.ajax({
            type: "POST",
            url: "/mnu/packingDetailsConfigure/saveGpl",
            data: data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    clearGplTables();
                    loadGpls();
                    $("#ModalGenPL").modal("toggle");
                }
            },
            error: function (error) {
                console.log(error);
                toastr.error("Something went wrong");
            }
        });
    } else {
        toastr.warning("Select boxes first");
    }
}
function clearGplTables() {
    $("#ModalGenPL_totBoxes").html("-");
    $("#ModalGenPL_totNetWeight").html("-");
    $("#ModalGenPL_totGrossWeight").html("-");

    $("#ModalGenPL_txt_totBoxes").val("");
    $("#ModalGenPL_txt_totNetWeight").val("");
    $("#ModalGenPL_txt_totGrossWeight").val("");
    $("#ModalGenPL_txt_externelPackingId").val("");

    var table = $("#tableModalGeneralPLWS").DataTable();
    table.clear();
    table.draw();
    var table1 = $("#tableModalGeneralPLSelected").DataTable();
    table1.clear();
    table1.draw();
    var table2 = $("#tableModalGeneralPLSummary").DataTable();
    table2.clear();
    table2.draw();
    checkBxId1 = 0;
    checkBxId2 = 0;

    $("#ModalGenPL_mainPlId").html("-");
    $("#ModalGenPL_GplNo").html("New");
    $("#ModalGenPL_btnSave").text("Save");
}
function not_empty(tablename) {
    var bool = true;
    var table = $("#" + tablename).DataTable();
    if (!table.data().any()) {
        bool = false;
    }
    return bool;
}
function loadGpls() {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadGpls/" + mainPlId,
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var data = [];
                $.each(response.result, function (i, val) {
                    var edit = `<button class="btn btn-primary mr-1" onclick="editGpl(` + val.id + `)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>`
                        , del = `<button class="btn btn-danger mr-1" onclick="deleteGpl(` + val.id + `)"><i class="fa fa-trash" aria-hidden="true"></i></button>`
                        , reports = `<div class="dropdown">
                                    <button type="button" class="btn btn-warning dropdown-toggle"
                                        data-toggle="dropdown">
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="1">Action</a>
                                        <a class="dropdown-item" href="2">Another action</a>
                                        <a class="dropdown-item" href="3">Something else here</a>
                                    </div>
                                </div>`
                        , status = '';

                    if (Number(val.is_add_to_pl) == 1) {
                        status = '<span class="badge bg-success text-success-bright">Added</span>';
                    } else {
                        status = '<span class="badge bg-warning text-warning-bright">Pending</span>';
                    }

                    data.push({
                        thPLNo: val.PLno,
                        thFrom: val.from,
                        thTo: val.to,
                        thQty: val.qty,
                        thWeight: val.weight,
                        thPLST: status,
                        thExpPLNo: val.EXPplNo,
                        thActions: edit + del + reports
                    });
                });
                var table = $("#tableGeneralPackingList").DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function deleteGpl(id) {
    $.ajax({
        type: "DELETE",
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: "/mnu/packingDetailsConfigure/deleteGpl/" + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                // toastr.success(response.message);
                loadGpls();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function editGpl(id) {
    var arr = [];
    var table = $("#tableWorksheetDetails").DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arr.push(data.wsId);
    });
    if (is_workSheet_selected()) {
        $.ajax({
            type: "GET",
            url: "/mnu/packingDetailsConfigure/editGpl/" + id,
            async: false,
            data: { wsIdArr: arr },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    addBoxesToTheTables(2, response.result.SelectedPackingBox);
                    addBoxesToTheTables(1, response.result.PackingBox);
                    updateGplSummary();
                    $("#ModalGenPL_mainPlId").html(mainPlId);
                    $("#ModalGenPL_GplNo").html(response.result.ext_pl_id["gpl_no"]);
                    $("#ModalGenPL_btnSave").text("Update");
                    $("#ModalGenPL_txt_externelPackingId").val(
                        response.result.ext_pl_id["ext_pl_id"]
                    );

                    $("#ModalGenPL").modal("toggle");
                }
            },
            error: function (data) {
                console.log(data);
                console.log("something went wrong");
            }
        });
    }
}
function UpdateGpl(data) {
    var id = $("#ModalGenPL_txt_externelPackingId").val();

    if (not_empty("tableModalGeneralPLSelected")) {
        $.ajax({
            type: "POST",
            url: "/mnu/packingDetailsConfigure/UpdateGpl/" + id,
            data: data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    clearGplTables();
                    loadGpls();
                    $("#ModalGenPL").modal("toggle");
                }
            },
            error: function (error) {
                console.log(error);
                toastr.error("Something went wrong");
            }
        });
    } else {
        toastr.warning("Select boxes first");
    }
}

////////////////////////////////////////////////////////////////////
//////////////////////////ExpGpl///////////////////////////////////
//////////////////////////////////////////////////////////////////

function loadNewExpPL() {
    if (is_workSheet_selected()) {
        $.ajax({
            type: "GET",
            url: "/mnu/packingDetailsConfigure/loadNewExpPL/" + mainPlId,
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    addGplsToTheTables(3, response.result);
                    $("#ModalExpPL_mainPlId").html(mainPlId);
                    loadCustomerAddress();
                    loadCustomerNotify();
                    $("#ModalExpPL").modal("toggle");
                }
            },
            error: function (data) {
                console.log(data);
                console.log("something went wrong");
            }
        });
    }
}
function addGplsToTheTables(tab, result) {
    var data = [];
    var index = 0;
    $.each(result, function (i, val) {
        data.push({
            thSelect:
                `<input type="checkbox" id="checkbox` + tab + `_` + index + `">`,
            thGenPLNo: val.gpl_no,
            thFrom: val.from,
            thTo: val.to,
            thBoxQty: val.qty,
            thBoxWgt: val.weight,
            id: val.id
        });
        index++;
    });
    console.log(data);
    switch (tab) {
        case 3:
            var table = $("#tableModalExportPLGeneralPL").DataTable();
            checkBxId3 = index;
            break;
        case 4:
            var table = $("#tableModalExportPLSelected").DataTable();
            checkBxId4 = index;

            break;
    }
    table.clear();
    table.rows.add(data).draw();
}
function transferGplsToTable(t) {
    var arrSelected = [];
    var arrNotSelected = [];
    switch (t) {
        case 3:
            var table = $("#tableModalExportPLGeneralPL").DataTable();
            var table2 = $("#tableModalExportPLSelected").DataTable();

            break;
        case 4:
            var table = $("#tableModalExportPLGeneralPL").DataTable();
            var table2 = $("#tableModalExportPLSelected").DataTable();

            break;

        default:
            break;
    }
    table2.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arrSelected.push({
            gpl_no: data.thGenPLNo,
            from: data.thFrom,
            to: data.thTo,
            qty: data.thBoxQty,
            weight: data.thBoxWgt,
            id: data.id
        });
    });
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if ($("#checkbox" + t + "_" + rowIdx).prop("checked") == true) {
            arrSelected.push({
                gpl_no: data.thGenPLNo,
                from: data.thFrom,
                to: data.thTo,
                qty: data.thBoxQty,
                weight: data.thBoxWgt,
                id: data.id
            });
        } else {
            arrNotSelected.push({
                gpl_no: data.thGenPLNo,
                from: data.thFrom,
                to: data.thTo,
                qty: data.thBoxQty,
                weight: data.thBoxWgt,
                id: data.id
            });
        }
    });

    console.log(arrNotSelected);
    console.log(arrSelected);

    switch (t) {
        case 3:
            addGplsToTheTables(3, arrNotSelected);
            addGplsToTheTables(4, arrSelected);
            break;
        case 4:
            addGplsToTheTables(3, arrSelected);
            addGplsToTheTables(4, arrNotSelected);
            break;

        default:
            break;
    }

    updateExpPlSummary();
}
function updateExpPlSummary() {
    var arrId = [];
    var table = $("#tableModalExportPLSelected").DataTable();

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arrId.push(data.thGenPLNo);
    });
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/updateExpPlSummary",
        data: { gplArr: arrId },
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var data = [];
                $.each(response.result, function (i, val) {
                    data.push({
                        thBoxNo: val.box_no,
                        thProduct: val.item_name,
                        thBoxQty: val.noofpcs,
                        thNetWgt: val.box_net_weight,
                        thGrossWgt: val.box_gross_weight,
                        thGenPLNo: val.gpl_no,
                        thPackCode: "",
                        id: val.id
                    });
                });
                var table = $("#tableModalExportPLSummary").DataTable();
                table.clear();
                table.rows.add(data).draw();
                calGplotal();
                updateBoxSummary();
            }
        },
        error: function (error) {
            console.log(error);
            console.log("something went wrong");
        }
    });
}
function calGplotal() {
    var totQty = 0;
    var totNetWeight = 0;
    var toGrossWeight = 0;
    var arrBoxId = [];
    var table = $("#tableModalExportPLSummary").DataTable();
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        // console.log()
        arrBoxId.push(data.id);
        totQty = Number(totQty) + Number(data.thBoxQty);
        totNetWeight = Number(totNetWeight) + Number(data.thNetWgt);
        toGrossWeight = Number(toGrossWeight) + Number(data.thGrossWgt);
    });

    $("#ModalExpPL_totBoxes").html(totQty);
    $("#ModalExpPL_totNetWeight").html(totNetWeight.toFixed(3));
    $("#ModalExpPL_totGrossWeight").html(toGrossWeight.toFixed(3));

    // $('#ModalGenPL_txt_totBoxes').val(totQty);
    // $('#ModalGenPL_txt_totNetWeight').val(totNetWeight.toFixed(3));
    // $('#ModalGenPL_txt_totGrossWeight').val(toGrossWeight.toFixed(3));
    loadGplSummaryDetails(arrBoxId);
}
function loadGplSummaryDetails(arrBoxIds) {
    console.log(arrBoxIds)
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadGplSummaryDetails/" + mainPlId,
        data: { arrBoxIds: arrBoxIds },
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var data = response.result.data
                    , dates = response.result.dates[0]
                    , grnNos = []
                    , batchnos = [];

                $.each(data, function (i, val) {
                    grnNos.push(val.lot_grn_no);
                    batchnos.push(val.production_batch_no);
                });
                $("#ModalExpPL_GrnNos").val(grnNos.toString());
                $("#ModalExpPL_batchNo").val(batchnos.toString());
                $("#ModalExpPL_productDate").val(dates.mnfDate);
                $("#ModalExpPL_ExpirDate").val(dates.expDate);
            }
        },
        error: function (error) {
            console.log(error);
            console.log("something went wrong");
        }
    });
}
function is_workSheet_selected() {
    var bool = false;
    if (mainPlId == undefined) {
        toastr.warning("Please select a  Workshet!");
        bool = false;
    } else {
        bool = true;
    }
    return bool;
}
function loadDestinations() {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadDestinations",
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';

                $.each(response.result, function (index, value) {
                    html +=
                        '<option value="' + value.id + '" > ' + value.name + " </option>";
                });
                $("#destination").html(html);
            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function loadAirlines() {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadAirlines",
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';

                $.each(response.result, function (index, value) {
                    html +=
                        '<option value="' + value.id + '" > ' + value.name + " </option>";
                });
                $("#air_line").html(html);
            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function loadCustomerAddress() {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadCustomerAddress/" + mainPlId,
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';

                $.each(response.result, function (index, value) {
                    html += '<option value="' + value.id + '" > ' + value.AddressTitle + " </option>";
                });
                $("#consignee").html(html);
            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function loadCustomerNotify() {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadCustomerNotify/" + mainPlId,
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var html = "";
                html += '<option value="">-Select-</option>';

                $.each(response.result, function (index, value) {
                    html += '<option value="' + value.id + '" > ' + value.AddressTitle + " </option>";
                });
                $("#notify_party").html(html);
            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function loadAddress(type, addressId) {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadAddress/" + addressId,
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var addressline1 = $('#' + type + '_addr1');
                var addressline2 = $('#' + type + '_addr2');
                var city = $('#' + type + '_city');
                var postalcode = $('#' + type + '_postalcode');
                var country = $('#' + type + '_country');

                addressline1.val(response.result.Addressline1)
                addressline2.val(response.result.Addressline2)
                city.val(response.result.CityTown)
                postalcode.val(response.result.PostalCode)
                country.val(response.result.country_name)


            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function updateBoxSummary() {
    var arrSummary = [];
    var table = $("#tableModalExportPLSummary").DataTable();

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        var product = data.thProduct;
        var qty = 1;
        var grossWeight = data.thGrossWgt;

        if (!arrSummary.length == 0) {
            for (let i = 0; i < arrSummary.length; i++) {
                if (arrSummary[i]["thProduct"].trim() === product.trim()) {
                    qty = Number(arrSummary[i]["thBoxQty"]) + 1;
                    grossWeight = Number(grossWeight) + Number(arrSummary[i]["thWeight"]);
                    arrSummary.splice(i, 1); //This removes 1 item from the array starting at indexValueOfArray
                    //because this item is alredy added above line remove the previously added item
                }
            }
        }
        arrSummary.push({
            thProduct: product,
            thBoxQty: qty,
            thWeight: grossWeight
        });
    });
    var table = $("#tableModalExportPLBoxSummary").DataTable();
    table.clear();
    table.rows.add(arrSummary).draw();
    calBoxTotalExpl(arrSummary);
}
function calBoxTotalExpl(summary) {
    var totQty = 0;
    var toGrossWeight = 0;

    $.each(summary, function (i, val) {
        totQty = Number(totQty) + Number(val.thBoxQty);
        toGrossWeight = Number(toGrossWeight) + Number(val.thWeight);
    });

    $("#ModalExpl_totBoxes").html(totQty);
    $("#ModalExpl_totGrossWeight").html(toGrossWeight.toFixed(3));
}
function clearExplTables() {
    $("#ModalExpPL_totBoxes").html("-");
    $("#ModalExpPL_totNetWeight").html("-");
    $("#ModalExpPL_totGrossWeight").html("-");
    $("#ModalExpl_totBoxes").html("-");
    $("#ModalExpl_totGrossWeight").html("-");



    $("#ModalExpPL_GrnNos").val('');
    $("#ModalExpPL_batchNo").val('');
    $("#ModalExpPL_productDate").val('');
    $("#ModalExpPL_ExpirDate").val('');

    $('#frmExportPackingListDetails').trigger("reset");



    var table = $("#tableModalExportPLGeneralPL").DataTable();
    table.clear();
    table.draw();
    var table1 = $("#tableModalExportPLSelected").DataTable();
    table1.clear();
    table1.draw();
    var table2 = $("#tableModalExportPLSummary").DataTable();
    table2.clear();
    table2.draw();
    var table3 = $("#tableModalExportPLBoxSummary").DataTable();
    table3.clear();
    table3.draw();

    checkBxId3 = 0;
    checkBxId4 = 0;

    $("#ModalExpPL_mainPlId").html("-");
    $("#ModalExpPL_PlNo").html("New");
    $("#ModalExPL_btnSave").text("Save");
}
function createExplSaveData(data) {
    var table = $("#tableModalExportPLSelected").DataTable();

    var arr = [];
    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arr.push(data.id);
    });

    var table2 = $("#tableModalExportPLSummary").DataTable();

    var arr2 = [];
    table2.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arr2.push(data.id);
    });
    data.append("mainPlId", mainPlId);
    data.append("GplIds", JSON.stringify(arr));
    data.append("BoxIds", JSON.stringify(arr2));
    data.append("grnNos", $("#ModalExpPL_GrnNos").val());
    data.append("batchNos", $("#ModalExpPL_batchNo").val());
    data.append("productDate", $("#ModalExpPL_productDate").val());
    data.append("ExpireDate", $("#ModalExpPL_ExpirDate").val());
}

function saveExpl(data) {
    if (not_empty("tableModalExportPLSelected")) {
        $.ajax({
            type: "POST",
            url: "/mnu/packingDetailsConfigure/saveExpl",
            data: data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    clearExplTables();
                    loadExpls();
                    loadGpls();
                    $("#ModalExpPL").modal("toggle");
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
            }
        });
    } else {
        toastr.warning("Select boxes first");
    }
}
function loadExpls() {
    $.ajax({
        type: "GET",
        url: "/mnu/packingDetailsConfigure/loadExpls/" + mainPlId,
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                var data = [];
                $.each(response.result, function (i, val) {
                    var edit = `<button class="btn btn-primary mr-1" onclick="editExpl(` + val.id + `)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>`
                        , del = `<button class="btn btn-danger mr-1" onclick="deleteExpl(` + val.id + `)"><i class="fa fa-trash" aria-hidden="true"></i></button>`
                        , reports = `<div class="dropdown">
                                    <button type="button" class="btn btn-warning dropdown-toggle"
                                        data-toggle="dropdown">
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" onclick="getReport(1,` + val.id + `)">Export Packing List(Excel)</a>
                                        <a class="dropdown-item" onclick="getReport(2,` + val.id + `)">Export Packing List(PDF)</a>
                                        <a class="dropdown-item" onclick="getReport(3,` + val.id + `)">Detailed Packing List(Excel)</a>
                                        <a class="dropdown-item" onclick="getReport(4,` + val.id + `)">Detailed Packing List(PDF)</a>
                                    </div>
                                </div>`
                        , status = '';

                    if (Number(val.is_invoiced) == 1) {
                        status = '<span class="badge bg-success text-success-bright">Invoiced</span>';
                    } else {
                        status = '<span class="badge bg-warning text-warning-bright">Pending</span>';
                    }

                    data.push({
                        'thPLNo': val.pl_number,
                        'thPLDate': val.pl_date,
                        'thAWBNo': val.awb_no,
                        'thFlightNo': val.flight_no,
                        'thFlightDate': val.flight_date,
                        'thInvStatus': status,
                        'thInvNo': val.invoice_number,
                        'thActions': edit + del + reports
                    });
                });
                var table = $("#tableExportPackingList").DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        },
        error: function (data) {
            console.log(data);
            console.log("something went wrong");
        }
    });
}
function deleteExpl(id) {
    $.ajax({
        type: "DELETE",
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: "/mnu/packingDetailsConfigure/deleteExpl/" + id,
        success: function (response) {
            console.log(response);
            if (response.success) {
                // toastr.success(response.message);
                loadExpls();
                loadGpls()
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function editExpl(id) {
    if (is_workSheet_selected()) {
        $.ajax({
            type: "GET",
            url: "/mnu/packingDetailsConfigure/editExpl/" + id,
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    addGplsToTheTables(4, response.result.SelectedExternalPackingList);
                    addGplsToTheTables(3, response.result.ExternalPackingList);
                    updateExpPlSummary();
                    loadCustomerNotify();
                    loadCustomerAddress();
                    setExplDetails(response.result.ExplDetails)
                    $("#ModalExPL_btnSave").text("Update");

                    $("#ModalExpPL").modal("toggle");
                }
            },
            error: function (data) {
                console.log(data);
                console.log("something went wrong");
            }
        });
    }
}
function setExplDetails(data) {
    console.log(data);
    $('#ModalExpPL_GrnNos').val(data.grn_nos_list);
    $('#ModalExpPL_batchNo').val(data.batch_nos_list);
    $('#ModalExpPL_productDate').val(data.packing_date);
    $('#ModalExpPL_ExpirDate').val(data.expire_date);
    $('#awb_no').val(data.awb_no);
    $('#flight_no').val(data.flight_no);
    $('#flight_date').val(data.flight_date);
    $('#air_line').val(data.air_line);
    $('#shipment_no').val(data.shipment_no);
    $('#pl_date').val(data.pl_date);
    $('#destination').val(data.destination_id);
    $('#remarks').val(data.Remarks);
    $('#export_date').val(data.export_date);
    $('#consignee').val(data.consignee_id);
    $('#consignee_addr1').val(data.consignee_add1);
    $('#consignee_addr2').val(data.consignee_add2);
    $('#consignee_city').val(data.consignee_city_towm);
    $('#consignee_postalcode').val(data.consignee_postal_code);
    $('#consignee_country').val(data.consignee_country);
    $('#notify_party').val(data.notify_id);
    $('#notify_addr1').val(data.notify_add1);
    $('#notify_addr2').val(data.notify_add2);
    $('#notify_city').val(data.notify_city_towm);
    $('#notify_postalcode').val(data.notify_postal_code);
    $('#notify_country').val(data.notify_country);
    $('#eu_approval_no').val(data.eu_approval_no);
    $('#production_manager').val(data.production_manager);
    $('#packing_qc').val(data.packing_qc);
    $('#authorization').val(data.authorisedby_name);
    $('#Explid').val(data.id);
    $("#ModalExpPL_PlNo").html(data.pl_number);

}
function UpdateExpl(data) {
    if (not_empty("tableModalExportPLSelected")) {
        $.ajax({
            type: "POST",
            url: "/mnu/packingDetailsConfigure/UpdateExpl",
            data: data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    clearExplTables();
                    loadExpls();
                    $("#ModalExpPL").modal("toggle");
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
            }
        });
    } else {
        toastr.warning("Select boxes first");
    }
}

//########################################################
//###################### Reporting #######################
//########################################################
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

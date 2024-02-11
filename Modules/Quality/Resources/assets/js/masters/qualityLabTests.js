// const { each } = require("lodash");


console.log('qualityLab.js loading');
var parent_url = '/quality/qualityLab_list'
    , startDate = 0
    , endDate = 0
    , labTestHdId
    , compositionId
    , startDate = 0
    , endDate = 0;;

$(document).ready(function () {

    // Lab Test Details Table
    var tblLabTestDetails = $('#tblLabTestDetails').DataTable({
        paging: true,
        ordering: true,
        info: true,
        scrollX: true,
        'columnDefs': [
            {
                "orderable": true,
                "targets": [0, 3]
            },
            {
                "className": "align-text-top text-center",
                "targets": [0, 1, 2, 3, 4, 5]
            }
            ,
            {
                "className": "text-center",
                "targets": [4]
            }
        ],
        'order': [0, 'desc'],
        'pageLength': 20,
        'dom': 'rtip',

        "columns": [
            { "data": "thTestNo", 'width': "20%" },
            { "data": "thTestDate", 'width': "15%" },
            { "data": "thTestStatus", 'width': "15%" },
            { "data": "thTypes", 'width': "15%" },
            { "data": "thRelatedGRN", 'width': "15%" },
            { "data": "thActions", 'width': "20%" }
        ],
    });
    $('#searchTblLabTestDetails').keyup(function () {
        tblLabTestDetails.search($(this).val()).draw();
    })

    // Sample Details Modal - GRN Fish Table
    var tableGrnNotSelected = $('#tableGrnNotSelected').DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: false,
        searching: false,
        paging: false,
        info: false,
        select: 'multi',
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
            },
            {
                targets: [4],
                visible: false
            },
        ],
        columns: [
            { "data": "thGRNNo", 'width': "40%" },
            { "data": "thFishNo", 'width': "20%" },
            { "data": "thType", 'width': "20%" },
            { "data": "thNetWgt", 'width': "20%" },
            { "data": "id" }

        ],
    });

    // Sample Details Modal - Selected Fish Table
    var tableGrnSelected = $('#tableGrnSelected').DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: false,
        searching: false,
        paging: false,
        info: false,
        select: 'multi',
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
            },
            {
                targets: [4],
                visible: false
            },
        ],
        columns: [
            { "data": "thGRNNo", 'width': "40%" },
            { "data": "thFishNo", 'width': "20%" },
            { "data": "thType", 'width': "20%" },
            { "data": "thNetWgt", 'width': "20%" },
            { "data": "id" }

        ],
    });


    // Lab Test Details - Test Sample Table
    var tblLabTestDetailsSamples = $('#tblLabTestDetailsSamples').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: false,
        searching: false,
        paging: false,
        info: false,
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
        columns: [
            { "data": "thSampleNo", 'width': "25%" },
            { "data": "thFishNo", 'width': "50%" },
            { "data": "thActions", 'width': "25%" }
        ],
    });

    // Lab Test Details - Test Type Table
    var tblLabTestDetailsTestTypes = $('#tblLabTestDetailsTestTypes').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: false,
        searching: false,
        paging: false,
        info: false,
        columnDefs: [
            {
                targets: [0, 1, 2],
                className: "text-center"
            }
        ],
        columns: [
            { "data": "thTestType", 'width': "25%" },
            { "data": "thStatus", 'width': "50%" },
            { "data": "thActions", 'width': "25%" }
        ],
    });
    var tableLabTestResults = $('#tableLabTestResults').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: false,
        searching: false,
        paging: false,
        info: false,
        columnDefs: [
            {
                targets: [0, 1, 2],
                className: "text-center"
            },
            {
                targets: [5],
                visible: false
            },
        ],
        columns: [
            { "data": "thSampleNo", 'width': "25%" },
            { "data": "thResult", 'width': "50%", className: 'customColumn' },
            { "data": "thvalueStatus", 'width': "25%" },
            { "data": "thUpdateStatus", 'width': "25%" },
            { "data": "thAction", 'width': "25%" },
            { "data": "id", name: 'id' },
        ],
    });

    //custom textbox focusOut Event DataTable
    tableLabTestResults.on('focusout', '.customColumn .customTextbox', function () {
        var row = $(this).closest('tr');
        var data = tableLabTestResults.row(row).data();
        var value = $(this).val();
        UpdateResulValue(data.id, value)
        console.log('ID:', value);
    });

    tableLabTestResults.on('click', '.btnUpdateResult', function () {
        var row = $(this).closest('tr');
        var data = tableLabTestResults.row(row).data();
        var value = row.find('.customTextbox').val();
        updateResultDialog(data.id, value);
        // console.log('Row ID:', data.id, 'Textbox Value:', value);
    });

    //Date Range Picker - Lab Tests
    $(function () {
        $('#dateRangeLabTests').daterangepicker({
            opens: 'left',
            endDate: moment().subtract(5, 'day'),
        }, function (start, end, label) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
            loadQualityLabTests();
        });
    });

    //Date Picker - Lab Test Details Date

    $(function () {
        $('#labTestDetailsDate').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });

    //Date Picker - Lab Test Date
    $(function () {
        $('#labTestDate').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });

    //Date Time - Lab Test Details Date Time
    $(function () {
        $('#labTestDateTime').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        });
    });

    //Date Time - Lab Test Type Date Time
    $(function () {
        $('#labTestTypeDateTime').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        });
    });

    //Date Time - Lab Test Results Date Time
    $(function () {
        $('#labTestResultsDateTime').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        });
    });


    // Form Repeater
    $('.repeater').repeater();

    // Tooltips - All
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // New Test Button
    $('#btnNewTest').click(function () {
        $('#modalNewTest').modal('toggle')
    });
    // New Test Save Button
    $('#btnModalSaveNewTest').click(function () {
        newTestSave();
    });
    // Lab Test Delete Button
    $('#btnLabTestDelete').click(function () {
        deleteTest();
    });
    // Update Details Button
    $('#btnUpdateDetails').click(function () {
        updateDetails();
    });
    // New Test Sample Button
    $('#btnNewTestSample').click(function () {
        loadTestSampleRequiredData();
    });
    // Edit Test Sample Button
    $('#btnEditTestSample').click(function () {
        newEditTestSample();
    });
    // Add Test Type Button
    $('#btnAddTestType').click(function () {
        loadRequiredDataAddTestTypeModel();
        // addTestType();
    });
    $('#buttonToLeft1').click(function () {
        transferGRNsToTable(2);
    });
    $('#buttonToRight1').click(function () {
        transferGRNsToTable(1);
    });
    $('#btnSelectall1').click(function () {
        selectAll(1);
    });
    $('#btnSelectall2').click(function () {
        selectAll(2);
    });
    $('#sampBtnSave').click(function () {
        console.log($('#sampBtnSave').text())
        if ($('#sampBtnSave').text().trim() == 'Save') {
            saveSample();
        } else {
            updateSample();
        }
    });
    $('#btnModalSaveAddTestType').click(function () {
        var form = $('#addTestTypeForm ').get(0);
        var data = new FormData(form);

        if ($('#btnModalSaveAddTestType').text().trim() == 'Save') {
            data.append("labTestHdId", labTestHdId);
            addTestType(data);
        }
        else {
            update(data);
        }

    });
    $('#modalEditAndResults_btnSave').click(function () {
        UpdatTestType();
    });


    $('#sampGRNNo').change(function () {
        loadGrns();
    });
    $('#sampSupplier').change(function () {
        loadGrns();
    });
    $('#sampFishType').change(function () {
        loadGrns();
    });
    $('#testTypesSelect').change(function () {
        loadQualityLabTests();
    });
    $('#testStatusSelect').change(function () {
        loadQualityLabTests();
    });
    $('#grnNoSelect').change(function () {
        loadQualityLabTests();
    });

    // Select2 for All Select Fields
    $('.select2').select2({
        placeholder: 'Select'
    });

    $('#scan').keypress(function (event) {
        if (event.which == 13) { // Enter key
            scanToAdd(this.value)
        }
    });

    loadQualityLabTests();
    loadDropdownData();
    // loadGRNs();

});
function SetFilters() {
    var testType = $('#testTypesSelect').val()
        , status = $('#testStatusSelect').val()
        , grnNo = $('#grnNoSelect').val()
        , arr = {
            'startDate': startDate,
            'endDate': endDate,
        };

    if (testType != 'null') {
        $.extend(arr, { 'testType': testType, })
    }
    if (status != 'null') {
        $.extend(arr, { 'status': status })
    }
    if (grnNo != 'null') {
        $.extend(arr, { 'grnNo': grnNo })
    }

    return arr;
}

function loadQualityLabTests() {
    $.ajax({
        type: 'GET',
        url: '/quality/qualitylabtests/loadqualitylabtests',
        data: SetFilters(),
        success: function ({ result, success }) {
            console.log(result)
            if (success) {
                const data = result.map(({ id, labTestNo, testDate, status, testTypes, lot_grnno }) => ({
                    thTestNo: labTestNo,
                    thTestDate: testDate,
                    thTestStatus: getStatus(status),
                    thTypes: setTestTypeBadges(testTypes),
                    thRelatedGRN: setGrnNoBadges(lot_grnno),
                    thActions: `
                        <button class="btn btn-success btn-sm mr-1" data-id="${id}" onclick="loadLabTest(${id})" data-action="view">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-danger btn-sm mr-1" data-id="${id}" onclick="deleteQualityLabTest(${id})" data-action="deleteQualityLabTest">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    `,
                }));
                $('#tblLabTestDetails').DataTable().clear().rows.add(data).draw();
            }
        },
        error: function (err) {
            console.log('something went wrong');
            console.log(err)
        }
    });
}
function getStatus(status) {
    switch (status) {
        case 0: return `<span class="badge badge-warning">Pending</span>`;
        case 1: return `<span class="badge badge-primary">In-Progress</span>`;
        case 2: return `<span class="badge badge-success">Closed</span>`;
        case 3: return `<span class="badge badge-danger">Cancelled</span>`;
        default: return '';
    }
}
function setTestTypeBadges(testTypes) {
    var badges = '';
    if (testTypes != null) {
        var testTypes = testTypes.split(',');
        $.each(testTypes, function (index, type) {
            badges += '<a class="badge badge-primary w-100 text-white">' + type + '</a><br>';
        });
    }
    return badges;
}
function setGrnNoBadges(lot_grnno) {
    var badges = '';
    if (lot_grnno != null) {
        var lot_grnno = lot_grnno.split(',');
        $.each(lot_grnno, function (index, grnno) {
            badges += '<a class="badge badge-primary w-100 text-white"  href="/buying/grnHistory_configure?' + grnno + '" target="_blank" rel="noopener noreferrer">' + grnno + '</a><br>';
        });
    }
    return badges;
}
function deleteQualityLabTest(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: '/quality/qualitylabtests/delete/' + id,
                    success: function (response) {
                        console.log(response);

                        if (response.success) {
                            toastr.success(response.message);
                            loadQualityLabTests();
                            swal({
                                title: "Deleted!",
                                text: "Lab Test Deleted",
                                icon: "success",
                            });
                        }

                        else {
                            swal("Cannot Delete Lab Test Type", "Lab Test Type already in use", "error");
                        }

                    }, error: function (data) {
                        console.log(data);
                    }
                });

            } else {
                swal({
                    title: "Cancelled!",
                    text: "Lab Test Not Deleted",
                    icon: "error",
                });
            }
        });


};
function loadDropdownData() {
    $.ajax({
        type: 'GET',
        url: '/quality/qualitylabtests/loadDropdownData',
        success: function (response) {
            console.log(response)
            if (response.success) {
                var LabTestType = response.result.LabTestType
                    , grn = response.result.grn
                    , grns = ""
                    , LabTestTypes = "";

                LabTestTypes += '<option value="null" > -All- </option>';

                $.each(LabTestType, function (index, value) {

                    LabTestTypes += '<option value="' + value.id + '" > ' + value.testTypeName + ' </option>';
                });
                grns += '<option value="null" >-all-</option>';

                $.each(grn, function (index, value) {

                    grns += '<option value="' + value.grnno + '" > ' + value.grnno + ' | ' + value.grndate + ' </option>';
                });
                $('#grnNoSelect').html(grns);
                $('#testTypesSelect').html(LabTestTypes);
                $('#newTestTestType').html(LabTestTypes);

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function getSaveData() {
    var newtestNo = $('#newtestNo').val()
        , labTestDate = $('#labTestDate').val()
        , newtestDescription = $('#newtestDescription').val()
        , newTestTestType = $('#newTestTestType').select2('data');

    if (newTestTestType.length != 0) {
        newTestTestType = createMultipleSelectArray(newTestTestType)
    }
    return {
        'newTestTestType': newTestTestType,
        'newtestNo': newtestNo,
        'labTestDate': labTestDate,
        'newtestDescription': newtestDescription,
    };
}
function newTestSave() {
    swal({
        title: "Are you sure?",
        text: "This will create a New Test",
        icon: "warning",
        dangerMode: true,
        buttons: {
            cancel: "Cancel",
            create: {
                text: "Create",
                value: "create",
            }
        },
    })
        .then((value) => {
            switch (value) {

                case "create":
                    $.ajax({
                        type: "POST",
                        url: "/quality/qualitylabtests/newTestSave",
                        data: getSaveData(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            console.log(response);
                            if (response.success) {
                                toastr.success(response.message);
                                swal("New Test Created!", "New Lab Test Created with Test No :" + response.result, "success");
                                $('#modalNewTest').modal('toggle')
                                loadQualityLabTests();
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
                    break;
                default:
                    swal("Cancelled!", "New Test creation cancelled!", "error");
            }
        });
};
function loadTestSampleRequiredData() {
    $.ajax({
        type: 'GET',
        url: '/quality/qualitylabtests/loadTestSampleRequiredData',
        success: function (response) {
            console.log(response)
            if (response.success) {
                var Fishspecies = response.result.Fishspecies
                    , Supplier = response.result.Supplier
                    , GRNNo = response.result.GRNNo
                    , fish = ""
                    , sup = ""
                    , grnNo = "";

                $.each(Fishspecies, function (index, value) {
                    fish += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                $.each(Supplier, function (index, value) {
                    sup += '<option value="' + value.id + '" > ' + value.supplier_name + '  </option>';
                });
                $.each(GRNNo, function (index, value) {
                    grnNo += '<option value="' + value.grnno + '" > ' + value.grndate + ' | ' + value.grnno + '  </option>';
                });

                $('#sampFishType').html(fish);
                $('#sampSupplier').html(sup);
                $('#sampGRNNo').html(grnNo);

                $('#modalNewEditTestSample').modal('toggle')

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function getGrnFilters() {
    var sampFishType = $('#sampFishType').val()
        , sampSupplier = $('#sampSupplier').val()
        , sampGRNNo = $('#sampGRNNo').val();

    return {
        'sampFishType': sampFishType,
        'sampSupplier': sampSupplier,
        'sampGRNNo': sampGRNNo,
    };
}
function loadGrns() {
    $.ajax({
        type: 'GET',
        url: '/quality/qualitylabtests/loadGrns',
        data: getGrnFilters(),
        success: function ({ result, success }) {
            console.log(result)
            if (success) {
                addGRNsTOtheTable(1, result)
            }
        },
        error: function () {
            console.log('something went wrong');
        }
    });
}
function addGRNsTOtheTable(tab, result) {
    const data = result.map(({ id, lot_grnno, lot_serial_no, net_weight, FishCode }) => ({
        'thGRNNo': lot_grnno,
        'thFishNo': lot_serial_no,
        'thType': FishCode,
        'thNetWgt': net_weight,
        'id': id,

    }));
    switch (tab) {
        case 1:
            var table = $("#tableGrnNotSelected").DataTable();
            break;
        case 2:
            var table = $("#tableGrnSelected").DataTable();
            break;
    }
    table.clear();
    table.rows.add(data).draw();
}
function transferGRNsToTable(t) {
    var arrSelected = []
        , arrNotSelected = [];
    switch (t) {
        case 1:
            var table = $("#tableGrnNotSelected").DataTable();
            var table2 = $("#tableGrnSelected").DataTable();

            break;
        case 2:
            var table = $("#tableGrnSelected").DataTable();
            var table2 = $("#tableGrnNotSelected").DataTable();

            break;

        default:
            break;
    }
    table2.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arrSelected.push({
            lot_grnno: data.thGRNNo,
            lot_serial_no: data.thFishNo,
            FishCode: data.thType,
            net_weight: data.thNetWgt,
            id: data.id,
        });
    });
    var selectedRows = table.rows({ selected: true }).indexes();

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data()
            , added = false;
        if (selectedRows.indexOf(rowIdx) !== -1) {
            $.each(arrSelected, function (i, val) {
                if (data.id == arrSelected[i]['id']) {
                    added = true
                }

            });
            if (added) {
                toastr.warning('Item(s) alredy added')
            } else {
                arrSelected.push({
                    lot_grnno: data.thGRNNo,
                    lot_serial_no: data.thFishNo,
                    FishCode: data.thType,
                    net_weight: data.thNetWgt,
                    id: data.id,
                });
            }
        } else {
            arrNotSelected.push({
                lot_grnno: data.thGRNNo,
                lot_serial_no: data.thFishNo,
                FishCode: data.thType,
                net_weight: data.thNetWgt,
                id: data.id,
            });
        }
    });
    console.log(arrNotSelected);
    console.log(arrSelected);

    switch (t) {
        case 1:
            addGRNsTOtheTable(1, arrNotSelected);
            addGRNsTOtheTable(2, arrSelected);
            break;
        case 2:
            addGRNsTOtheTable(1, arrSelected);
            addGRNsTOtheTable(2, arrNotSelected);
            break;
    }
    $('#btnSelectall1').text('Select All')
    $('#btnSelectall2').text('Select All')
}
function selectAll(t) {
    var table;
    switch (t) {
        case 1:
            table = $('#tableGrnNotSelected').DataTable();
            break;
        case 2:
            table = $('#tableGrnSelected').DataTable();
            break;
    }
    if ($('#btnSelectall' + t).text() == 'Select All') {
        table.rows().select();
        $('#btnSelectall' + t).text('De select All')
    } else {
        table.rows().deselect();
        $('#btnSelectall' + t).text('Select All')
    }
}
function getSampleSaveData() {
    var data = new FormData()
        , sampType = $('#sampType').val()
        , sampFishType = $('#sampFishType').val()
        , sampleRemarks = $('#sampleRemarks').val()
        , labTestHdId = $('#hiddenId').val()
        , table = $("#tableGrnSelected").DataTable()
        , arr = [];

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        arr.push(data.id);
    });

    data.append("sampType", sampType);
    data.append("sampFishType", sampFishType);
    data.append("sampleRemarks", sampleRemarks);
    data.append("labTestHdId", labTestHdId);
    data.append("compositionId", compositionId);
    data.append("GRNDtlids", JSON.stringify(arr));

    return data;
}
function saveSample() {
    $.ajax({
        type: "POST",
        url: "/quality/qualitylabtests/saveSample",
        data: getSampleSaveData(),
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
                loadQualityLabTests();
                loadTestSamplesTable()
                resetSampleModel();
                $('#modalNewEditTestSample').modal('toggle')
            }
            else {
                toastr.error(response.message);
            }
        },
        error: function (error) {
            console.log(error);

            toastr.error('Something went wrong');
        },
    });
}
function loadLabTest(id) {
    $.ajax({
        type: "GET",
        url: "/quality/qualitylabtests/loadQualityLabTest/" + id,
        async: false,
        success: function (response) {
            if (response.success) {
                console.log(response.result);
                var data = response.result;

                $('#hiddenId').val(data.id);
                $('#testNo').val(data.labTestNo);
                $('#labTestDetailsDate').val(data.testDate);
                $('#testDetailsStatus').val(data.status.toString());
                $('#testDescription').val(data.testDescription);
                labTestHdId = id;
                loadTestSamplesTable();
                loadTestType();

                $('#labtestdetailssection').removeAttr("hidden");
                window.scrollTo(0, 1500);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}
function updateDetails(data) {
    swal({
        title: "Are you sure?",
        text: "This will update Test Date & Description",
        icon: "warning",
        dangerMode: true,
        buttons: {
            cancel: "Cancel",
            update: {
                text: "Update",
                value: "update",
                icon: "success"
            }
        },
    })
        .then((value) => {
            switch (value) {

                case "update":
                    var form = $('#frmLabTestDetails').get(0)
                    , data = new FormData(form);

                    $.ajax({
                        type: "POST",
                        url: "/quality/qualitylabtests/update",
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        cache: false,
                        timeout: 800000,
                        beforeSend: function () {

                        },
                        success: function (response) {
                            console.log(response);
                            if (response.success) {
                                toastr.success(response.message);
                                swal("Updated!", "Test Date & Description Updated", "success");
                                loadQualityLabTests()
                            }
                            else {
                                swal("Error!", "Test Date & Description Not Updated. Error Message: " + response.message, "error");
                            }
                        },
                        error: function (error, data, form) {
                            console.log(error);
                            console.log(data);
                            console.log(form);

                            if (error.status == 422) { // when status code is 422, it's a validation issue
                                console.log(error.responseJSON);
                                // you can loop through the errors object and show it to the user
                                console.warn(error.responseJSON.errors);
                                // display errors on each form field
                                $.each(error.responseJSON.errors, function (i, error) {
                                    var el = $(document).find('[name="' + i + '"]');
                                    //  el[0].style.border = '1px solid red';

                                    errorElement(el);
                                    swal("Error!", "Test Date & Description Not Updated. Error Message: " + error[0], "error");
                                });
                            }
                            else {
                                toastr.error('Something went wrong');
                                swal("Error!", "Test Date & Description Not Updated", "error");
                            }
                        },
                        complete: function () {

                        }
                    });

                    break;

                default:
                    swal("Cancelled!", "Test Date & Description update cancelled!", "error");
            }
        });
};
function loadTestSamplesTable() {
    if (labTestHdId) {
        $.ajax({
            type: "GET",
            url: "/quality/qualitylabtests/loadTestSamplesTable/" + labTestHdId,
            async: false,
            success: function (response) {
                if (response.success) {
                    console.log(response);
                    const data = response.result.map(({ id, sam_no, GrnToFish }) => ({
                        thSampleNo: `<button type="button" class="btn btn-warning btn-sm mb-1">${sam_no}</button>`,
                        thFishNo: setGrnNOandFishNoBatches(GrnToFish),
                        thActions: `<button class="btn btn-primary btn-sm mr-1" onclick="editSample(${id})"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    <button class="btn btn-danger btn-sm mr-1" onclick="deleteSample(${id})"><i class="fa fa-trash"aria-hidden="true"></i></button>`,
                    }));
                    $('#tblLabTestDetailsSamples').DataTable().clear().rows.add(data).draw();

                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
}
function setGrnNOandFishNoBatches(GrnToFish) {
    var badges = '';
    if (GrnToFish != null) {
        var GrnToFish = GrnToFish.split(',');
        $.each(GrnToFish, function (index, val) {
            var val = val.split('.');
            badges += ` <li>
                            <a href="/buying/grnHistory_configure?8036" type="button" class="btn btn-primary btn-sm mb-1"> ${val[0]}</a>
                            ->
                            <a type="button" class="btn btn-secondary btn-sm mb-1"> ${val[1]}</a>
                        </li>`;
        });
    }
    return `<ul>` + badges + `</ul>`;
}
function deleteSample(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: '/quality/qualitylabtests/deleteSample/' + id,
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            // toastr.success(response.message);
                            loadTestSamplesTable();
                            loadQualityLabTests();
                            swal({
                                title: "Deleted!",
                                text: "Sample Deleted",
                                icon: "success",
                            });
                        }

                        else {
                            swal("Cannot Delete Sample", "Sample already in use", "error");
                        }
                    }, error: function (data) {
                        console.log(data);
                    }
                });
            } else {
                swal({
                    title: "Cancelled!",
                    text: "Lab Test Not Deleted",
                    icon: "error",
                });
            }
        });

}
function editSample(id) {
    $.ajax({
        type: "GET",
        url: "/quality/qualitylabtests/editSample/" + id,
        async: false,
        success: function (response) {
            if (response.success) {
                console.log(response);
                data = response.result.LabTestDtlComposition;
                loadTestSampleRequiredData()
                $('#sampType').val(data.samType)
                $('#sampFishType').val(data.fish_type_id)
                $('#sampleRemarks').val(data.remarks)
                $('#hiddenId').val(data.testHdId)
                compositionId = data.id
                $('#sampleNo').val(data.sam_no)
                $('#sampBtnSave').text('Update')
                $('#modalNewEditTestSample').modal('toggle')
                addGRNsTOtheTable(2, response.result.Grn)
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}
function updateSample() {
    $.ajax({
        type: "POST",
        url: "/quality/qualitylabtests/updateSample",
        data: getSampleSaveData(),
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
                loadQualityLabTests();
                loadTestSamplesTable();
                resetSampleModel();

                $('#modalNewEditTestSample').modal('toggle')
            }
            else {
                toastr.error(response.message);
            }
        },
        error: function (error) {
            console.log(error);
            toastr.error('Something went wrong');
        },
    });
}
function resetSampleModel() {
    compositionId = undefined;
    // $('#sampType').val('')
    $('#sampFishType').val('')
    $('#sampleRemarks').val('')
    // $('#hiddenId').val('')
    // $('#sampleNo').val('')
    $('#sampBtnSave').text('Save')
    $("#tableGrnNotSelected").DataTable().clear().draw();
    $("#tableGrnSelected").DataTable().clear().draw();
}
function loadTestType() {
    if (labTestHdId) {
        $.ajax({
            type: "GET",
            url: "/quality/qualitylabtests/loadTestType/" + labTestHdId,
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    const data = response.result.map(({ testTypeName, status, id }) => ({
                        thTestType: `<button type="button" class="btn btn-primary btn-sm mb-1">${testTypeName}</button>`,
                        thStatus: SetTestTypeStatusBatch(status),
                        thActions: ` <button class="btn btn-primary btn-sm mr-1"  onclick="editAndTestResults(${id})">Edit & Results</button>
                                    <button class="btn btn-danger btn-sm mr-1"  onclick="deleteTestType(${id})"><i class="fa fa-trash" aria-hidden="true"></i></button>`,
                    }));
                    $('#tblLabTestDetailsTestTypes').DataTable().clear().rows.add(data).draw();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
}
function SetTestTypeStatusBatch(status) {
    switch (status) {
        case 0: return `<span class="badge badge-warning">Test Pending</span>`;
        case 1: return `<span class="badge badge-info">Test In-Progress</span>`;
        case 2: return `<span class="badge badge-secondary">Results Pending</span>`;
        case 3: return `<span class="badge badge-success">Completed</span>`;
        case 4: return `<span class="badge badge-danger">Cancelled</span>`;
        default: return '';
    }
}
function deleteTestType(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/quality/qualitylabtests/deleteTestType/' + id,
        success: function (response) {
            console.log(response);
            if (response.success) {
                loadTestType();
                loadQualityLabTests();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
}
function loadRequiredDataAddTestTypeModel() {
    $.ajax({
        type: 'GET',
        url: '/quality/qualitylabtests/loadRequiredDataAddTestTypeModel',
        success: function (response) {
            console.log(response)
            if (response.success) {
                var LabTestType = response.result.LabTestType
                    , employee = response.result.employee
                    , LabTestTypes = ""
                    , employees = "";

                $.each(LabTestType, function (index, value) {

                    LabTestTypes += '<option value="' + value.id + '" > ' + value.testTypeName + ' </option>';
                });
                $.each(employee, function (index, value) {

                    employees += '<option value="' + value.id + '" > ' + value.employee_name + ' </option>';
                });
                $('#selectedTestTypes').html(LabTestTypes);
                $('#testTypeTestBy').html(employees);
                $('#testTypeVerifydBy').html(employees);

                $('#modalAddTestType').modal('toggle')
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });

}
function addTestType(data) {
    $.ajax({
        type: "POST",
        url: "/quality/qualitylabtests/addTestType",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        success: function (response) {
            console.log(response);
            if (response.success) {
                loadTestType();
                loadQualityLabTests();
                $('#addTestTypeForm ').trigger("reset");
                $('#modalAddTestType').modal('toggle');
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
    });
}
function editAndTestResults(LbtestDtLTypeId) {
    console.log(LbtestDtLTypeId, labTestHdId)
    $.ajax({
        type: "GET",
        url: "/quality/qualitylabtests/editAndTestResults/" + LbtestDtLTypeId + '/' + labTestHdId,

        success: function (response) {
            console.log(response);
            if (response.success) {
                var LabTestDtlType = response.result.LabTestDtlType
                    , LabTestDtlComposition = response.result.LabTestDtlComposition
                    , employee = response.result.employee;


                const data = LabTestDtlComposition.map(({ id, sam_no, testResultValue, isResultsSet, result_status }) => ({
                    thSampleNo: `<button type="button" class="btn btn-warning btn-sm mb-1">${sam_no}</button>`,
                    thResult: ` <div class="input-group">
                                    <input type="number" class="form-control customTextbox"
                                        placeholder="Results Value"  value="${testResultValue}" >
                                    <div class="input-group-append">
                                        <span class="input-group-text" >PPM</span>
                                    </div>
                                </div>`,
                    thvalueStatus: setValueStatusBatch(result_status),
                    thUpdateStatus: setUpdateStatusBatch(isResultsSet),
                    thAction: `<button type="button" class="btn btn-primary btn-sm btnUpdateResult" >Update Result</button>`,
                    id: id
                }));
                $('#tableLabTestResults').DataTable().clear().rows.add(data).draw();

                SetEmployees(employee)
                $('#resultsTestTypes').val(LabTestDtlType.testTypeName)
                $('#resultsStatus').val(LabTestDtlType.status)
                $('#labTestResultsDateTime').val(LabTestDtlType.testDateTime)
                $('#resultsEquipment').val(LabTestDtlType.testEquipment)
                $('#resultsTestBy').val(LabTestDtlType.testBy)
                $('#resultsVerifydBy').val(LabTestDtlType.verifiedBy)
                $('#hiddenTestTypeDtlId').val(LabTestDtlType.id)
                // testDtlTypeId = LbtestDtLTypeId;

                $('#modalEditAndResults').modal('toggle')
            }
            else {
                toastr.error(response.message);
            }
        },
        error: function (error) {
            console.log(error);
            toastr.error('Something went wrong');
        },
    });
};
function setValueStatusBatch(status) {
    switch (status) {
        case 0: return `<span class="badge badge-success">Safe Level</span>`;
        case 1: return `<span class="badge badge-warning">Alert Level</span>`;
        case 2: return `<span class="badge badge-danger">Lock Level</span>`;

        default: return '';
    }
}
function setUpdateStatusBatch(status) {
    switch (status) {
        case 0: return `<span class="badge badge-danger">Not Updated</span>`;
        case 1: return `<span class="badge badge-success">Updated</span>`;
        default: return '';
    }
}
function SetEmployees(data) {
    var employee = [];
    $.each(data, function (index, value) {
        employee += '<option value="' + value.id + '" > ' + value.employee_name + ' </option>';
    });
    $('#resultsTestBy').html(employee);
    $('#resultsVerifydBy').html(employee);
}
function getTestTypeData() {
    var data = new FormData()
        , status = $('#resultsStatus').val()
        , testDateTime = $('#labTestResultsDateTime').val()
        , testEquipment = $('#resultsEquipment').val()
        , testBy = $('#resultsTestBy').val()
        , verifiedBy = $('#resultsVerifydBy').val()
        , id = $('#hiddenTestTypeDtlId').val();

    data.append("status", status);
    data.append("testDateTime", testDateTime);
    data.append("testEquipment", testEquipment);
    data.append("testBy", testBy);
    data.append("verifiedBy", verifiedBy);
    data.append("id", id);

    return data;
}
function UpdatTestType() {
    $.ajax({
        type: "POST",
        url: "/quality/qualitylabtests/UpdatTestType",
        data: getTestTypeData(),
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
                toastr.success('Test type updated');
                loadTestType();
                $('#modalEditAndResults').modal('toggle')
            }
        },
        error: function (error) {
            console.log(error);

            toastr.error('Something went wrong');
        },
    });
}
function UpdateResulValue(compHdId, val) {
    $.ajax({
        type: "POST",
        url: "/quality/qualitylabtests/UpdateResulValue",
        data: { 'compHdId': compHdId, 'testDtlTypeId': $('#hiddenTestTypeDtlId').val(), 'val': val },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success('Test type updated');
            }
        },
        error: function (error) {
            console.log(error);

            toastr.error('Something went wrong');
        },
    });
}
function updateResultDialog(LabTestDtlCompositionId, val) {
    var withStatus = false;
    swal({
        title: "Are you sure to Set Values?",
        text: "This will set test results values and status (Lock/Unlock) to related Fish/Lot and Productions. Please select status setting accordingly.",
        icon: "warning",
        dangerMode: true,
        buttons: {
            cancel: "Cancel",
            setwithstatus: {
                text: "Set with Status",
                value: "setwithstatus",
                className: "btn-success",
            },
            setwithoutstatus: {
                text: "Set without Status",
                value: "setwithoutstatus",
                className: "btn-warning",
            },
        },
    })
        .then((value) => {
            switch (value) {

                case "setwithoutstatus":
                    withStatus = false;
                    UpdateResult(LabTestDtlCompositionId, withStatus, val)
                    break;

                case "setwithstatus":
                    withStatus = true
                    UpdateResult(LabTestDtlCompositionId, withStatus, val)

                    break;

                default:
                    swal("Cancelled!", "Result setting cancelled!", "error");
            }
        });
};
function UpdateResult(LabTestDtlCompositionId, withStatus, value) {
    $.ajax({
        type: "POST",
        url: "/quality/qualitylabtests/UpdateResult",
        data: {
            'LabTestDtlCompositionId': LabTestDtlCompositionId,
            'withStatus': withStatus,
            'labTestHdId': labTestHdId,
            'value': value,
            'testDtlTypeId': $('#hiddenTestTypeDtlId').val(),
            'testDateTime': $('#labTestResultsDateTime').val()

        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success('Result updated');

                if (withStatus) {
                    swal("Result Values Set!", "Results Values set WITH Lock/Unlock Status accordingly!", "success");
                } else {
                    swal("Result Values Set!", "Results Values set WITHOUT Status", "success");
                }
            }
        },
        error: function (error) {
            console.log(error);

            toastr.error('Something went wrong');
        },
    });
}
function scanToAdd(barcode) {
    if (barcode != '') {
        $.ajax({
            type: 'GET',
            url: '/quality/qualitylabtests/scanToAdd/' + barcode,
            success: function ({ result, success }) {
                console.log(result)
                if (success) {
                    if (result.length == 0) {
                        toastr.warning('Barcode not found')
                    } else {
                        addGRNsTOtheTable(2, result)
                    }
                }
            },
            error: function () {
                console.log('something went wrong');
            }
        });
    } else {
        toastr.warning('Scan the Barcode again')
    }

}

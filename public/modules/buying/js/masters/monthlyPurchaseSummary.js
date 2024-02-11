console.log('monthlyPurchaseSummary.js loadimng');
//apex chart Start
var options = {
    chart: {
        height: 350,
        type: 'bar',
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    series: [],

    xaxis: {
        type: 'datetime',
        categories: []
    },
    tooltip: {
        x: {
            format: 'yyyy-MMM'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#chart_fish_type_wise"),
    options
);
chart.render();
//apex chart end


// var groupColumn = 1;

$(document).ready(function () {
    $('#cbxSupplier').prop("disabled", true);

    var tableFishDetails = $('#tableFishDetails').DataTable({
        scrollY: 1000,
        scrollX: true,
        paging: false,
        info: false,
        scrollCollapse: true,
        colReorder: true,
        select: {
            style: 'single'
        },
        ordering: false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf',
            {
                extend: "print",
                customize: function (win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape; }',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    }
                    else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);
                }
            },
        ],
        "createdRow": function (row, data, dataIndex) {
            if (data['colour'] == 1) {
                $(row).addClass('bg-info-bright');
            }
        },

        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '2px')
                }
            },
            {
                "targets": [18],
                "visible": false,
            },
            {
                "targets": [0, 1, 2, 3, 4, 5],
                "className": "text-center",

            },
            {
                "targets": [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                "className": "text-right",

            }
        ],
        "columns": [
            { "data": "thYear" },
            { "data": "thSupplier" },
            { "data": "thFishType" },
            { "data": "thPresentation" },
            { "data": "thPayGrade" },
            { "data": "thSize" },
            { "data": "thJan" },
            { "data": "thFeb" },
            { "data": "thMar" },
            { "data": "thApr" },
            { "data": "thMay" },
            { "data": "thJun" },
            { "data": "thJul" },
            { "data": "thAug" },
            { "data": "thSep" },
            { "data": "thOct" },
            { "data": "thNov" },
            { "data": "thDec" },
            { "data": "colour" },

        ],
    });

    // Order by the grouping
    $('#tableItems tbody').on('click', 'tr.group', function () {
        var currentOrder = tableFishDetails.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            tableFishDetails.order([groupColumn, 'desc']).draw();
        } else {
            tableFishDetails.order([groupColumn, 'asc']).draw();
        }
    });
    $('#year').select2({
        placeholder: 'Select Year(s)'
    });
    $('#fishType').select2({
        placeholder: 'Select Fish Type(s)'
    });
    $('#supplier').select2({
        placeholder: 'Select Supplier(s)'
    });
    $('#presentation').select2({
        placeholder: 'Select Presentation(s)'
    });
    $('#grade').select2({
        placeholder: 'Select Grade(s)'
    });
    $('#size').select2({
        placeholder: 'Select Size(s)'
    });

    // $('#btnReport').click(function () {
    //     getReport();
    // });
    $('#btnGenerate').click(function () {
        generateReport();
    });
    $('#btnExcel').click(function () {
        ExportExcel()
    });


    $('#fishType').change(function () {
        var array = $('#fishType').select2('data');
        var data = createMultipleSelectArray(array)
        loadPresentation(data);
        loadSize(data);
    })
    // $('#cbxFishtype').change(function () {
    //     var element= $('#fishType')
    //     enableDisableElement(this,element)
    // });
    $('#cbxSupplier').change(function () {
        var element = $('#supplier')
        enableDisableElement(this, element)
        hideColums(1)
    });
    $('#cbxPresentation').change(function () {
        var element = $('#presentation')
        enableDisableElement(this, element)
        hideColums(3)
    });
    $('#cbxGrade').change(function () {
        var element = $('#grade')
        enableDisableElement(this, element)
        hideColums(4)

    });
    $('#cbxSize').change(function () {
        var element = $('#size')
        enableDisableElement(this, element)
        hideColums(5)
    });
    $('input[type=radio][name=reportType]').change(function () {
        changeReportType(this.value);
    });
    $('.reset').change(function () {
        var table = $('#tableFishDetails').DataTable();
        table.clear();
        table.draw();
    });


    // chart_fish_type_wise();
    loadYears();
    loadSuppliers();
    loadGrades();
    loadFishTypes();
    loadPresentation('');
    loadSize('');
    loadGrnDetails();
});
function ExportExcel(type, fn, dl) {
    var elt = document.getElementById('tableFishDetails');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "Sheet JS" });
    return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
        XLSX.writeFile(wb, fn || ('MonthlyPurchaseSummary.' + (type || 'xlsx')));
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
                    $('#header_FishQty').html(data.totalQty);
                    $('#header_fishWeight').html(data.totFishWeight);
                    $('#header_proc_qty').html(data.processedPcs);
                    $('#header_Proc_Weight').html();
                    $('#header_unProcQty').html(data.unprocessedPCs);
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
//  Chart Data
// function chart_fish_type_wise() {
//     var options = {
//         chart: {
//             height: 350,
//             type: 'area',
//         },
//         dataLabels: {
//             enabled: false
//         },
//         stroke: {
//             curve: 'smooth'
//         },
//         series: [{
//             name: 'SWD',
//             data: [31, 40, 28, 51, 42, 109, 31, 40, 28, 51, 42, 109, 31, 40, 28, 51, 42, 109, 31, 40, 28, 51, 42, 109, 31, 40, 28, 51, 42, 109, 31, 40, 28, 51, 42, 109]
//         }, {
//             name: 'YFT',
//             data: [11, 32, 45, 32, 34, 52, 11, 32, 45, 32, 34, 52, 11, 32, 45, 32, 34, 52, 11, 32, 45, 32, 34, 52, 11, 32, 45, 32, 34, 52, 11, 32, 45, 32, 34, 52]
//         }, {
//             name: 'BIG',
//             data: [51, 33, 132, 43, 34, 13, 51, 33, 132, 43, 34, 13, 51, 33, 132, 43, 34, 13, 51, 33, 132, 43, 34, 13, 51, 33, 132, 43, 34, 13, 51, 33, 132, 43, 34, 13]
//         },],

//         xaxis: {
//             type: 'datetime',
//             categories: ["2020-01-01", "2020-02-01T00:00:00", "2020-03-01T00:00:00", "2020-04-01T00:00:00", "2020-05-01T00:00:00", "2020-06-01T00:00:00", "2020-07-01T00:00:00", "2020-08-01T00:00:00", "2020-09-01T00:00:00", "2020-10-01T00:00:00", "2020-11-01T00:00:00", "2020-12-01T00:00:00", "2021-01-01T00:00:00", "2021-02-01T00:00:00", "2021-03-01T00:00:00", "2021-04-01T00:00:00", "2021-05-01T00:00:00", "2021-06-01T00:00:00", "2021-07-01T00:00:00", "2021-08-01T00:00:00", "2021-09-01T00:00:00", "2021-10-01T00:00:00", "2021-11-01T00:00:00", "2021-12-01T00:00:00", "2022-01-01T00:00:00", "2022-02-01T00:00:00", "2022-03-01T00:00:00", "2022-04-01T00:00:00", "2022-05-01T00:00:00", "2022-06-01T00:00:00", "2022-07-01T00:00:00", "2022-08-01T00:00:00", "2022-09-01T00:00:00", "2022-10-01T00:00:00", "2022-11-01T00:00:00", "2022-12-01T00:00:00",],
//         },
//         tooltip: {
//             x: {
//                 format: 'yyyy-MMM'
//             },
//         }
//     }

//     var chart = new ApexCharts(
//         document.querySelector("#chart_fish_type_wise"),
//         options
//     );

//     chart.render();
// }

function loadYears() {
    $.ajax({
        type: 'GET',
        url: '/buying/monthlyPurchaseSummary/loadYears',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.year + '" > ' + value.year + ' </option>';
                });
                $('#year').html(html);
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
        url: '/buying/monthlyPurchaseSummary/loadSuppliers',
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
function loadSuppliers() {
    $.ajax({
        type: 'GET',
        url: '/buying/monthlyPurchaseSummary/loadSuppliers',
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
function loadGrades() {
    $.ajax({
        type: 'GET',
        url: '/buying/monthlyPurchaseSummary/loadGrades',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.supplier_grade + '" > ' + value.supplier_grade + ' </option>';
                });
                $('#grade').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadFishTypes() {
    $.ajax({
        type: 'GET',
        url: '/buying/monthlyPurchaseSummary/loadFishTypes',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                $('#fishType').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadPresentation(data) {
    $.ajax({
        type: 'GET',
        url: '/buying/monthlyPurchaseSummary/loadPresentation',
        data: { 'data': data },
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.PrsntName + '" > ' + value.PrsntName + ' </option>';
                });
                $('#presentation').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadSize(data) {
    $.ajax({
        type: 'GET',
        url: '/buying/monthlyPurchaseSummary/loadSize',
        data: { 'data': data },
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.SizeDescription + '" > ' + value.SizeDescription + ' </option>';
                });
                $('#size').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function SetFilters() {
    var cbxSupplier = $('#cbxSupplier')
    var cbxPresentation = $('#cbxPresentation')
    var cbxGrade = $('#cbxGrade')
    var cbxSize = $('#cbxSize')


    var year = $('#year').select2('data');
    var fishType = $('#fishType').select2('data');
    var supplier = $('#supplier').select2('data');
    var presentation = $('#presentation').select2('data');
    var grade = $('#grade').select2('data');
    var size = $('#size').select2('data');
    var reportType = $('input[name="reportType"]:checked').val();

    if (year.length != 0) {
        year = createMultipleSelectArray(year)
    }
    if (fishType.length != 0) {
        fishType = createMultipleSelectArray(fishType)
    }

    if (cbxSupplier.is(':checked')) {
        if (supplier.length != 0) {
            supplier = createMultipleSelectArray(supplier)
        } else {
            supplier = '';
        }
    } else {
        supplier = false;
    }

    if (cbxPresentation.is(':checked')) {
        if (presentation.length != 0) {
            presentation = createMultipleSelectArray(presentation)
        } else {
            presentation = '';
        }
    } else {
        presentation = false;
    }

    if (cbxGrade.is(':checked')) {
        if (grade.length != 0) {
            grade = createMultipleSelectArray(grade)
        } else {
            grade = '';
        }
    } else {
        grade = false;
    }

    if (cbxSize.is(':checked')) {

        if (size.length != 0) {
            size = createMultipleSelectArray(size)
        } else {
            size = '';
        }
    } else {
        size = false;
    }
    return {
        'year': year,
        'fishType': fishType,
        'supplier': supplier,
        'presentation': presentation,
        'grade': grade,
        'size': size,
        'reportType': reportType
    };
}
function generateReport() {
    $.ajax({
        type: 'GET',
        url: '/buying/monthlyPurchaseSummary/generateReport',
        data: SetFilters(),

        success: function (response) {
            console.log(response)
            if (response.success) {
                var cbxSimilar = $('#cbxSimilar')

                var data = [];
                $.each(response.result.reportData, function (i, val) {
                    // $.each(response.result.reportData, function (i, val) {
                    var supplier = '';
                    var presentation = '';
                    var supplier_grade = '';
                    var SizeDescription = '';
                    var notAdded = true;
                    if (val.supplier_name) {
                        supplier = val.supplier_name
                    }
                    if (val.presentation) {
                        presentation = val.presentation
                    }
                    if (val.supplier_grade) {
                        supplier_grade = val.supplier_grade
                    }
                    if (val.SizeDescription) {
                        SizeDescription = val.SizeDescription
                    }
                    if (cbxSimilar.is(':checked')) {
                        if (data.length != 0) {
                            var lastRow = Number(data.length) - 1;
                            var year = val.GRNYear;
                            var sup = supplier;
                            var Ft = val.FishName;
                            var pres = presentation;
                            var grd = supplier_grade;
                            var siz = SizeDescription;
                            if (Number(data[lastRow]['year']) == Number(year)) {
                                year = ''

                            } else {
                                data.push({
                                    "thYear": '',
                                    "thSupplier": '',
                                    "thFishType": '',
                                    "thPresentation": '',
                                    "thPayGrade": '',
                                    "thSize": '',
                                    "thJan": '',
                                    "thFeb": '',
                                    "thMar": '',
                                    "thApr": '',
                                    "thMay": '',
                                    "thJun": '',
                                    "thJul": '',
                                    "thAug": '',
                                    "thSep": '',
                                    "thOct": '',
                                    "thNov": '',
                                    "thDec": '',
                                    'year': val.GRNYear,
                                    'Supplier': supplier,
                                    'FishType': val.FishName,
                                    'Presentation': presentation,
                                    'PayGrade': supplier_grade,
                                    'Size': SizeDescription,
                                    'colour': 1
                                });
                                notAdded = false
                            }
                            if (data[lastRow]['Supplier'] == supplier) {
                                sup = ''
                            }
                            else {
                                if (notAdded) {
                                    data.push({
                                        "thYear": '',
                                        "thSupplier": '',
                                        "thFishType": '',
                                        "thPresentation": '',
                                        "thPayGrade": '',
                                        "thSize": '',
                                        "thJan": '',
                                        "thFeb": '',
                                        "thMar": '',
                                        "thApr": '',
                                        "thMay": '',
                                        "thJun": '',
                                        "thJul": '',
                                        "thAug": '',
                                        "thSep": '',
                                        "thOct": '',
                                        "thNov": '',
                                        "thDec": '',
                                        'year': val.GRNYear,
                                        'Supplier': supplier,
                                        'FishType': val.FishName,
                                        'Presentation': presentation,
                                        'PayGrade': supplier_grade,
                                        'Size': SizeDescription,
                                        'colour': 1

                                    });
                                    notAdded = false

                                }

                            }
                            if (data[lastRow]['FishType'] == val.FishName) {
                                Ft = ''
                            } else {
                                if (notAdded) {
                                    data.push({
                                        "thYear": '',
                                        "thSupplier": '',
                                        "thFishType": '',
                                        "thPresentation": '',
                                        "thPayGrade": '',
                                        "thSize": '',
                                        "thJan": '',
                                        "thFeb": '',
                                        "thMar": '',
                                        "thApr": '',
                                        "thMay": '',
                                        "thJun": '',
                                        "thJul": '',
                                        "thAug": '',
                                        "thSep": '',
                                        "thOct": '',
                                        "thNov": '',
                                        "thDec": '',
                                        'year': val.GRNYear,
                                        'Supplier': supplier,
                                        'FishType': val.FishName,
                                        'Presentation': presentation,
                                        'PayGrade': supplier_grade,
                                        'Size': SizeDescription,
                                        'colour': 1

                                    });
                                }

                            }

                            if (data[lastRow]['Presentation'] == presentation) {
                                pres = ''
                            }
                            if (data[lastRow]['PayGrade'] == supplier_grade) {
                                grd = ''
                            }
                            if (data[lastRow]['Size'] == SizeDescription) {
                                siz = ''
                            }
                            data.push({
                                "thYear": year,
                                "thSupplier": sup,
                                "thFishType": Ft,
                                "thPresentation": pres,
                                "thPayGrade": grd,
                                "thSize": siz,
                                "thJan": Number(val.Jan).toFixed(3),
                                "thFeb": Number(val.Feb).toFixed(3),
                                "thMar": Number(val.Mar).toFixed(3),
                                "thApr": Number(val.Apr).toFixed(3),
                                "thMay": Number(val.May).toFixed(3),
                                "thJun": Number(val.Jun).toFixed(3),
                                "thJul": Number(val.Jul).toFixed(3),
                                "thAug": Number(val.Aug).toFixed(3),
                                "thSep": Number(val.Sep).toFixed(3),
                                "thOct": Number(val.Oct).toFixed(3),
                                "thNov": Number(val.Nov).toFixed(3),
                                "thDec": Number(val.Dec).toFixed(3),
                                'year': val.GRNYear,
                                'Supplier': supplier,
                                'FishType': val.FishName,
                                'Presentation': presentation,
                                'PayGrade': supplier_grade,
                                'Size': SizeDescription,
                                'colour': 0
                            });
                        } else {
                            data.push({
                                "thYear": val.GRNYear,
                                "thSupplier": supplier,
                                "thFishType": val.FishName,
                                "thPresentation": presentation,
                                "thPayGrade": supplier_grade,
                                "thSize": SizeDescription,
                                "thJan": Number(val.Jan).toFixed(3),
                                "thFeb": Number(val.Feb).toFixed(3),
                                "thMar": Number(val.Mar).toFixed(3),
                                "thApr": Number(val.Apr).toFixed(3),
                                "thMay": Number(val.May).toFixed(3),
                                "thJun": Number(val.Jun).toFixed(3),
                                "thJul": Number(val.Jul).toFixed(3),
                                "thAug": Number(val.Aug).toFixed(3),
                                "thSep": Number(val.Sep).toFixed(3),
                                "thOct": Number(val.Oct).toFixed(3),
                                "thNov": Number(val.Nov).toFixed(3),
                                "thDec": Number(val.Dec).toFixed(3),
                                'year': val.GRNYear,
                                'Supplier': supplier,
                                'FishType': val.FishName,
                                'Presentation': presentation,
                                'PayGrade': supplier_grade,
                                'Size': SizeDescription,
                                'colour': 0

                            });
                        }
                    } else {
                        data.push({
                            "thYear": val.GRNYear,
                            "thSupplier": supplier,
                            "thFishType": val.FishName,
                            "thPresentation": presentation,
                            "thPayGrade": supplier_grade,
                            "thSize": SizeDescription,
                            "thJan": Number(val.Jan).toFixed(3),
                            "thFeb": Number(val.Feb).toFixed(3),
                            "thMar": Number(val.Mar).toFixed(3),
                            "thApr": Number(val.Apr).toFixed(3),
                            "thMay": Number(val.May).toFixed(3),
                            "thJun": Number(val.Jun).toFixed(3),
                            "thJul": Number(val.Jul).toFixed(3),
                            "thAug": Number(val.Aug).toFixed(3),
                            "thSep": Number(val.Sep).toFixed(3),
                            "thOct": Number(val.Oct).toFixed(3),
                            "thNov": Number(val.Nov).toFixed(3),
                            "thDec": Number(val.Dec).toFixed(3),
                            'colour': 0
                        });
                    }

                });
                var table = $('#tableFishDetails').DataTable();
                table.clear();
                table.rows.add(data).draw();

                UpdateChart(response.result.chart);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function enableDisableElement(cbx, el) {
    if (cbx.checked) {
        el.prop("disabled", false);
    } else {
        el.prop("disabled", true);
    }
}
function changeReportType(type) {
    var tableFishDetails = $('#tableFishDetails').DataTable();
    if (type == 'supplier') {
        $('#supplier').prop("disabled", false);
        $('#cbxSupplier').prop("checked", true);
        $('#cbxSupplier').prop("disabled", true);
        tableFishDetails.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18], true);
        // tableFishDetails.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]);

    } else {
        $('#cbxSupplier').prop("disabled", false);
        tableFishDetails.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18], true);
        tableFishDetails.colReorder.order([0, 2, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]);
    }
}
function hideColums(col) {
    var table = $('#tableFishDetails').DataTable();
    var type = $('input[type=radio][name=reportType]').val();
    if (type == 'supplier') {
        table.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18], true);
        // table.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]);
    } else {
        table.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18], true);
        table.colReorder.order([0, 2, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]);
    }
    var column = table.column(col);

    // Toggle the visibility
    column.visible(!column.visible());
}
function UpdateChart(data) {
    var series = []
    var years = [];
    $.each(data, function (i, val) {

        if (series.length != 0) {
            $.each(series, function (i, v) {


            });
        } else {
            series.push(
                {
                    'name': val.FishName,
                    'data': [
                        Number(val.Jan).toFixed(3),
                        Number(val.Feb).toFixed(3),
                        Number(val.Mar).toFixed(3),
                        Number(val.Apr).toFixed(3),
                        Number(val.May).toFixed(3),
                        Number(val.Jun).toFixed(3),
                        Number(val.Jul).toFixed(3),
                        Number(val.Aug).toFixed(3),
                        Number(val.Sep).toFixed(3),
                        Number(val.Oct).toFixed(3),
                        Number(val.Nov).toFixed(3),
                        Number(val.Dec).toFixed(3)
                    ]
                }
            )
        }
        years.push(
            new Date(val.GRNYear + '-01-01').toDateString(),
            new Date(val.GRNYear + '-02-01').toDateString(),
            new Date(val.GRNYear + '-03-01').toDateString(),
            new Date(val.GRNYear + '-04-01').toDateString(),
            new Date(val.GRNYear + '-05-01').toDateString(),
            new Date(val.GRNYear + '-06-01').toDateString(),
            new Date(val.GRNYear + '-07-01').toDateString(),
            new Date(val.GRNYear + '-08-01').toDateString(),
            new Date(val.GRNYear + '-09-01').toDateString(),
            new Date(val.GRNYear + '-10-01').toDateString(),
            new Date(val.GRNYear + '-11-01').toDateString(),
            new Date(val.GRNYear + '-13-01').toDateString(),
        );
    });
    console.log(series)
    console.log(years)



    chart.updateOptions({
        series: series,
        xaxis: {
            type: 'datetime',
            categories: years
        }
    })

}


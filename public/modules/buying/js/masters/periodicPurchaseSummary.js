console.log('periodicPurchaseSummary .js loadimng');
var startDate = 0
, endDate = 0;

var optionsWeightSummary = {
    plotOptions: {
        pie: {
            customScale: 1,
            donut: {
                labels: {
                    show: true
                },
            },
        },
    },
    series: [1],
    labels: ['-'],
    chart: {
        type: 'donut',
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + " Kg"
            }
        }
    },
    responsive: [{
        breakpoint: 200,
        options: {
            chart: {
                width: 1,
                height: 1
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};
var chartWeightSummary = new ApexCharts(document.querySelector("#weightSummary"), optionsWeightSummary);
chartWeightSummary.render();

var optionsGradeSummary = {
    plotOptions: {
        pie: {
            customScale: 1,
            donut: {
                labels: {
                    show: true
                },
            },
        },
    },
    series: [1],
    labels: ['-'],
    chart: {
        type: 'donut',
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + " Kg"
            }
        }
    },
    responsive: [{
        breakpoint: 200,
        options: {
            chart: {
                width: 1,
                height: 1
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};
var chartGradeSummary = new ApexCharts(document.querySelector("#gradeSummary"), optionsGradeSummary);
chartGradeSummary.render();

var optionsPresentationSummary = {
    plotOptions: {
        pie: {
            customScale: 1,
            donut: {
                labels: {
                    show: true
                },
            },
        },
    },
    series: [1],
    labels: ['-'],
    chart: {
        type: 'donut',
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + " Kg"
            }
        }
    },
    responsive: [{
        breakpoint: 200,
        options: {
            chart: {
                width: 1,
                height: 1
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};
var chartPresentationSummary = new ApexCharts(document.querySelector("#presentationSummary"), optionsPresentationSummary);
chartPresentationSummary.render();

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
                "targets": [0, 1, 2, 3, 4],
                "className": "text-center",
            },
            {
                "targets": [6, 7, 8, 9, 10, 11],
                "className": "text-right",
            }
        ],
        "columns": [
            { "data": "thSupplier" },
            { "data": "thFishType" },
            { "data": "thPresentation" },
            { "data": "thPayGrade" },
            { "data": "thSize" },
            { "data": "thPcs" },
            { "data": "thNetWeight" },
            { "data": "thAvgUnitWeightPriceLC" },
            { "data": "thTotalValueLC" },
            { "data": "thAvgUnitWeightPriceBC" },
            { "data": "thTotalValueBC" },
            { "data": "thPresentage" },

        ],
    });

    //date range pikker callback Function
    $(function () {
        $('#datefilter').daterangepicker({
            opens: 'left',
            // endDate: moment().subtract(5, 'day'),
        }, function (start, end, label) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
        });
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

    $('#btnGenerate').click(function () {
        generateReport();
        // console.log(SetFilters())
    });

    $('#cbxSupplier').change(function () {
        var element = $('#supplier')
        enableDisableElement(this, element)
        hideColums(0)
    });
    $('#cbxPresentation').change(function () {
        var element = $('#presentation')
        enableDisableElement(this, element)
        hideColums(2)
    });
    $('#cbxGrade').change(function () {
        var element = $('#grade')
        enableDisableElement(this, element)
        hideColums(3)
    });
    $('#cbxSize').change(function () {
        var element = $('#size')
        enableDisableElement(this, element)
        hideColums(4)
    });
    $('input[type=radio][name=reportType]').change(function () {
        changeReportType(this.value);
    });
    $('#checkboxShowValues').change(function () {
        for (let i = 7; i < 11; i++) {
            hideColums(i)
        }
        console.log('not checked')
    });
    $('.reset').change(function () {
        var table = $('#tableFishDetails').DataTable();
        table.clear();
        table.draw();
    });
    $('#fishTypePresentationWise').change(function () {
        getPresentationWiseChartData()
    });
    $('#fishTypeGradeWise').change(function () {
        getGradeWiseChartData()
    });

    loadSuppliers();
    loadGrades();
    loadFishTypes();
    loadPresentation('');
    loadSize('');
    getPresentationWiseChartData();
    getGradeWiseChartData();

});


function loadSuppliers() {
    $.ajax({
        type: 'GET',
        url: '/buying/periodicPurchaseSummary/loadSuppliers',
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
        url: '/buying/periodicPurchaseSummary/loadSuppliers',
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
        url: '/buying/periodicPurchaseSummary/loadGrades',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                html += '<option value="" > -Select- </option>';
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.pay_grade + '" > ' + value.pay_grade + ' </option>';
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
        url: '/buying/periodicPurchaseSummary/loadFishTypes',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                $('#fishType').html(html);
                $('.fishType').html(html);

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
        url: '/buying/periodicPurchaseSummary/loadPresentation',
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
        url: '/buying/periodicPurchaseSummary/loadSize',
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

    var fishType = $('#fishType').select2('data');
    var supplier = $('#supplier').select2('data');
    var presentation = $('#presentation').select2('data');
    var grade = $('#grade').select2('data');
    var size = $('#size').select2('data');
    var reportType = $('input[name="reportType"]:checked').val();
    var gradeWise = $('#fishTypeGradeWise').val();
    var PresentationWise = $('#fishTypePresentationWise').val();

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
        'startDate': startDate,
        'endDate': endDate,
        'fishType': fishType,
        'supplier': supplier,
        'presentation': presentation,
        'grade': grade,
        'size': size,
        'reportType': reportType,
        'gradeWise': gradeWise,
        'PresentationWise': PresentationWise
    };
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
        tableFishDetails.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], true);
    } else {
        $('#cbxSupplier').prop("disabled", false);
        tableFishDetails.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], true);
        tableFishDetails.colReorder.order([1, 0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);
    }
}
function hideColums(col) {
    var table = $('#tableFishDetails').DataTable();
    var type = $('input[type=radio][name=reportType]').val();
    if (type == 'supplier') {
        table.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], true);
        // table.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]);
    } else {
        table.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], true);
        table.colReorder.order([0, 2, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11]);
    }
    var column = table.column(col);

    // Toggle the visibility
    column.visible(!column.visible());
}
function generateReport() {
    $.ajax({
        type: 'GET',
        url: '/buying/periodicPurchaseSummary/generateReport',
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
                    var pay_grade = '';
                    var SizeDescription = '';
                    var notAdded = true;

                    if (val.supplier_name) {
                        supplier = val.supplier_name
                    }
                    if (val.rm_presentation) {
                        presentation = val.rm_presentation
                    }
                    if (val.pay_grade) {
                        pay_grade = val.pay_grade
                    }
                    if (val.SizeDescription) {
                        SizeDescription = val.SizeDescription
                    }
                    if (cbxSimilar.is(':checked')) {
                        if (data.length != 0) {
                            var lastRow = Number(data.length) - 1;
                            var sup = supplier;
                            var Ft = val.FishName;
                            var pres = presentation;
                            var grd = pay_grade;
                            var siz = SizeDescription;
                            if (data[lastRow]['Supplier'] == supplier) {
                                sup = ''
                            } else {
                                if (notAdded) {
                                    data.push({
                                        "thSupplier": '',
                                        "thFishType": '',
                                        "thPresentation": '',
                                        "thPayGrade": '',
                                        "thSize": '',
                                        "thPcs": '',
                                        "thNetWeight": '',
                                        "thAvgUnitWeightPriceLC": '',
                                        "thTotalValueLC": '',
                                        "thAvgUnitWeightPriceBC": '',
                                        "thTotalValueBC": '',
                                        'thPresentage': '',
                                        'Supplier': supplier,
                                        'FishType': val.FishName,
                                        'Presentation': presentation,
                                        'PayGrade': pay_grade,
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
                                        "thSupplier": '',
                                        "thFishType": '',
                                        "thPresentation": '',
                                        "thPayGrade": '',
                                        "thSize": '',
                                        "thPcs": '',
                                        "thNetWeight": '',
                                        "thAvgUnitWeightPriceLC": '',
                                        "thTotalValueLC": '',
                                        "thAvgUnitWeightPriceBC": '',
                                        "thTotalValueBC": '',
                                        'thPresentage': '',
                                        'Supplier': supplier,
                                        'FishType': val.FishName,
                                        'Presentation': presentation,
                                        'PayGrade': pay_grade,
                                        'Size': SizeDescription,
                                        'colour': 1
                                    });
                                    notAdded = false
                                }
                            }
                            if (data[lastRow]['Presentation'] == presentation) {
                                pres = ''
                            }
                            if (data[lastRow]['PayGrade'] == pay_grade) {
                                grd = ''
                            }
                            if (data[lastRow]['Size'] == SizeDescription) {
                                siz = ''
                            }
                            data.push({
                                "thSupplier": sup,
                                "thFishType": Ft,
                                "thPresentation": pres,
                                "thPayGrade": grd,
                                "thSize": siz,
                                "thPcs": val.rm_qty,
                                "thNetWeight": Number(val.rm_tot_weight).toFixed(3),
                                "thAvgUnitWeightPriceLC": Number(val.localAvgWeight).toFixed(2),
                                "thTotalValueLC": (Number(val.localAvgWeight) * Number(val.rm_tot_weight)).toFixed(2),
                                "thAvgUnitWeightPriceBC": Number(val.baseAvgWeight).toFixed(2),
                                "thTotalValueBC": (Number(val.baseAvgWeight) * Number(val.rm_tot_weight)).toFixed(2),
                                'thPresentage': (Number(val.presentage)).toFixed(2) + '%',
                                'Supplier': supplier,
                                'FishType': val.FishName,
                                'Presentation': presentation,
                                'PayGrade': pay_grade,
                                'Size': SizeDescription,
                                'colour': 0
                            });
                        }
                        else {
                            data.push({
                                "thSupplier": supplier,
                                "thFishType": val.FishName,
                                "thPresentation": presentation,
                                "thPayGrade": pay_grade,
                                "thSize": SizeDescription,
                                "thPcs": val.rm_qty,
                                "thNetWeight": Number(val.rm_tot_weight).toFixed(3),
                                "thAvgUnitWeightPriceLC": Number(val.localAvgWeight).toFixed(2),
                                "thTotalValueLC": (Number(val.localAvgWeight) * Number(val.rm_tot_weight)).toFixed(2),
                                "thAvgUnitWeightPriceBC": Number(val.baseAvgWeight).toFixed(2),
                                "thTotalValueBC": (Number(val.baseAvgWeight) * Number(val.rm_tot_weight)).toFixed(2),
                                'thPresentage': (Number(val.presentage)).toFixed(2) + '%',

                            });
                        }
                    } else {
                        data.push({
                            "thSupplier": supplier,
                            "thFishType": val.FishName,
                            "thPresentation": presentation,
                            "thPayGrade": pay_grade,
                            "thSize": SizeDescription,
                            "thPcs": val.rm_qty,
                            "thNetWeight": Number(val.rm_tot_weight).toFixed(3),
                            "thAvgUnitWeightPriceLC": Number(val.localAvgWeight).toFixed(2),
                            "thTotalValueLC": (Number(val.localAvgWeight) * Number(val.rm_tot_weight)).toFixed(2),
                            "thAvgUnitWeightPriceBC": Number(val.baseAvgWeight).toFixed(2),
                            "thTotalValueBC": (Number(val.baseAvgWeight) * Number(val.rm_tot_weight)).toFixed(2),
                            'thPresentage': (Number(val.presentage)).toFixed(2) + '%',
                            'Supplier': supplier,
                            'FishType': val.FishName,
                            'Presentation': presentation,
                            'PayGrade': pay_grade,
                            'Size': SizeDescription,
                            'colour': 0
                        });
                    }

                });
                var table = $('#tableFishDetails').DataTable();
                table.clear();
                table.rows.add(data).draw();
                updateCharts(response.result.charts)
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function updateCharts(data) {
    console.log(data)
    var reportType = $('input[name="reportType"]:checked').val();

    var series = [];
    var labels = [];
    $.each(data.WeightSummaryChart, function (i, val) {
        series.push(
            Number(val.weight)
        )
        if (reportType == 'supplier') {
            labels.push(
                val.supplier_name
            )
        } else {
            labels.push(
                val.FishName
            )
        }
    });
    chartWeightSummary.updateOptions({
        series: series,
        labels: labels
    })
    updateGradeSummaryChart(data.GradeSummaryChart)
    updatePresentationSummaryChart(data.PresentationSummaryChart)
};
function updateGradeSummaryChart(data) {
    var series = [];
    var labels = [];
    $.each(data, function (i, val) {
        series.push(
            Number(val.weight)
        )

        labels.push(
            val.pay_grade
        )
    });
    chartGradeSummary.updateOptions({
        series: series,
        labels: labels
    })
}
function updatePresentationSummaryChart(data) {
    var series = [];
    var labels = [];
    $.each(data, function (i, val) {
        series.push(
            Number(val.weight)
        )

        labels.push(
            val.rm_presentation
        )
    });
    chartPresentationSummary.updateOptions({
        series: series,
        labels: labels
    })
}
function getGradeWiseChartData() {
    $.ajax({
        type: 'GET',
        url: '/buying/periodicPurchaseSummary/getGradeWiseChartData',
        data: SetFilters(),

        success: function (response) {
            console.log(response)
            if (response.length != 0) {
                updateGradeSummaryChart(response)
            } else {
                toastr.warning('This fish type has no data');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function getPresentationWiseChartData() {
    $.ajax({
        type: 'GET',
        url: '/buying/periodicPurchaseSummary/getPresentationWiseChartData',
        data: SetFilters(),

        success: function (response) {
            console.log(response)
            if (response.length != 0) {
                updatePresentationSummaryChart(response)
            } else {
                toastr.warning('This fish type has no data');

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}


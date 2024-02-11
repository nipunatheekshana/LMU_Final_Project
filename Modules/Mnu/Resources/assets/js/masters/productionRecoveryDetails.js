console.log('productionRecoveryDetails .js loadimng');
var startDate = 0;
var endDate = 0;
var avgArray = [];

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
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
                "className": "text-center",
            },
            // {
            //     "targets": [6, 7, 8, 9, 10,11],
            //     "className": "text-right",
            // }
        ],
        "columns": [
            { "data": "thGRNNo" },
            { "data": "thGRNDate" },
            { "data": "thSupplier" },
            { "data": "thFishType" },
            { "data": "thPresentation" },
            { "data": "thQualityGrade" },
            { "data": "thSize" },
            { "data": "thPcs" },
            { "data": "thWeight" },
            { "data": "thTotalProcessedPcs" },
            { "data": "thTotalProcessedWeight" },
            { "data": "thProcessedMode" },
            { "data": "thProcessedPcs" },
            { "data": "thProcessedWeight" },
            { "data": "thGrossProdWg" },
            { "data": "thGrossProdYield" },
            { "data": "thNetProdWg" },
            { "data": "thNetProdYield" },
            { "data": "thExWg" },
            { "data": "thExYield" },
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
    $('#grn_no').select2({
        placeholder: 'Select Fish Type(s)'
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


    $('#cbxPresentation').change(function () {
        var element = $('#presentation')
        enableDisableElement(this, element)
        hideColums(4)
    });
    $('#cbxGrade').change(function () {
        var element = $('#grade')
        enableDisableElement(this, element)
        hideColums(5)
    });
    $('#cbxSize').change(function () {
        var element = $('#size')
        enableDisableElement(this, element)
        hideColums(6)
    });
    $('#cbxGRNno').change(function () {
        var element = $('#grn_no')
        enableDisableElement(this, element)
        hideColums(0)
        hideColums(1)
    });
    $('input[type=radio][name=reportType]').change(function () {
        changeReportType(this.value);
    });
    $('.reset').change(function () {
        var table = $('#tableFishDetails').DataTable();
        table.clear();
        table.draw();
    });
    $("#fishTypeAvgSelector").change(function () {
        setAvgsToTheFish();
    })


    loadSuppliers();
    loadGrades();
    loadFishTypes();
    loadGRNnumbers();
    loadPresentation('');
    loadSize('');



});


function loadSuppliers() {
    $.ajax({
        type: 'GET',
        url: '/mnu/productionRecoveryDetails/loadSuppliers',
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
        url: '/mnu/productionRecoveryDetails/loadSuppliers',
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
        url: '/mnu/productionRecoveryDetails/loadGrades',
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
        url: '/mnu/productionRecoveryDetails/loadFishTypes',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                // $('#fishType').html(html);
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
        url: '/mnu/productionRecoveryDetails/loadPresentation',
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
        url: '/mnu/productionRecoveryDetails/loadSize',
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
function loadGRNnumbers() {
    $.ajax({
        type: 'GET',
        url: '/mnu/productionRecoveryDetails/loadGRNnumbers',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.grnno + '" > ' + value.grnno + ' </option>';
                });
                $('#grn_no').html(html);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function SetFilters() {
    // var cbxSupplier = $('#cbxSupplier')
    var cbxPresentation = $('#cbxPresentation')
    var cbxGrade = $('#cbxGrade')
    var cbxSize = $('#cbxSize')
    var cbxGRNno = $('#cbxGRNno')


    var fishType = $('#fishType').select2('data');
    var supplier = $('#supplier').select2('data');
    var presentation = $('#presentation').select2('data');
    var grade = $('#grade').select2('data');
    var size = $('#size').select2('data');
    var grn_no = $('#grn_no').select2('data');



    if (fishType.length != 0) {
        fishType = createMultipleSelectArray(fishType)
    }
    if (supplier.length != 0) {
        supplier = createMultipleSelectArray(supplier)
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
    if (cbxGRNno.is(':checked')) {

        if (grn_no.length != 0) {
            grn_no = createMultipleSelectArray(grn_no)
        } else {
            grn_no = '';
        }
    } else {
        grn_no = false;
    }
    return {
        'startDate': startDate,
        'endDate': endDate,
        'fishType': fishType,
        'supplier': supplier,
        'presentation': presentation,
        'grade': grade,
        'size': size,
        'grn_no': grn_no,
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
        tableFishDetails.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], true);
    } else {
        $('#cbxSupplier').prop("disabled", false);
        tableFishDetails.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], true);
        tableFishDetails.colReorder.order([1, 0, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
    }
}
function hideColums(col) {
    var table = $('#tableFishDetails').DataTable();

    var column = table.column(col);

    // Toggle the visibility
    column.visible(!column.visible());
}
function generateReport() {
    $.ajax({
        type: 'GET',
        url: '/mnu/productionRecoveryDetails/generateReport',
        data: SetFilters(),

        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = [];
                $.each(response.result, function (i, val) {

                    var cbxSimilar = $('#cbxSimilar')

                    var lastRow = Number(data.length) - 1;
                    var GRNno = val.lot_grnno;
                    var GRNdate = val.grndate;
                    var supplier = val.supplier_name;
                    var fishType = val.FishName;
                    var presentation = val.presentation;
                    var Qgrade = val.quality_grade;
                    var size = val.SizeDescription;
                    var GrossProdYield = Yield(val.gross_prod_wg, val.batch_weight);
                    var NetProdYield = Yield(val.net_prod_wg, val.batch_weight);
                    var ExYield = Yield(val.exp_wg, val.batch_weight);
                    var issame = true;



                    //when merge is checked
                    if (cbxSimilar.is(':checked')) {
                        //when data is not empty
                        if (data.length != 0) {
                            if (data[lastRow]['GRNno'] == val.lot_grnno) {
                                if (issame) {
                                    GRNno = '';
                                }
                            } else {
                                issame = false;
                                data.push({
                                    "thGRNNo": '',
                                    "thGRNDate": '',
                                    "thSupplier": '',
                                    "thFishType": '',
                                    "thPresentation": '',
                                    "thQualityGrade": '',
                                    "thSize": '',
                                    "thPcs": '',
                                    "thWeight": '',
                                    "thTotalProcessedPcs": '',
                                    "thTotalProcessedWeight": '',
                                    'thProcessedMode': '',
                                    'thProcessedPcs': '',
                                    'thProcessedWeight': '',
                                    'thGrossProdWg': '',
                                    'thGrossProdYield': '',
                                    'thNetProdWg': '',
                                    'thNetProdYield': '',
                                    'thExWg': '',
                                    'thExYield': '',
                                    'GRNno': val.lot_grnno,
                                    'GRNdate': val.grndate,
                                    'supplier': val.supplier_name,
                                    'fishType': val.FishName,
                                    'presentation': val.presentation,
                                    'Qgrade': val.quality_grade,
                                    'size': val.SizeDescription,
                                    'colour': 1

                                });
                            }
                            if (data[lastRow]['GRNdate'] == val.grndate) {
                                if (issame) {
                                    GRNdate = '';
                                }
                            }
                            else {
                                issame = false
                            }
                            if (data[lastRow]['supplier'] == val.supplier_name) {
                                if (issame) {
                                    supplier = '';
                                }
                            }
                            else {
                                issame = false
                            }
                            if (data[lastRow]['fishType'] == val.FishName) {
                                if (issame) {
                                    fishType = '';
                                }
                            }
                            else {
                                issame = false
                            }
                            if (data[lastRow]['presentation'] == val.presentation) {
                                if (issame) {
                                    presentation = '';
                                }
                            }
                            else {
                                issame = false
                            }
                            if (data[lastRow]['Qgrade'] == val.quality_grade) {
                                if (issame) {
                                    Qgrade = '';
                                }
                            }
                            else {
                                issame = false
                            }
                            if (data[lastRow]['size'] == val.SizeDescription) {
                                if (issame) {
                                    size = '';
                                }
                            }
                            else {
                                issame = false
                            }

                            data.push({
                                "thGRNNo": GRNno,
                                "thGRNDate": GRNdate,
                                "thSupplier": supplier,
                                "thFishType": fishType,
                                "thPresentation": presentation,
                                "thQualityGrade": Qgrade,
                                "thSize": size,
                                "thPcs": val.RcvPcs,
                                "thWeight": val.RcvWeight,
                                "thTotalProcessedPcs": val.ProcessPcs,
                                "thTotalProcessedWeight": val.ProcessWgt,
                                'thProcessedMode': val.item_process_mode,
                                'thProcessedPcs': val.NoofPcs,
                                'thProcessedWeight': val.PcsWgt,
                                'thGrossProdWg': val.gross_prod_wg,
                                'thGrossProdYield': GrossProdYield,
                                'thNetProdWg': val.net_prod_wg,
                                'thNetProdYield': NetProdYield,
                                'thExWg': val.exp_wg,
                                'thExYield': ExYield,
                                'GRNno': val.lot_grnno,
                                'GRNdate': val.grndate,
                                'supplier': val.supplier_name,
                                'fishType': val.FishName,
                                'presentation': val.presentation,
                                'Qgrade': val.quality_grade,
                                'size': val.SizeDescription,
                                'colour': 0
                            });
                        }
                        //when data is empty
                        else {
                            data.push({
                                "thGRNNo": GRNno,
                                "thGRNDate": GRNdate,
                                "thSupplier": supplier,
                                "thFishType": fishType,
                                "thPresentation": presentation,
                                "thQualityGrade": Qgrade,
                                "thSize": size,
                                "thPcs": val.RcvPcs,
                                "thWeight": val.RcvWeight,
                                "thTotalProcessedPcs": val.ProcessPcs,
                                "thTotalProcessedWeight": val.ProcessWgt,
                                'thProcessedMode': val.item_process_mode,
                                'thProcessedPcs': val.NoofPcs,
                                'thProcessedWeight': val.PcsWgt,
                                'thGrossProdWg': val.gross_prod_wg,
                                'thGrossProdYield': GrossProdYield,
                                'thNetProdWg': val.net_prod_wg,
                                'thNetProdYield': NetProdYield,
                                'thExWg': val.exp_wg,
                                'thExYield': ExYield,
                                'GRNno': val.lot_grnno,
                                'GRNdate': val.grndate,
                                'supplier': val.supplier_name,
                                'fishType': val.FishName,
                                'presentation': val.presentation,
                                'Qgrade': val.quality_grade,
                                'size': val.SizeDescription,

                            });
                        }

                    }
                    //when merge is not checked
                    else {
                        data.push({
                            "thGRNNo": GRNno,
                            "thGRNDate": GRNdate,
                            "thSupplier": supplier,
                            "thFishType": fishType,
                            "thPresentation": presentation,
                            "thQualityGrade": Qgrade,
                            "thSize": size,
                            "thPcs": val.RcvPcs,
                            "thWeight": val.RcvWeight,
                            "thTotalProcessedPcs": val.ProcessPcs,
                            "thTotalProcessedWeight": val.ProcessWgt,
                            'thProcessedMode': val.item_process_mode,
                            'thProcessedPcs': val.NoofPcs,
                            'thProcessedWeight': val.PcsWgt,
                            'thGrossProdWg': val.gross_prod_wg,
                            'thGrossProdYield': GrossProdYield,
                            'thNetProdWg': val.net_prod_wg,
                            'thNetProdYield': NetProdYield,
                            'thExWg': val.exp_wg,
                            'thExYield': ExYield
                        });
                    }

                });
                var table = $('#tableFishDetails').DataTable();
                table.clear();
                table.rows.add(data).draw();

                calTotalRcWgAndPrWg(response.result);
                calAvgGrossRecoveryTofish(response.result)

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function calTotalRcWgAndPrWg(data) {
    var RcWg = 0;
    var PrWg = 0;
    $.each(data, function (i, val) {
        if (val.RcvWeight) {
            RcWg += Number(val.RcvWeight);
        }
    })
    $('#resiveWeight').html(RcWg.toFixed(3) + 'KG')

    $.each(data, function (i, val) {
        if (val.ProcessWgt) {
            PrWg += Number(val.ProcessWgt);
        }
    })
    $('#productionWeight').html(PrWg.toFixed(3) + 'KG')
}
function calAvgGrossRecoveryTofish(data) {
    avgArray = [];
    var fishnames = createFishNameArr(data);

    $.each(fishnames, function (i, fish) {
        var grossRecWh = 0;
        var grossReCountWh = 0;
        var grossRecLn = 0;
        var grossReCountLn = 0;
        var netRecWh = 0;
        var netReCountWh = 0;
        var netRecLn = 0;
        var netReCountLn = 0;
        var exRecWh = 0;
        var exReCountWh = 0;
        var exRecLn = 0;
        var exReCountLn = 0;

        $.each(data, function (i, val) {
            if (fish == val.FishName && Number(val.item_process_mode) == 0) {
                grossRecWh += ((Number(val.gross_prod_wg) / Number(val.batch_weight)) * 100)
                grossReCountWh++;
            }
        })
        $.each(data, function (i, val) {

            if (fish == val.FishName && Number(val.item_process_mode) == 1) {
                grossRecLn += ((Number(val.gross_prod_wg) / Number(val.batch_weight)) * 100)
                grossReCountLn++;
            }
        })
        $.each(data, function (i, val) {
            if (fish == val.FishName && Number(val.item_process_mode) == 0) {
                netRecWh += ((Number(val.net_prod_wg) / Number(val.batch_weight)) * 100)
                netReCountWh++;
            }
        })
        $.each(data, function (i, val) {

            if (fish == val.FishName && Number(val.item_process_mode) == 1) {
                netRecLn += ((Number(val.net_prod_wg) / Number(val.batch_weight)) * 100)
                netReCountLn++;
            }
        })
        $.each(data, function (i, val) {
            if (fish == val.FishName && Number(val.item_process_mode) == 0) {
                exRecWh += ((Number(val.exp_wg) / Number(val.batch_weight)) * 100)
                exReCountWh++;
            }
        })
        $.each(data, function (i, val) {

            if (fish == val.FishName && Number(val.item_process_mode) == 1) {
                exRecLn += ((Number(val.exp_wg) / Number(val.batch_weight)) * 100)
                exReCountLn++;
            }
        })

        var avgLnRecGross = grossRecLn / grossReCountLn;
        var avgWhRecGross = grossRecWh / grossReCountWh;
        var avgLnRecNet = netRecLn / netReCountLn;
        var avgWhRecNet = netRecWh / netReCountWh;
        var avgLnRecEx = exRecLn / exReCountLn;
        var avgWhRecEx = exRecWh / exReCountWh;

        avgArray[fish] = {
            'avgLnRecGross': avgLnRecGross.toFixed(2) + '%',
            'avgWhRecGross': avgWhRecGross.toFixed(2) + '%',
            'avgLnRecNet': avgLnRecNet.toFixed(2) + '%',
            'avgWhRecNet': avgWhRecNet.toFixed(2) + '%',
            'avgLnRecEx': avgLnRecEx.toFixed(2) + '%',
            'avgWhRecEx': avgWhRecEx.toFixed(2) + '%',
        }
    });
    console.log(avgArray);
    setAvgsToTheFish()
}
function setAvgsToTheFish() {
    var fish = $("#fishTypeAvgSelector option:selected").text().trim();
    console.log(avgArray[fish]);
    $('#avgLnRecGross').html(avgArray[fish]['avgLnRecGross'])
    $('#avgWhRecGross').html(avgArray[fish]['avgWhRecGross'])
    $('#avgLnRecNet').html(avgArray[fish]['avgLnRecNet'])
    $('#avgWhRecNet').html(avgArray[fish]['avgWhRecNet'])
    $('#avgLnRecEx').html(avgArray[fish]['avgLnRecEx'])
    $('#avgWhRecEx').html(avgArray[fish]['avgWhRecEx'])



}
function createFishNameArr(data) {
    var fishnames = [];
    $.each(data, function (i, val) {
        var notadded = true;
        $.each(fishnames, function (i, fish) {
            if (fish == val.FishName) {
                notadded = false;
            }
        });
        if (notadded) {
            fishnames.push(val.FishName)
        }

    });
    return fishnames;
}
function Yield(val1, val2) {
    return ((Number(val1) / Number(val2)) * 100).toFixed(2) + '%';
}

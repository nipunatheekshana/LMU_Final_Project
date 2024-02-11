
console.log('purchaseAnalytics.js Loading');
//charts
var annual_purchase_bar_options = {
    chart: {
        height: 350,
        type: 'bar',
        animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 1500,

        }

    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '40%'
        },
    },

    colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B'],

    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    series: [{
        name: 'Total Purchase',
        data: []
    }],
    xaxis: {
        categories: [],
    },
    yaxis: {
        // title: {
        //     text: 'Weight (Kg)'
        // },
        // min: 18500 * 0.992,
        // max: 18680 * 1.002,
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + "Kg"
            }
        }
    }
}
var annual_purchase_bar_chart = new ApexCharts(
    document.querySelector("#annual_purchase_bar"),
    annual_purchase_bar_options
);
annual_purchase_bar_chart.render();


var annual_purchase_line_options = {
    chart: {
        height: 350,
        type: 'area',
        animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 1500,

        }

    },

    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    series: [{
        name: 'Total Purchase',
        data: []
    }],
    xaxis: {
        categories: [],
    },
    yaxis: {
        title: {
            text: 'Weight (Kg)'
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + "Kg"
            }
        }
    }
}
var annual_purchase_line_chart = new ApexCharts(
    document.querySelector("#annual_purchase_line"),
    annual_purchase_line_options
);
annual_purchase_line_chart.render();


var annual_purchase_grade_line_options = {
    chart: {
        height: 350,
        type: 'area',
        animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 1500,

        }

    },

    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    series: [],
    xaxis: {
        categories: [],
    },
    yaxis: {
        title: {
            text: 'Weight (Kg)'
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + "Kg"
            }
        }
    }
}
var annual_purchase_grade_line_chart = new ApexCharts(
    document.querySelector("#annual_purchase_grade_line"),
    annual_purchase_grade_line_options
);
annual_purchase_grade_line_chart.render();


var annual_purchase_grade_bar_options = {
    chart: {
        height: 350,
        type: 'bar',
        animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 1500,
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '75%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    series: [],
    xaxis: {
        categories: [],
    },
    yaxis: {
        title: {
            text: 'Weight (Kg)'
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + "Kg"
            }
        }
    }
}
var annual_purchase_grade_bar_chart = new ApexCharts(
    document.querySelector("#annual_purchase_grade_bar"),
    annual_purchase_grade_bar_options
);
annual_purchase_grade_bar_chart.render();


var annual_purchase_grade_stack_options = {
    chart: {
        height: 350,
        type: 'bar',
        stacked: true,
        stackType: '100%',
        animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 1500,
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '50%'
        },
    },
    responsive: [{
        breakpoint: 480,
        options: {
            legend: {
                position: 'bottom',
                offsetX: -10,
                offsetY: 0
            }
        }
    }],
    series: [],
    xaxis: {
        categories: [],
    },
    yaxis: {
        title: {
            text: 'Weight (Kg)'
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + "Kg"
            }
        }
    }
}
var annual_purchase_grade_stack_chart = new ApexCharts(
    document.querySelector("#annual_purchase_grade_stack"),
    annual_purchase_grade_stack_options
);
annual_purchase_grade_stack_chart.render();


var annual_purchase_size_line_options = {
    chart: {
        height: 350,
        type: 'area',
        animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 1500,

        }

    },

    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    series: [],
    xaxis: {
        categories: [],
    },
    yaxis: {
        title: {
            text: 'Weight (Kg)'
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + "Kg"
            }
        }
    }
}
var annual_purchase_size_line_chart = new ApexCharts(
    document.querySelector("#annual_purchase_size_line"),
    annual_purchase_size_line_options
);
annual_purchase_size_line_chart.render();


var annual_purchase_size_stack_options = {
    chart: {
        height: 350,
        type: 'bar',
        stacked: true,
        stackType: '100%',
        animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 1500,
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '50%'
        },
    },
    responsive: [{
        breakpoint: 480,
        options: {
            legend: {
                position: 'bottom',
                offsetX: -10,
                offsetY: 0
            }
        }
    }],
    series: [],
    xaxis: {
        categories: [],
    },
    yaxis: {
        title: {
            text: 'Weight (Kg)'
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + "Kg"
            }
        }
    }
}
var annual_purchase_size_stack_chart = new ApexCharts(
    document.querySelector("#annual_purchase_size_stack"),
    annual_purchase_size_stack_options
);
annual_purchase_size_stack_chart.render();


var annual_purchase_grade_avg_price_line_options = {
    chart: {
        height: 350,
        type: 'area',
        animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 1500,

        }

    },

    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    series: [],
    xaxis: {
        categories: [],
    },
    yaxis: {
        title: {
            text: 'Price (US $)'
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "US $" + val
            }
        }
    }
}
var annual_purchase_grade_avg_price_line_chart = new ApexCharts(
    document.querySelector("#annual_purchase_grade_avg_price_line"),
    annual_purchase_grade_avg_price_line_options
);
annual_purchase_grade_avg_price_line_chart.render();


var annual_purchase_avg_price_bar_options = {
    chart: {
        height: 350,
        type: 'bar',
        animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 1500,

        }

    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '40%'
        },
    },

    colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B'],

    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    series: [{
        name: 'Average Price',
        data: []
    }],
    xaxis: {
        categories: [],
    },
    yaxis: {
        title: {
            text: 'Price (US $)'
        },
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "US $" + val
            }
        }
    }
}
var annual_purchase_avg_price_bar_chart = new ApexCharts(
    document.querySelector("#annual_purchase_avg_price_bar"),
    annual_purchase_avg_price_bar_options
);
annual_purchase_avg_price_bar_chart.render();


$(document).ready(function () {

    // Tables

    var tableGradeWisePurchase = $('#tableGradeWisePurchase').DataTable({
        pageLength: 25,
        scrollX: false,
        scrollCollapse: true,
        colReorder: true,
        paging: false,
        searching: false,
        info: false,

        'columnDefs': [
            {
                "targets": [0, 1, 2, 3, 4],
                "className": "text-center",
                "orderable": true,
            }
        ],

        "order": [],
        "columns": [
            { "data": "thGrade" },
            { "data": "thYear1" },
            { "data": "thYear2" },
            { "data": "thYear3" },
            { "data": "thYear4" },
            { "data": "thYear5" }
        ],
    });

    var tableSizeWisePurchase = $('#tableSizeWisePurchase').DataTable({
        pageLength: 25,
        scrollX: false,
        scrollCollapse: true,
        colReorder: true,
        paging: false,
        searching: false,
        info: false,

        'columnDefs': [
            {
                "targets": [0, 1, 2, 3, 4],
                "className": "text-center",
                "orderable": true,
            }
        ],

        "order": [],
        "columns": [
            { "data": "thSize" },
            { "data": "thYear1" },
            { "data": "thYear2" },
            { "data": "thYear3" },
            { "data": "thYear4" },
            { "data": "thYear5" }
        ],
    });

    var tableGradeWiseAvgPrice = $('#tableGradeWiseAvgPrice').DataTable({
        pageLength: 25,
        scrollX: false,
        scrollCollapse: true,
        colReorder: true,
        paging: false,
        searching: false,
        info: false,

        'columnDefs': [
            {
                "targets": [0, 1, 2, 3, 4],
                "className": "text-center",
                "orderable": true,
            }
        ],

        "order": [],
        "columns": [
            { "data": "thGrade" },
            { "data": "thYear1" },
            { "data": "thYear2" },
            { "data": "thYear3" },
            { "data": "thYear4" },
            { "data": "thYear5" }
        ],
    });


    // Events

    $('#fishtype').change(function () {
        var fishtype = $('#fishtype').val();

        loadAnnualPurchaseGradeWeight(fishtype);
        loadAnnualPurchaseSizeWeight(fishtype);
        loadAnnualPurchaseGradePrice(fishtype);
        updateAnnualPurchaseSumCharts(fishtype);
        updateAnnualAvaragePriceCharts(fishtype);
        saveSelection(this.value);
    });

    setTableHeaders();
    loadFishSpecies();
    loadPreviousFishData();
});


// Charts Loading Functions
function updateAnnualPurchaseSumCharts(fishtype) {
    $.ajax({
        type: 'GEt',
        url: '/buying/purchaseAnalytics/updateAnnualPurchaseSumCharts',
        data: { 'fishtype': fishtype },
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = getData(response.result);
                var years = getYears()

                //update Bar Chart
                annual_purchase_bar_chart.updateOptions({
                    series: [{
                        name: 'Total Purchase',
                        data: data
                    }],
                    xaxis: {
                        categories: years,
                    },
                    yaxis: {
                        title: {
                            text: 'Weight (Kg)'
                        },
                        min: Math.min.apply(Math, data) * 0.992,
                        max: Math.max.apply(Math, data) * 1.002,
                    },
                })
                //Update Line Chart
                annual_purchase_line_chart.updateOptions({
                    series: [{
                        name: 'Total Purchase',
                        data: data
                    }],
                    xaxis: {
                        categories: years,
                    },
                    yaxis: {
                        title: {
                            text: 'Weight (Kg)'
                        },
                        min: Math.min.apply(Math, data) * 0.992,
                        max: Math.max.apply(Math, data) * 1.002,
                    },
                })
            }
        }, error: function (data) {
            console.log(data)
            console.log('Something Went Wrong');
        }
    });
}
function updateAnnualPurchaseGradeWiseCharts(result) {
    var arr = []
    var years = getYears()
    $.each(result, function (i, val) {
        arr.push(
            {
                name: val.grade,
                data: getData(val)
            }
        )

    })
    console.log(arr)
    //Update Line Chart
    annual_purchase_grade_line_chart.updateOptions({
        series: arr,
        xaxis: {
            categories: years,
        },
    })
    annual_purchase_grade_bar_chart.updateOptions({
        series: arr,
        xaxis: {
            categories: years,
        },
    })
    annual_purchase_grade_stack_chart.updateOptions({
        series: arr,
        xaxis: {
            categories: years,
        },
    })
}
function updateAnnualPurchaseSizeWiseCharts(result) {
    var arr = []
    var years = getYears()
    $.each(result, function (i, val) {
        arr.push(
            {
                name: val.SizeDescription,
                data: getData(val)
            }
        )

    })
    console.log(arr)
    //Update Line Chart
    annual_purchase_size_line_chart.updateOptions({
        series: arr,
        xaxis: {
            categories: years,
        },
    })
    annual_purchase_size_stack_chart.updateOptions({
        series: arr,
        xaxis: {
            categories: years,
        },
    })

}
function updateAnnualGradeWisePriceChart(result) {
    var arr = []
    var years = getYears()
    $.each(result, function (i, val) {
        arr.push(
            {
                name: val.pay_grade,
                data: getData(val)
            }
        )

    })
    console.log(arr)
    //Update Line Chart
    annual_purchase_grade_avg_price_line_chart.updateOptions({
        series: arr,
        xaxis: {
            categories: years,
        },
    })

}
function updateAnnualAvaragePriceCharts(fishtype) {
    $.ajax({
        type: 'GEt',
        url: '/buying/purchaseAnalytics/updateAnnualAvaragePriceCharts',
        data: { 'fishtype': fishtype },
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = getData(response.result);
                var years = getYears()

                //update Bar Chart
                annual_purchase_avg_price_bar_chart.updateOptions({
                    series: [{
                        name: 'Total Purchase',
                        data: data
                    }],
                    xaxis: {
                        categories: years,
                    },
                    yaxis: {
                        title: {
                            text: 'Price ($)'
                        },
                        min: Math.min.apply(Math, data) * 0.992,
                        max: Math.max.apply(Math, data) * 1.002,
                    },
                })

            }
        }, error: function (data) {
            console.log(data)
            console.log('Something Went Wrong');
        }
    });
}
function getYears() {
    var yearArr = []
    var year = new Date().getFullYear() - 4;
    for (let i = 0; i < 5; i++) {
        yearArr.push(year + i);
    }
    return yearArr;
}
function getData(data) {
    var dataArr = [];
    for (let i = 1; i < 6; i++) {
        dataArr.push(data['Year' + i])
    }
    return dataArr;
}
// Tables Loading Functions

function setTableHeaders() {
    var tableGradeWisePurchase = $('#tableGradeWisePurchase').DataTable();
    var tableSizeWisePurchase = $('#tableSizeWisePurchase').DataTable();
    var tableGradeWiseAvgPrice = $('#tableGradeWiseAvgPrice').DataTable();

    // console.log( new Date().getFullYear()-5)
    var year = new Date().getFullYear() - 4;
    for (let i = 0; i < 5; i++) {
        $(tableGradeWisePurchase.column(i + 1).header()).text(year + i);
        $(tableSizeWisePurchase.column(i + 1).header()).text(year + i);
        $(tableGradeWiseAvgPrice.column(i + 1).header()).text(year + i);
    }

}

function loadAnnualPurchaseGradeWeight(fishtype) {
    $.ajax({
        type: 'GEt',
        url: '/buying/purchaseAnalytics/loadAnnualPurchaseGradeWeight',
        data: { 'fishtype': fishtype },
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = [];
                $.each(response.result, function (i, val) {

                    data.push({
                        "thGrade": val.grade,
                        "thYear1": val.Year1 + 'Kg',
                        "thYear2": val.Year2 + 'Kg',
                        "thYear3": val.Year3 + 'Kg',
                        "thYear4": val.Year4 + 'Kg',
                        "thYear5": val.Year5 + 'Kg',
                    });
                });
                var table = $('#tableGradeWisePurchase').DataTable();
                table.clear();
                table.rows.add(data).draw();

                updateAnnualPurchaseGradeWiseCharts(response.result)
            }
        }, error: function (data) {
            console.log(data)
            console.log('Something Went Wrong');
        }
    });
};

function loadAnnualPurchaseSizeWeight(fishtype) {

    $.ajax({
        type: 'GET',
        url: '/buying/purchaseAnalytics/loadAnnualPurchaseSizeWeight',
        data: { 'fishtype': fishtype },
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                $.each(response.result, function (i, val) {

                    data.push({
                        "thSize": val.SizeDescription,
                        "thYear1": val.Year1 + 'Kg',
                        "thYear2": val.Year2 + 'Kg',
                        "thYear3": val.Year3 + 'Kg',
                        "thYear4": val.Year4 + 'Kg',
                        "thYear5": val.Year5 + 'Kg',
                    });
                });
                var table = $('#tableSizeWisePurchase').DataTable();
                table.clear();
                table.rows.add(data).draw();

                updateAnnualPurchaseSizeWiseCharts(response.result)
            }
        }, error: function (data) {
            console.log(data)
            console.log('Something Went Wrong');
        }
    });
};

function loadAnnualPurchaseGradePrice(fishtype) {
    $.ajax({
        type: 'GET',
        url: '/buying/purchaseAnalytics/loadAnnualPurchaseGradePrice',
        data: { 'fishtype': fishtype },
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                $.each(response.result, function (i, val) {

                    data.push({
                        "thGrade": val.pay_grade,
                        "thYear1": '$' + val.Year1,
                        "thYear2": '$' + val.Year2,
                        "thYear3": '$' + val.Year3,
                        "thYear4": '$' + val.Year4,
                        "thYear5": '$' + val.Year5,
                    });
                });
                var table = $('#tableGradeWiseAvgPrice').DataTable();
                table.clear();
                table.rows.add(data).draw();

                updateAnnualGradeWisePriceChart(response.result);
            }
        }, error: function (data) {
            console.log(data)
            console.log('Something Went Wrong');
        }
    });
};
// Other Functions

function loadFishSpecies() {
    $.ajax({
        type: 'GET',
        url: '/buying/purchaseAnalytics/loadFishSpecies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FishName + ' </option>';
                });
                $('#fishtype').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
};
function saveSelection(fishId) {
    $.ajax({
        type: 'POST',
        url: '/buying/purchaseAnalytics/saveSelection',
        data: { 'fishId': fishId },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response)
            if (response.success) {


            }
        }, error: function (data) {
            console.log(data)
            console.log('Something Went Wrong');
        }
    });
}
function loadPreviousFishData() {
    $.ajax({
        type: 'GEt',
        url: '/buying/purchaseAnalytics/loadPreviousFishData',
        success: function (response) {
            console.log(response.result)
            if (response.success && response.result != null) {

                var fishtype = response.result;

                $('#fishtype').val(fishtype);
                loadAnnualPurchaseGradeWeight(fishtype);
                loadAnnualPurchaseSizeWeight(fishtype);
                loadAnnualPurchaseGradePrice(fishtype);
                updateAnnualPurchaseSumCharts(fishtype);
                updateAnnualAvaragePriceCharts(fishtype);
            }
        }, error: function (data) {
            console.log(data)
            console.log('Something Went Wrong');
        }
    });
}
